<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ClientQuery;
use App\Models\ClientQueryProduct;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientQueryContoller extends Controller
{
    public function getClientQueries(Request $request)
    {
        $user = auth()->user();
        $search = $request->search;
        if($user->user_type == 'client_user'){
            if($user->user_from == "crm"){
                if($search != ''){
                    $client_queries = ClientQuery::with('user.company')->where('company_id',$user->company_id)->where('id', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(24);
                    return response()->json([
                        'client_qrfs' => $client_queries
                    ], 200);
                } else {
                    $client_queries = ClientQuery::with('user.company')->where('company_id',$user->company_id)->orderBy('id', 'desc')->paginate(24);
                    return response()->json([
                        'client_qrfs' => $client_queries
                    ], 200);
                }
            } else{
                if($search != ''){
                    $client_queries = ClientQuery::with('user.company')->where('user_id',$user->id)->where('id', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(24);
                    return response()->json([
                        'client_qrfs' => $client_queries
                    ], 200);
                } else {
                    $client_queries = ClientQuery::with('user.company')->where('user_id',$user->id)->orderBy('id', 'desc')->get();
                    return response()->json([
                        'client_qrfs' => $client_queries
                    ], 200);
                }
        }
        } else {
            if($search != ''){
                $client_queries = ClientQuery::with('user.company')->where('company_id',$user->company_id)->where('id', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(24);
                return response()->json([
                    'client_qrfs' => $client_queries
                ], 200);
            } else {
            $client_queries = ClientQuery::with('user.company')->where('company_id',$user->company_id)->orderBy('id', 'desc')->paginate(24);
            return response()->json([
                'client_qrfs' => $client_queries
            ], 200);
        }
        }
    }
    public function addClientQuery(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();
        $client_query = new ClientQuery();
        $client_query->user_id = $user->id;
        $client_query->company_id = $user->company_id;
        $client_query->save();
        foreach ($carts as $cart) {
            $client_queryProduct = new ClientQueryProduct();
            $client_queryProduct->client_query_id = $client_query->id;
            $client_queryProduct->product_id = $cart->product_id;
            $client_queryProduct->quantity = $cart->quantity;
            $client_queryProduct->sku = $cart->sku;
            $client_queryProduct->size = $cart->size;
            $client_queryProduct->save();
            $cart->delete();
        }
        $client = User::where('companY_id',$user->company_id)->where('user_type','client')->first();
        $notification = new Notification();
        $notification->from_user_id = $user->id;
        $notification->to_user_id = $client->id;
        $notification->message = 'New inquiry from ' . $user->name;
        $notification->save();
        return response()->json([
            'message' => 'Inquiry send successfully'
        ], 200);
    }
    public function deleteClientQuery($id)
    {
        $client_query = ClientQuery::find($id);
        $client_query->delete();
        return response()->json([
            'message' => 'Inquiry deleted successfully'
        ], 200);
    }
    public function getClientQueryProducts($id)
    {
        $client_query_products = ClientQueryProduct::with('product')->where('client_query_id', $id)->get();
        return response()->json([
            'client_query_products' => $client_query_products
        ], 200);
    }
    public function viewClientQuery($id)
    {
        $query = ClientQuery::with('user.company')->find($id);
        $queryProducts = ClientQueryProduct::with('product')->where('client_query_id', $id)->get();
        $user = User::find($query->user_id);
        $company = Company::find($query->company_id);
        $client = User::where('company_id',$company->id)->where('user_type','client')->first();
        $data = compact('query', 'queryProducts', 'user', 'company','client');
        $pdf = PDF::loadView('pdf.client_query', $data);
        return $pdf->stream();
    }
}
