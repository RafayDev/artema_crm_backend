<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\ReceiptProduct;
use App\Models\Product;
use App\Models\Company;
use App\Models\Cart;
use App\Models\CartProduct;

class ReceiptController extends Controller
{
    public function getReceipts()
    {
        $user = auth()->user();
        $receipts = Receipt::where('company_id', $user->company_id)->get();
        return response()->json($receipts);
    }
    public function addReceipt(Request $request)
    {
        $user = auth()->user();
        $receipt = new Receipt();
        $receipt->first_name = $request->first_name;
        $receipt->last_name = $request->last_name;
        $receipt->email = $request->email;
        $receipt->address = $request->address;
        $receipt->city = $request->city;
        $receipt->state = $request->state;
        $receipt->zip = $request->zip;
        $receipt->country = $request->country;
        $receipt->sub_total = $request->sub_total;
        $receipt->total = $request->total;
        $receipt->company_id = $user->company_id;
        $receipt->save();
        $cart = Cart::where('user_id', $user->id)->first();
        $cartProducts = CartProduct::where('cart_id', $cart->id)->get();
        foreach ($cartProducts as $cartProduct) {
            $receiptProduct = new ReceiptProduct();
            $receiptProduct->receipt_id = $receipt->id;
            $receiptProduct->product_id = $cartProduct->product_id;
            $receiptProduct->quantity = $cartProduct->quantity;
            $product = Product::find($cartProduct->product_id);
            $receiptProduct->price = $cartProduct->price;
            $receiptProduct->sku = $cartProduct->sku;
            $receiptProduct->size = $cartProduct->size;
            $receiptProduct->total = $cartProduct->price * $cartProduct->quantity;
            $receiptProduct->save();
        }
        return response()->json($receipt);
    }
    public function deleteReceipt($id)
    {
        $receipt = Receipt::find($id);
        // delete all receipt products
        $receiptProducts = ReceiptProduct::where('receipt_id', $receipt->id)->get();
        foreach ($receiptProducts as $receiptProduct) {
            $receiptProduct->delete();
        }
        $receipt->delete();
        return response()->json('receipt removed successfully');
    }
}
