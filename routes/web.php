<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EntryMoneyController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BookEntryMoneyController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\RegulationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReportController;
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
//Login
Route::post('/check-login',[AdminController::class,'checkLogin']);
Route::get('/show-dashboard',[AdminController::class,'showDashBoard']);
Route::get('/log-out',[AdminController::class,'logOut']);
//Admin
Route::get('/',[AdminController::class,'showLogin']);
//Author
Route::get('/show-author',[AuthorController::class,'showAuthor']);
Route::post('/add-author',[AuthorController::class,'addAuthor']);
Route::post('/update-author/{id}',[AuthorController::class,'updateAuthor']);
Route::post('/delete-author/{id}',[AuthorController::class,'deleteAuthor']);
//Publisher
Route::get('/show-publisher',[PublisherController::class,'showPublisher']);
Route::post('/add-publisher',[PublisherController::class,'addPublisher']);
Route::post('/update-publisher/{id}',[PublisherController::class,'updatePublisher']);
Route::post('/delete-publisher/{id}',[PublisherController::class,'deletePublisher']);
//Category
Route::get('/show-category',[CategoryController::class,'showCategory']);
Route::post('/add-category',[CategoryController::class,'addCategory']);
Route::post('/update-category/{id}',[CategoryController::class,'updateCategory']);
Route::post('/delete-category/{id}',[CategoryController::class,'deleteCategory']);
//Discount
Route::get('/show-discount',[DiscountController::class,'showDiscount']);
Route::post('/add-discount',[DiscountController::class,'addDiscount']);
Route::post('/update-discount/{id}',[DiscountController::class,'updateDiscount']);
Route::post('/delete-discount/{id}',[DiscountController::class,'deleteDiscount']);
//Client
Route::get('/show-client',[ClientController::class,'showClient']);
Route::post('/add-client',[ClientController::class,'addClient']);
Route::post('/update-client/{id}',[ClientController::class,'updateClient']);
Route::post('/delete-client/{id}',[ClientController::class,'deleteClient']);
//Book
Route::get('/show-book',[BookController::class,'showBook']);
Route::post('/add-book',[BookController::class,'addBook']);
Route::post('/update-book/{id}',[BookController::class,'updateBook']);
Route::post('/delete-book/{id}',[BookController::class,'deleteBook']);
Route::get('/show-search-book',[BookController::class,'showSearchBook']);
Route::get('/search-book/{tukhoa}',[BookController::class,'searchBook']);
//EntryMoney
Route::get('/show-entry-money',[EntryMoneyController::class,'showEntryMoney']);
Route::post('/add-entry-money',[EntryMoneyController::class,'addEntryMoney']);
Route::post('/delete-entry-money/{id}',[EntryMoneyController::class,'deleteEntryMoney']);
//Staff
Route::get('/show-staff',[StaffController::class,'showStaff']);
Route::post('/add-staff',[StaffController::class,'addStaff']);
Route::post('/update-staff/{id}',[StaffController::class,'updateStaff']);
Route::post('/delete-staff/{id}',[StaffController::class,'deleteStaff']);
//BookEntryMoney
Route::get('/show-book-entry-money',[BookEntryMoneyController::class,'showBookEntryMoney']);
Route::get('/show-all-book',[BookEntryMoneyController::class,'showAllBook']);
Route::get('/show-detail-book-entry/{id}',[BookEntryMoneyController::class,'showDetailBookEntryMoney']);
Route::get('/add-book-entry/{book_id}',[BookEntryMoneyController::class,'getInforBook']);
Route::post('/save-entry-money',[BookEntryMoneyController::class,'saveEntryMoney']);
Route::post('/delete-book-entry/{id}',[BookEntryMoneyController::class,'deleteBookEntryMoney']);
//BIll
Route::get('/export-bill/{id}',[BillController::class,'printBill']);
Route::get('/show-bill',[BillController::class,'showBill']);
Route::get('/show-book-bill',[BillController::class,'showAllBook']);
Route::get('/add-bill',[BillController::class,'addBill']);
Route::get('/show-detail-bill/{id}',[BillController::class,'showDetailBill']);
Route::post('/save-bill',[BillController::class,'saveBill']);
Route::post('/delete-bill/{id}',[BillController::class,'deleteBill']);
//Title
Route::get('/show-title',[TitleController::class,'showTitle']);
Route::post('/add-title',[TitleController::class,'addTitle']);
Route::post('/update-title/{id}',[TitleController::class,'updateTitle']);
Route::post('/delete-title/{id}',[TitleController::class,'deleteTitle']);
//Regulation
Route::get('/show-regulation',[RegulationController::class,'showRegulation']);
Route::post('/add-regulation',[RegulationController::class,'addRegulation']);
Route::post('/update-regulation/{id}',[RegulationController::class,'updateRegulation']);
//Cart
Route::get('/show-cart',[CartController::class,'showCart']);
Route::post('/add-to-cart',[CartController::class,'addProductCart']);
Route::get('/delete-to-cart/{id}',[CartController::class,'deleteProductCart']);
Route::post('/update-cart-quantity',[CartController::class,'updateQuantityCart']);
Route::post('/update-price',[CartController::class,'updatePriceCart']);
Route::get('/show-bill-cart',[CartController::class,'showBillCart']);
Route::post('/add-book-to-cart',[CartController::class,'addBookCart']);
Route::get('/delete-book-to-cart/{id}',[CartController::class,'deleteBookCart']);
//Report
Route::get('/show-report-stock',[ReportController::class, 'showReportStock']);
Route::get('/show-report-debt',[ReportController::class, 'showReportDebt']);
Route::post('/show-report-stock-by-month-year',[ReportController::class, 'viewReportStock']);
Route::get('/print-report-stock/{month}/{year}',[ReportController::class, 'printReportStock']);
Route::post('/show-report-debt-by-month-year',[ReportController::class, 'viewReportDebt']);
Route::get('/print-report-debt/{month}/{year}',[ReportController::class, 'printReportDebt']);