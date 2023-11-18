<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[UserController::class,'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('/logout', [UserController::class, 'logout']);
//category routes
Route::middleware('auth:sanctum')->get('/categories', [CategoryController::class, 'getCategories']);
Route::middleware('auth:sanctum')->post('/add-category', [CategoryController::class, 'addCategory']);
Route::middleware('auth:sanctum')->post('/edit-category', [CategoryController::class, 'editCategory']);
Route::middleware('auth:sanctum')->delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);
Route::middleware('auth:sanctum')->get('/category/{id}', [CategoryController::class, 'getCategoryById']);
Route::middleware('auth:sanctum')->post('/assign-sub-category', [CategoryController::class, 'assignSubCategory']);
//subCategory routes
Route::middleware('auth:sanctum')->get('/sub-categories', [SubCategoryController::class, 'getSubCategories']);
Route::middleware('auth:sanctum')->post('/add-sub-category', [SubCategoryController::class, 'addSubCategory']);
Route::middleware('auth:sanctum')->post('/edit-sub-category', [SubCategoryController::class, 'editSubCategory']);
Route::middleware('auth:sanctum')->delete('/delete-sub-category/{id}', [SubCategoryController::class, 'deleteSubCategory']);
Route::middleware('auth:sanctum')->get('/sub-category/{id}', [SubCategoryController::class, 'getSubCategoryById']);


