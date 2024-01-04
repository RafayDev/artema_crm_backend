<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function register(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required|string',
        //     'email' => 'required|unique:users',
        //     'password' => 'required|min:6'
        // ]);
        // if not validate return error
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function login(Request $request)
    {

        // if not validate return error
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found!'
            ], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong password!'
            ], 401);
        }
        if ($user->is_active == 0) {
            return response()->json([
                'message' => 'User is not active!'
            ], 401);
        }
        if($user->user_form == "web")
        {
            return response()->json([
                'message' => 'Authentication failed!'
            ], 401);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $role = $user->user_type;
        return response()->json([
            'token' => $token,
            'role' => $role
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }
    public function getUsers()
    {
        $user = User::where('user_type', '!=', 'admin')->where('user_type','!=','client_user')->where('user_type','!=','client')->get();
        return response()->json([
            'users' => $user
        ], 200);
    }
    public function createUser(Request $request)
    {
        // if not validate return error
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'user_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->user_type = $request->user_type;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function editUser(Request $request)
    {
        // if not validate return error
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'user_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        if($request->password){
            $user->password =  Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'message' => 'Successfully updated user!'
        ], 200);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'Successfully deleted user!'
        ], 200);
    }
    public function getUserById($id)
    {
        $user = User::find($id);
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function registerClientUser(Request $request)
    {
        $company_id = User::find($request->user_id)->company->id;
        $email = User::where('email',$request->email)->where('company_id',$company_id)->first();
        $user_from = $request->user_from;
        if($email){
            return response()->json([
                'message' => 'Email already exists!'
            ], 422);
        }
        $user =  new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->user_type = 'client_user';
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->company_id = $company_id;
        $user->is_active = 0;
        if($user_from){
            $user->user_from = $user_from;
        }
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function getClientUsers()
    {
        $user = auth()->user();
        $users = User::where('user_type', 'client_user')->where('company_id',$user->company_id)->orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'users' => $users
        ], 200);
    }
    public function editClientUser(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        if($request->password){
            $user->password =  Hash::make($request->password);
        }
        $user->save();
        return response()->json([
            'message' => 'Successfully updated user!'
        ], 200);
    }
    public function deleteClientUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'Successfully deleted user!'
        ], 200);
    }
    public function activeUnactiveUser($id)
    {
        $user = User::find($id);
        if($user->is_active == 1){
            $user->is_active = 0;
        }else{
            $user->is_active = 1;
        }
        $user->save();
        return response()->json([
            'message' => 'Successfully updated user!'
        ], 200);
    }
    public function updateUser(Request $request){
        $user = User::find($request->id);
        $user->name = $request->first_name . " " . $request->last_name;
        $user->address = $request->address;
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        if($current_password && $new_password){
            if(Hash::check($current_password, $user->password)){
                $user->password =  Hash::make($new_password);
            }else{
                return response()->json([
                    'message' => 'Current password is wrong!'
                ], 422);
            }
        }
        $user->save();
        return response()->json([
            'message' => 'Successfully updated user!'
        ], 200);
    }
}
