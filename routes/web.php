<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InviciesController;
use App\Http\Controllers\Invoices_attachmentController;
use App\Http\Controllers\Invoices_detailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Models\Invoices_details;

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
    return view('auth.login');
});

// Route::get('showadminame',[RouteController::class, 'showadminame']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




// sections routes


Route::get('sections',[SectionController::class, 'index']);
Route::post('sections_store',[SectionController::class, 'store'])->name('sections.store');
Route::post('sections_update/{id}',[SectionController::class, 'update'])->name('sections.update');
Route::post('sections_delete/{id}',[SectionController::class, 'delete'])->name('sections.delete');

// products routes

Route::get('products',[ProductController::class, 'index']);
Route::post('products_store',[ProductController::class, 'store'])->name('products.store');
Route::post('products_update/{id}',[ProductController::class, 'update'])->name('products.update');
Route::post('products_delete/{id}',[ProductController::class, 'delete'])->name('products.delete');




// invoices routes


Route::get('invoices',[InviciesController::class, 'index']);
Route::get('invoices-create',[InviciesController::class, 'create'])->name('invoices.create');

// get data to ajax
Route::get('/section/{id}',[InviciesController::class, 'getproduct']);


Route::post('invoices-store',[InviciesController::class, 'store'])->name('inovices.store');
Route::get('invoices/{id}/edit',[InviciesController::class, 'edit'])->name('invoices.edit');
Route::post('invoices-update/{id}',[InviciesController::class, 'update'])->name('invoices.update');
Route::post('invoices-destroy',[InviciesController::class, 'destroy'])->name('invoices.destroy');

// change the payment
Route::get('payment/{id}/edit',[InviciesController::class, 'payshow'])->name('invoices.payshow');
Route::post('payment-update/{id}',[InviciesController::class, 'payment_update'])->name('invoices.payment.update');

Route::get('invoices-paid',[InviciesController::class, 'invoice_paid'])->name('invoices.paid');
Route::get('invoices-unpaid',[InviciesController::class, 'invoice_unpaid'])->name('invoices.unpaid');
Route::get('invoices-partial',[InviciesController::class, 'invoice_partial'])->name('invoices.partial');

Route::get('invoices-archive-show',[InviciesController::class, 'invoice_archive_show'])->name('invoices.archive.show');
Route::post('invoices-archive',[InviciesController::class, 'invoice_archive'])->name('invoices.archive');
Route::post('invoices-archive-delete',[InviciesController::class, 'invoice_archive_delete'])->name('invoices.archive.delete');
Route::post('invoices-archive-restore',[InviciesController::class, 'invoice_archive_restore'])->name('invoices.archive.restore');

Route::get('print_invoices/{id}',[InviciesController::class, 'print_invoices'])->name('print_invoices');



// invoices details route

Route::get('/InvoicesDetails/{id}',[Invoices_detailsController::class, 'edit']);
Route::get('/View_file/{invoices_number}/{file_name}',[Invoices_detailsController::class, 'open_file']);
Route::get('/download/{invoices_number}/{file_name}',[Invoices_detailsController::class, 'get_file']);
Route::post('delete_file', [Invoices_detailsController::class, 'delete'])->name('delete_file');
Route::get('/get',[Invoices_detailsController::class, 'getdata']);





// invoices_attachment routes
Route::post('attachment-store', [Invoices_attachmentController::class, 'store'])->name('attachment.store');



// reports routes
Route::get('invoices_reports', [InvoicesReportController::class, 'invoices_reports'])->name('invoices_reports');
Route::post('search_reports', [InvoicesReportController::class, 'search_reports'])->name('search.reports');

Route::get('customers_reports', [CustomersReportController::class, 'customers_reports'])->name('customers_reports');
Route::post('Search_customers', [CustomersReportController::class, 'Search_customers'])->name('Search_customers');








 // permissons
Route::group(['middleware' => ['auth']], function() {

    Route::resource('users',UserController::class);
    
    Route::resource('roles',RoleController::class);
    
    });






Route::get('/{page}', [AdminController::class,'index']);

