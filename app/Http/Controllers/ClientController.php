<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCategory;
use App\Models\UserEmailAuthorization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function getClients()
    {
        $clients = User::with('company','categories','email_auth')->where("user_type", "client")->get();
        return response()->json([
            'clients' => $clients
        ], 200);
    }
    public function addClient(Request $request)
    {
        //Add Comnpany
        $company = new Company();
        $company->company_name = $request->company_name;
        $company->company_phone = $request->company_phone;
        $company->quotation_serial = $request->quotation_serial;
        $company->company_address = $request->company_address;
        $exploded_logo = explode(',', $request->company_logo);
        $decoded_logo = base64_decode($exploded_logo[1]);
        if (str_contains($exploded_logo[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileNameLogo = Str::random() . '.' . $extension;
        $pathLogo = public_path() . '/logos/' . $fileNameLogo;
        file_put_contents($pathLogo, $decoded_logo);
        $company->company_logo = $fileNameLogo;
        $exploded_stamp = explode(',', $request->company_stamp);
        $decoded_stamp = base64_decode($exploded_stamp[1]);
        if (str_contains($exploded_stamp[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileNameStamp = Str::random() . '.' . $extension;
        $pathStamp = public_path() . '/stamps/' . $fileNameStamp;
        file_put_contents($pathStamp, $decoded_stamp);
        $company->company_stamp = $fileNameStamp;
        $company->save();
        //Add User
        $client = new User();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = Hash::make($request->password);
        $client->user_type = "client";
        $client->company_id = $company->id;
        $client->save();
        //Add User Categories
        $categories = $request->categories;
        foreach ($categories as $category) {
            $userCategory = new UserCategory();
            $userCategory->user_id = $client->id;
            $userCategory->category_id = $category;
            $userCategory->save();
        }
        //add email authorization
        $emailAuthorization = new UserEmailAuthorization();
        $emailAuthorization->user_id = $client->id;
        $emailAuthorization->company_id = $company->id;
        $emailAuthorization->email = $request->smtp_email;
        $emailAuthorization->password = $request->email_password;
        $emailAuthorization->port = $request->port;
        $emailAuthorization->service = $request->service;
        $emailAuthorization->save();
        return response()->json([
            'message' => 'Client added successfully'
        ], 200);
    }
    public function editClient(Request $request)
    {
        //Edit Company
        $user = User::find($request->id);
        $company = Company::find($user->company_id);
        $company->company_name = $request->company_name;
        $company->company_phone = $request->company_phone;
        $company->quotation_serial = $request->quotation_serial;
        $company->company_address = $request->company_address;
        if($request->company_logo)
        {
            $exploded_logo = explode(',', $request->company_logo);
            $decoded_logo = base64_decode($exploded_logo[1]);
            if (str_contains($exploded_logo[0], 'jpeg'))
                $extension = 'jpg';
            else
                $extension = 'png';
            $fileNameLogo = Str::random() . '.' . $extension;
            $pathLogo = public_path() . '/logos/' . $fileNameLogo;
            file_put_contents($pathLogo, $decoded_logo);
            $company->company_logo = $fileNameLogo;
        }
        if($request->company_stamp)
        {
            $exploded_stamp = explode(',', $request->company_stamp);
            $decoded_stamp = base64_decode($exploded_stamp[1]);
            if (str_contains($exploded_stamp[0], 'jpeg'))
                $extension = 'jpg';
            else
                $extension = 'png';
            $fileNameStamp = Str::random() . '.' . $extension;
            $pathStamp = public_path() . '/stamps/' . $fileNameStamp;
            file_put_contents($pathStamp, $decoded_stamp);
            $company->company_stamp = $fileNameStamp;
        }
        $company->save();
        //Edit User
        $client = User::find($request->id);
        $client->name = $request->name;
        $client->email = $request->email;
        if($request->password)
        {
            $client->password = Hash::make($request->password);
        }
        $client->save();
        //Delete User Categories
        $userCategories = UserCategory::where('user_id', $client->id)->get();
        if($userCategories){
            foreach ($userCategories as $userCategory) {
                $userCategory->delete();
            }
        }
        //Add User Categories
        $categories = $request->categories;
        foreach ($categories as $category) {
            $userCategory = new UserCategory();
            $userCategory->user_id = $client->id;
            $userCategory->category_id = $category;
            $userCategory->save();
        }
        //Edit email authorization
        $emailAuthorization = UserEmailAuthorization::where('user_id', $client->id)->first();
        if($emailAuthorization)
        {
        $emailAuthorization->user_id = $client->id;
        $emailAuthorization->company_id = $company->id;
        $emailAuthorization->email = $request->smtp_email;
        $emailAuthorization->password = $request->email_password;
        $emailAuthorization->port = $request->port;
        $emailAuthorization->service = $request->service;
        $emailAuthorization->save();
        }
        else {
            $emailAuthorization = new UserEmailAuthorization();
            $emailAuthorization->user_id = $client->id;
            $emailAuthorization->company = $company->id;
            $emailAuthorization->email = $request->smtp_email;
            $emailAuthorization->password = $request->email_password;
            $emailAuthorization->port = $request->port;
            $emailAuthorization->service = $request->service;
            $emailAuthorization->save();
        }
        return response()->json([
            'message' => 'Client updated successfully'
        ], 200);
    }
    public function deleteClient(Request $request)
    {
        $client = User::find($request->id);
        $company = Company::find($client->company_id);
        $company->delete();
        $categories = UserCategory::where('user_id', $client->id)->get();
        if($categories){
            foreach ($categories as $category) {
                $category->delete();
            }
        }
        $emailAuthorization = UserEmailAuthorization::where('user_id', $client->id)->first();
        if($emailAuthorization)
        {
            $emailAuthorization->delete();
        }
        $client->delete();
        return response()->json([
            'message' => 'Client deleted successfully'
        ], 200);
    }
    public function getClientById($id)
    {
        $client = User::with('company','categories')->find($id);
        $categories = UserCategory::where('user_id', $client->id)->get();
        return response()->json([
            'client' => $client,
            'categories' => $categories
        ], 200);
    }
    public function getClientByToken()
    {
        $user = auth()->user();
        $client = User::with('company','categories')->find($user->id);
        $emailAuthorization = UserEmailAuthorization::where('company_id', $client->company_id)->first();
        return response()->json([
            'client' => $client,
            'email_auth' => $emailAuthorization
        ], 200);
    }
}
