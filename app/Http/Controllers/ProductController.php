<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::with('productSizes')->paginate(25);
        return response()->json([
            'products' => $products
        ], 200);
    }
    public function addProduct(Request $request)
    {
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->product_description = $request->product_description;
        //convert base64 to image and save it in the public folder
        $exploded = explode(',', $request->product_image);
        $decoded = base64_decode($exploded[1]);
        if (str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        $fileName = Str::random() . '.' . $extension;
        $path = public_path() . '/product_images/' . $fileName;
        file_put_contents($path, $decoded);
        $product->product_image = $fileName;
        $product->save();
        //save product sizes
        $product_sizes = $request->product_sizes;
        foreach ($product_sizes as $product_size) {
            $productSize = new ProductSize();
            $productSize->product_id = $product->id;
            $productSize->product_size = $product_size['product_size'];
            $productSize->product_sku = $product_size['product_sku'];
            $productSize->save();
        }
        return response()->json([
            'message' => 'Product added successfully'
        ], 200);
    }
    public function editProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->product_description = $request->product_description;
        //convert base64 to image and save it in the public folder
        if($request->product_image)
        {
            $exploded = explode(',', $request->product_image);
            $decoded = base64_decode($exploded[1]);
            if (str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            else
                $extension = 'png';
            $fileName = Str::random() . '.' . $extension;
            $path = public_path() . '/product_images/' . $fileName;
            file_put_contents($path, $decoded);
            $product->product_image = $fileName;
        }
        $product->save();
        //delete old product sizes
        $product_sizes = ProductSize::where('product_id', $product->id)->get();
        if($product_sizes){
            foreach ($product_sizes as $product_size) {
                $product_size->delete();
            }
        }
        //save product sizes
        $product_sizes = $request->product_sizes;
        foreach ($product_sizes as $product_size) {
            $productSize = new ProductSize();
            $productSize->product_id = $product->id;
            $productSize->product_size = $product_size['product_size'];
            $productSize->product_sku = $product_size['product_sku'];
            $productSize->save();
        }
        return response()->json([
            'message' => 'Product updated successfully'
        ], 200);
    }
    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
    public function getProductById($id)
    {
        $product = Product::find($id);
        $product_sizes = ProductSize::where('product_id', $product->id)->get();
        return response()->json([
            'product' => $product,
            'product_sizes' => $product_sizes
        ], 200);
    }
}