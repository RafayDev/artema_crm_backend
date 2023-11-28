<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CartController extends Controller
{
    public function getCart()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->with('product')->get();
        return response()->json([
            'cart' => $cart
        ], 200);
    }
    public function addToCart(Request $request)
    {
        $user = auth()->user();
        //check if the product is already in the cart
        $cart = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->where('sku', $request->sku)->first();
        if ($cart) {
            $cart->quantity = $cart->quantity + $request->quantity;
            $cart->save();
            return response()->json([
                'message' => 'Product added to cart successfully'
            ], 200);
        }
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->sku = $request->sku;
        $product_size = ProductSize::where('product_id', $request->product_id)->where('product_sku', $request->sku)->first();
        $cart->size = $product_size->product_size;
        $cart->save();
        return response()->json([
            'message' => 'Product added to cart successfully'
        ], 200);
    }
    public function deleteFromCart(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->delete();
        return response()->json([
            'message' => 'Product deleted from cart successfully'
        ], 200);
    }
}
