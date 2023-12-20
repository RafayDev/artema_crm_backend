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
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice = Invoice::find($invoice_id);
        $invoice->status = 'paid';
        $invoice->save();
        $order = new Order();
        $order->user_id = $invoice->user_id;
        $order->invoice_id = $invoice_id;
        $order->status = 'in-progress';
        $order->save();
    }
    public function getOrders()
    {
        $user = auth()->user();
        $orders = Order::with('user.company')->orderBy('id', 'desc')->paginate(24);
        if ($user->user_type == 'client') {
            $orders = Order::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(24);
        } 
        return response()->json([
            'orders' => $orders
        ], 200);
    }
    public function changeOrderStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->tracking_no = $request->tracking_no;
        $order->courier = $request->courier;
        $order->save();
        return response()->json([
            'success' => 'Order status changed successfully'
        ], 200);
    }
}
