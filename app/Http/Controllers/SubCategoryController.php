<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function getSubCategories()
    {
        $subCategories = SubCategory::all();
        return response()->json([
            'subCategories' => $subCategories
        ], 200);
    }
    public function addSubCategory(Request $request)
    {
        $subCategory = new SubCategory();
        $subCategory->sub_category_name = $request->sub_category_name;
        //slug is the url friendly version of the subCategory name
        $subCategory->sub_category_slug = Str::slug($request->sub_category_name);
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        return response()->json([
            'message' => 'SubCategory added successfully'
        ], 200);
    }
    public function editSubCategory(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        $subCategory->sub_category_name = $request->sub_category_name;
        //slug is the url friendly version of the subCategory name
        $subCategory->sub_category_slug = Str::slug($request->sub_category_name);
        $subCategory->category_id = $request->category_id;
        $subCategory->save();
        return response()->json([
            'message' => 'SubCategory updated successfully'
        ], 200);
    }
    public function deleteSubCategory(Request $request)
    {
        $subCategory = SubCategory::find($request->id);
        $subCategory->delete();
        return response()->json([
            'message' => 'SubCategory deleted successfully'
        ], 200);
    }
    public function getSubCategoryById($id)
    {
        $subCategory = SubCategory::find($id);
        return response()->json([
            'subCategory' => $subCategory
        ], 200);
    }
}
