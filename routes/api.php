<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientQueryContoller;
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
//query routes
Route::middleware('auth:sanctum')->get('/queries', [QueryController::class, 'getQueries']);
Route::middleware('auth:sanctum')->get('/add-query', [QueryController::class, 'addQuery']);
Route::middleware('auth:sanctum')->delete('/delete-query/{id}', [QueryController::class, 'deleteQuery']);
Route::middleware('auth:sanctum')->get('/query-products/{id}', [QueryController::class, 'getQueryProducts']);
//notification routes
Route::middleware('auth:sanctum')->get('/notifications', [NotificationController::class, 'getNotifications']);
Route::middleware('auth:sanctum')->get('/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
//invoice routes
Route::middleware('auth:sanctum')->get('/invoices', [InvoiceController::class, 'getInvoices']);
Route::middleware('auth:sanctum')->post('/add-invoice', [InvoiceController::class, 'addInvoice']);
Route::middleware('auth:sanctum')->delete('/delete-invoice/{id}', [InvoiceController::class, 'deleteInvoice']);
Route::middleware('auth:sanctum')->get('/invoice-products/{id}', [InvoiceController::class, 'getInvoiceProducts']);
//client user routes
Route::middleware('auth:sanctum')->get('/client-users', [UserController::class, 'getClientUsers']);
Route::post('/add-client-user', [UserController::class, 'registerClientUser']);
//client query routes
Route::middleware('auth:sanctum')->get('/client-queries', [ClientQueryContoller::class, 'getClientQueries']);
Route::middleware('auth:sanctum')->post('/add-client-query', [ClientQueryContoller::class, 'addClientQuery']);
Route::middleware('auth:sanctum')->delete('/delete-client-query/{id}', [ClientQueryContoller::class, 'deleteClientQuery']);
Route::middleware('auth:sanctum')->get('/client-query-products/{id}', [ClientQueryContoller::class, 'getClientQueryProducts']);
