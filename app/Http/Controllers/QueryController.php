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
use App\Models\QueryProduct;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class QueryController extends Controller
{
    public function getQueries()
    {
        $user = auth()->user();
        $queries = Query::with('user.company')->orderBy('id', 'desc')->paginate(24);
        if($user->user_type == 'client'){
            $queries = Query::with('user.company')->where('user_id',$user->id)->orderBy('id', 'desc')->paginate(24);
        }
        if($user->user_type == 'client-user'){
            $company = $user->company;
            $user = User::where('company_id',$company->id)->where('user_type','client')->first();
            $queries = Query::with('user.company')->where('user_id',$user->id)->orderBy('id', 'desc')->paginate(24);
        }
        return response()->json([
            'qrfs' => $queries
        ], 200);
    }
    public function addQuery(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();
        $query = new Query();
        $query->user_id = $user->id;
        $query->save();
        foreach ($carts as $cart) {
            $queryProduct = new QueryProduct();
            $queryProduct->query_id = $query->id;
            $queryProduct->product_id = $cart->product_id;
            $queryProduct->quantity = $cart->quantity;
            $queryProduct->sku = $cart->sku;
            $queryProduct->size = $cart->size;
            $queryProduct->save();
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
        $queryProducts = QueryProduct::where('query_id', $id)->get();
        foreach ($queryProducts as $queryProduct) {
            $queryProduct->delete();
        }
        return response()->json([
            'message' => 'Qrf deleted successfully'
        ], 200);
    }
    public function getQueryProducts($id)
    {
        $queryProducts = QueryProduct::with('product')->where('query_id', $id)->get();
        return response()->json([
            'queryProducts' => $queryProducts
        ], 200);
    }
    public function viewQuery($id)
    {
        $query = Query::find($id);
        $queryProducts = QueryProduct::where('query_id', $id)->get();
        $user = User::find($query->user_id);
        $company = $user->company;
        // print_r($company->company_logo);
        // die();
        $data = compact('query', 'queryProducts', 'user', 'company');
        $pdf = PDF::loadView('pdf.query', $data);
        return $pdf->stream();
    }
}
