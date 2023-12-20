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
use App\Models\ClientInvoice;
use App\Models\ClientInvoiceProduct;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Company;
use App\Models\ClientOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientOrderController extends Controller
{
    public function getClientOrders()
    {
        $user = auth()->user();
        if($user->user_type == 'client_user'){
            $client_orders = ClientOrder::with('user.company')->where('user_id',$user->id)->orderBy('id', 'desc')->paginate(24);
            return response()->json([
                'client_orders' => $client_orders
            ], 200);
        } else {
            $client_orders = ClientOrder::with('user.company')->where('company_id',$user->company_id)->orderBy('id', 'desc')->paginate(24);
            return response()->json([
                'client_orders' => $client_orders
            ], 200);
        }
    }
    public function createClientOrder(Request $request)
    {
        $user = auth()->user();
        $client_invoice = ClientInvoice::where('id',$request->invoice_id)->first();
        $client_order = new ClientOrder();
        $client_order->user_id = $client_invoice->user_id;
        $client_order->company_id = $user->company_id;
        $client_order->client_invoice_id = $client_invoice->id;
        $client_order->status = 'in-process';
        $client_order->save();
        $client_invoice->status = 'paid';
        $client_invoice->save();
        return response()->json([
            'client_order' => $client_order
        ], 200);
    }
    public function changeClientOrderStatus(Request $request)
    {
        $client_order = ClientOrder::find($request->id);
        $client_order->status = $request->status;
        $client_order->tracking_no = $request->tracking_no;
        $client_order->courier = $request->courier;
        $client_order->save();
        return response()->json([
            'success' => 'Order status changed successfully'
        ], 200);
    }
}
