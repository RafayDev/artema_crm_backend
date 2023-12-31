<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientQueryContoller;
use App\Http\Controllers\ClientInvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/view-query/{id}', [QueryController::class, 'viewQuery']);
Route::get('/view-invoice/{id}', [InvoiceController::class, 'viewInvoice']);
Route::get('/view-client-query/{id}', [ClientQueryContoller::class, 'viewClientQuery']);
Route::get('/view-client-invoice/{id}', [ClientInvoiceController::class, 'viewClientInvoice']);
Route::get('unauthorized', function () {
    return response()->json([
        'message' => 'Unauthorized!'
    ], 401);
})->name('unauthorized');
