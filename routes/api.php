<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
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
Route::middleware('auth:sanctum')->get('get-categories-by-user-id', [CategoryController::class, 'getSubCategoriesByCategoryId']);
Route::middleware('auth:sanctum')->get('/category-sub-categories-array/{id}', [CategoryController::class, 'getSubCategoriesIdsArraybyCategoryId']);
Route::get('/get-categories-by-user-id/{id}', [CategoryController::class, 'getCategoriesByUserId']);
Route::get('/get-sub-categories-by-category-no-auth/{id}', [CategoryController::class, 'getSubCategoriesByCategoryIdNoAuth']);
//subCategory routes
Route::middleware('auth:sanctum')->get('/sub-categories', [SubCategoryController::class, 'getSubCategories']);
Route::middleware('auth:sanctum')->post('/add-sub-category', [SubCategoryController::class, 'addSubCategory']);
Route::middleware('auth:sanctum')->post('/edit-sub-category', [SubCategoryController::class, 'editSubCategory']);
Route::middleware('auth:sanctum')->delete('/delete-sub-category/{id}', [SubCategoryController::class, 'deleteSubCategory']);
Route::middleware('auth:sanctum')->get('/sub-category/{id}', [SubCategoryController::class, 'getSubCategoryById']);
//product routes
Route::middleware('auth:sanctum')->get('/products', [ProductController::class, 'getProducts']);
Route::middleware('auth:sanctum')->post('/add-product', [ProductController::class, 'addProduct']);
Route::middleware('auth:sanctum')->post('/edit-product', [ProductController::class, 'editProduct']);
Route::middleware('auth:sanctum')->delete('/delete-product/{id}', [ProductController::class, 'deleteProduct']);
Route::middleware('auth:sanctum')->get('/product/{id}', [ProductController::class, 'getProductById']);
Route::middleware('auth:sanctum')->get('/get-product-by-subcategory/{id}', [ProductController::class, 'getProductsBySubCategoryId']);
Route::get('/get-product-by-subcategory-no-auth/{id}', [ProductController::class, 'getProductsBySubCategoryIdNoAuth']);
//client routes
Route::middleware('auth:sanctum')->get('/clients', [ClientController::class, 'getClients']);
Route::middleware('auth:sanctum')->post('/add-client', [ClientController::class, 'addClient']);
Route::middleware('auth:sanctum')->post('/edit-client', [ClientController::class, 'editClient']);
Route::middleware('auth:sanctum')->delete('/delete-client/{id}', [ClientController::class, 'deleteClient']);
Route::middleware('auth:sanctum')->get('/client/{id}', [ClientController::class, 'getClientById']);
Route::middleware('auth:sanctum')->get('/get-client-by-token', [ClientController::class, 'getClientByToken']);
//user routes
Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'getUsers']);
Route::middleware('auth:sanctum')->post('/add-user', [UserController::class, 'createUser']);
Route::middleware('auth:sanctum')->post('/edit-user', [UserController::class, 'editUser']);
Route::middleware('auth:sanctum')->delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
Route::middleware('auth:sanctum')->get('/user/{id}', [UserController::class, 'getUserById']);
//cart routes
Route::middleware('auth:sanctum')->get('/cart', [CartController::class, 'getCart']);
Route::middleware('auth:sanctum')->post('/add-to-cart', [CartController::class, 'addToCart']);
Route::middleware('auth:sanctum')->delete('/delete-from-cart/{id}', [CartController::class, 'deleteFromCart']);
