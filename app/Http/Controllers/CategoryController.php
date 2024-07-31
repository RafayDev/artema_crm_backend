<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\UserCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $user = auth()->user();
        if($user->user_type == 'client'){
            $categories_array = [];
            $user_categories = $user->categories;
            $categories = Category::whereIn('id', $user_categories->pluck('id'))->get();
            return response()->json([
                'categories' => $categories,
                // 'user' => $user
            ], 200);
        }
        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
        ], 200);
    }
    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        //slug is the url friendly version of the category name
        $category->category_slug = Str::slug($request->category_name);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'message' => 'Category added successfully'
        ], 200);
    }
    public function editCategory(Request $request)
    {
        $category = Category::find($request->id);
        $category->category_name = $request->category_name;
        //slug is the url friendly version of the category name
        $category->category_slug = Str::slug($request->category_name);
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'message' => 'Category updated successfully'
        ], 200);
    }
    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }
    public function getCategoryById($id)
    {
        $category = Category::find($id);
        return response()->json([
            'category' => $category
        ], 200);
    }
    public function assignSubCategory(Request $request)
    {
        $category_id = $request->category_id;
        $subcategories = $request->subcategories;
        //delete old subcategories
        $subcategories =CategorySubCategory::where('category_id', $category_id)->get();
        if($subcategories){
            foreach ($subcategories as $subcategory) {
                $subcategory->delete();
            }
        }
        $subcategories = $request->subcategories;
        //assign new subcategories
        foreach ($subcategories as $subcategory) {
            $categorySubCategory = new CategorySubCategory();
            $categorySubCategory->category_id = $category_id;
            $categorySubCategory->sub_category_id = $subcategory;
            $categorySubCategory->save();
        }
        return response()->json([
            'message' => 'Sub Category assigned successfully'
        ], 200);
    }
    public function getSubCategoriesByCategoryId($id)
    {
        $subcategories = CategorySubCategory::with('subCategory')->where('category_id', $id)->get();
        return response()->json([
            'subcategories' => $subcategories
        ], 200);
    }
    public function getSubCategoriesIdsArraybyCategoryId($id)
    {
        $subcategories = CategorySubCategory::where('category_id', $id)->get();
        $subcategories_ids = [];
        foreach ($subcategories as $subcategory) {
            array_push($subcategories_ids, $subcategory->sub_category_id);
        }
        return $subcategories_ids;
    }
    public function getCategoriesByUserId($id)
    {
        // print_r($id);
        // die();
        $user = User::find($id);
        $user_categories = $user->categories;
        $categories = Category::whereIn('id', $user_categories->pluck('id'))->get();
        return response()->json([
            'categories' => $categories
        ], 200);
    }
    public function getProductSlugsbyUserId($id)
    {
        $user = User::find($id);
        $user_categories = $user->categories;
        $products = Product::whereIn('category_id', $user_categories->pluck('id'))->get();
        $product_slugs = [];
        foreach ($products as $product) {
            array_push($product_slugs, $product->slug);
        }
        return response ()->json([
            'product_slugs' => $product_slugs
        ]);

    }
    public function getSubCategoriesByCategoryIdNoAuth($id)
    {
        $category = Category::find($id);
        $subcategories = CategorySubCategory::with('subCategory')->where('category_id', $id)->get();
        return response()->json([
            'subcategories' => $subcategories,
            'category' => $category
        ], 200);
    }
    public function getSubCategoriesByCategorySlug($slug)
    {
        $category = Category::where('category_slug', $slug)->first();
        $subcategories = CategorySubCategory::with('subCategory')->where('category_id', $category->id)->get();
        return response()->json([
            'subcategories' => $subcategories,
            'category' => $category
        ], 200);
    }
}
