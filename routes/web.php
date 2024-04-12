<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArchiveController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::resource('Archive', ArchiveController::class);

Route::get('/section/{id}', '\App\Http\Controllers\InvoicesController@getproducts');
Route::get('/invoices_details/{id}','\App\Http\Controllers\InvoicesDetailsController@edit');
Route::get('/edit_invoice/{id}', '\App\Http\Controllers\InvoicesController@edit');

Route::post('delete_file', '\App\Http\Controllers\InvoicesDetailsController@destroy')->name('delete_file');
Route::get('download/{invoice_number}/{file_name}', '\App\Http\Controllers\InvoicesDetailsController@get_file');
Route::get('View_file/{invoice_number}/{file_name}', '\App\Http\Controllers\InvoicesDetailsController@open_file');

Route::get('/Status_show/{id}', '\App\Http\Controllers\InvoicesController@show')->name('Status_show');
Route::post('/Status_Update/{id}', '\App\Http\Controllers\InvoicesController@Status_Update')->name('Status_Update');


Route::get('Invoice_Paid','\App\Http\Controllers\InvoicesController@Invoice_Paid');
Route::get('Invoice_UnPaid','\App\Http\Controllers\InvoicesController@Invoice_UnPaid');
Route::get('Invoice_Partial','\App\Http\Controllers\InvoicesController@Invoice_Partial');
Route::get('Print_invoice/{id}','\App\Http\Controllers\InvoicesController@Print_invoice');
Route::get('export_invoices', '\App\Http\Controllers\InvoicesController@export');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','\App\Http\Controllers\RoleController');
    Route::resource('users','\App\Http\Controllers\UserController');
});

Route::get('invoices_report', '\App\Http\Controllers\InvoicesReport@index');
Route::post('Search_invoices', '\App\Http\Controllers\InvoicesReport@Search_invoices');

Route::get('customers_report', '\App\Http\Controllers\CustomersReport@index');
Route::post('Search_customers', '\App\Http\Controllers\CustomersReport@Search_customers');
Route::get('Markallread','\App\Http\Controllers\InvoicesController@Markallread');
    Route::get('ViewAll','\App\Http\Controllers\InvoicesController@ViewAll');
Route::get('/{page}', [AdminController::class, 'index']);

