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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientInvoiceController extends Controller
{
    public function getClientInvoices()
    {
        $user = auth()->user();
        $client_invoices = ClientInvoice::with('user.company')->where('company_id',$user->company_id)->orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'client_invoices' => $client_invoices
        ], 200);
    }
    public function addClientInvoice(Request $request)
    {
        $user = auth()->user();
        $client_query = ClientQuery::where('id',$request->qrf_id)->first();
        $client_invoice = new ClientInvoice();
        $client_invoice->user_id = $user->id;
        $client_invoice->company_id = $user->company_id;
        $client_invoice->client_query_id = $request->qrf_id;
        $client_invoice->frieght_charges = $request->frieght_charges;
        $client_invoice->sales_tax = $request->sales_tax;
        $client_invoice->sub_total = $request->sub_total;
        $client_invoice->total = $request->sub_total + $request->frieght_charges + $request->sales_tax;
        $client_invoice->save();
        $client_invoice_products = $request->client_invoice_products;
        foreach ($client_invoice_products as $client_invoice_product) {
            $client_invoiceProduct = new ClientInvoiceProduct();
            $client_invoiceProduct->client_invoice_id = $client_invoice->id;
            $client_invoiceProduct->product_id = $client_invoice_product['product_id'];
            $client_invoiceProduct->quantity = $client_invoice_product['quantity'];
            $client_invoiceProduct->sku = $client_invoice_product['sku'];
            $client_invoiceProduct->size = $client_invoice_product['size'];
            $client_invoiceProduct->price = $client_invoice_product['price'];
            $client_invoiceProduct->total = $client_invoice_product['total'];
            $client_invoiceProduct->save();
        }
        $client_query->status = 'approved';
        $client_query->save();

        return response()->json([
            'message' => 'Invoice created successfully'
        ], 200);
    }
    public function deleteClientInvoice($id)
    {
        $client_invoice = ClientInvoice::find($id);
        $client_invoice->delete();
        return response()->json([
            'message' => 'Successfully deleted invoice!'
        ], 200);
    }
}
