<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\ClientInvoice;
use App\Models\Product;
use App\Models\Query;
use App\Models\ClientQuery;
use App\Models\Order;
use App\Models\ClientOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if($user->user_type == 'client' || $user->user_type == 'client_user'){
            $invoices = ClientInvoice::where('company_id',$user->company_id)->count();
            $orders = ClientOrder::where('company_id',$user->company_id)->count();
            $queries = ClientQuery::where('company_id',$user->company_id)->count();
            $products = Product::count();
            $users = User::where('company_id',$user->company_id)->count();
            return response()->json([
                'invoices' => $invoices,
                'orders' => $orders,
                'queries' => $queries,
                'products' => $products,
                'users' => $users
            ], 200);
        } else {
            $invoice = Invoice::count();
            $order = Order::count();
            $query = Query::count();
            $product = Product::count();
            $users = User::where('user_type','client')->count();
            return response()->json([
                'invoices' => $invoice,
                'orders' => $order,
                'queries' => $query,
                'products' => $product,
                'users' => $users
            ], 200);
        }
    }
}
