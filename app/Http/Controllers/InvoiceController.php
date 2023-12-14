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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function getInvoices()
    {
        $user = auth()->user();
        $invoices = Invoice::with('user.company')->orderBy('id', 'desc')->paginate(24);
        if ($user->user_type == 'client') {
            $invoices = Invoice::with('user.company')->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(24);
        }
        if ($user->user_type == 'client-user') {
            $company = $user->company;
            $user = User::where('company_id', $company->id)->where('user_type', 'client')->first();
            $invoices = Invoice::with('user.company')->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(24);
        }
        return response()->json([
            'invoices' => $invoices
        ], 200);
    }
    public function addInvoice(Request $request)
    {
        $user = auth()->user();
        $query = Query::find($request->qrf_id);
        $invoice = new Invoice();
        $invoice->user_id = $query->user_id;
        $invoice->query_id = $request->qrf_id;
        $invoice->frieght_charges = $request->frieght_charges;
        $invoice->sales_tax = $request->sales_tax;
        $invoice->sub_total = $request->sub_total;
        $invoice->total = $request->sub_total + $request->frieght_charges + $request->sales_tax;
        $invoice->status = 'unpaid';
        $invoice->save();
        $invoice_products = $request->invoice_products;
        foreach ($invoice_products as $invoice_product) {
            $invoiceProduct = new InvoiceProduct();
            $invoiceProduct->invoice_id = $invoice->id;
            $invoiceProduct->product_id = $invoice_product['product_id'];
            $invoiceProduct->quantity = $invoice_product['quantity'];
            $invoiceProduct->sku = $invoice_product['sku'];
            $invoiceProduct->size = $invoice_product['size'];
            $invoiceProduct->price = $invoice_product['price'];
            $invoiceProduct->total = $invoice_product['total'];
            $invoiceProduct->save();
        }
        $query->status = 'approved';
        $query->save();
        //send notification to client
        $notification = new Notification();
        $notification->from_user_id = $user->id;
        $notification->to_user_id = $invoice->user_id;
        $notification->message = "Your Quotation are now converted into invoice.";
        $notification->save();
        return response()->json([
            'message' => 'Invoice created successfully'
        ], 200);
    }
    public function deleteInvoice($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        $invoiceProducts = InvoiceProduct::where('invoice_id', $id)->get();
        foreach ($invoiceProducts as $invoiceProduct) {
            $invoiceProduct->delete();
        }
        return response()->json([
            'message' => 'Invoice deleted successfully'
        ], 200);
    }
    public function getInvoiceProducts($id)
    {
        $invoiceProducts = InvoiceProduct::with('product')->where('invoice_id', $id)->get();
        return response()->json([
            'invoiceProducts' => $invoiceProducts
        ], 200);
    }
    public function viewInvoice($id)
    {
        $invoice = Invoice::find($id);
        $invoiceProducts = InvoiceProduct::with('product')->where('invoice_id', $id)->get();
        $user = User::find($invoice->user_id);
        $company = $user->company;
        $pdf = PDF::loadView('pdf.invoice', compact('invoice', 'invoiceProducts', 'company', 'user'));
        return $pdf->stream();
    }
    public function statusChange(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = $request->status;
        $invoice->save();
        return response()->json([
            'message' => 'Status changed successfully'
        ], 200);
    }
    public function attachPaymentProof(Request $request)
    {
        $invoice = Invoice::find($request->id);
    
        // Convert base64 to file
        $exploded = explode(',', $request->payment_proof);
        $decoded = base64_decode($exploded[1]);
    
        // Determine file extension
        $extension = '';
        if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } elseif (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } elseif (str_contains($exploded[0], 'pdf')) {
            $extension = 'pdf';
        } elseif (str_contains($exploded[0], 'jpg')) {
            $extension = 'jpg';
        }
        
        if ($extension === '') {
            return response()->json([
                'error' => 'Invalid file format',
            ], 400);
        }
    
        $fileName = Str::random() . '.' . $extension;
        $path = public_path() . '/payment_proofs/' . $fileName;
    
        file_put_contents($path, $decoded);
    
        $invoice->payment_proof = $fileName;
        $invoice->save();
    
        return response()->json([
            'message' => 'Payment proof attached successfully',
        ], 200);
    }
}
