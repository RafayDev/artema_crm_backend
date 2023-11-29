<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Query;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class QueryController extends Controller
{
    public function getQueries()
    {
        $queries = Query::orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'qrfs' => $queries
        ], 200);
    }
    public function addQuery(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();
        foreach ($carts as $cart) {
            $query = new Query();
            $query->user_id = $user->id;
            $query->product_id = $cart->product_id;
            $query->quantity = $cart->quantity;
            $query->sku = $cart->sku;
            $query->size = $cart->size;
            $query->save();
            $cart->delete();
        }
        $admins = User::where('user_type', 'admin')->orwhere('user_type','admin-user')->orwhere('user_type','manager')->get();
        foreach ($admins as $admin) {
            $notification = new Notification();
            $notification->from_user_id = $user->id;
            $notification->to_user_id = $admin->id;
            $notification->message = 'New inquiry from ' . $user->name;
            $notification->save();
        }
        return response()->json([
            'message' => 'Inquiry send successfully'
        ], 200);
    }
    public function deleteQuery($id)
    {
        $query = Query::find($id);
        $query->delete();
        return response()->json([
            'message' => 'Qrf deleted successfully'
        ], 200);
    }
}
