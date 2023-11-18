<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories
        ], 200);
    }
    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        //slug is the url friendly version of the category name
        $category->category_slug = Str::slug($request->category_name);
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
}
