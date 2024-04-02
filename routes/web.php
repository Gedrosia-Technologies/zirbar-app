<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountDetailsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartykantaController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDetailsController;
use App\Http\Controllers\RoznamchaController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SalarydetailsController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\SellDetailController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockDetailController;
use App\Http\Controllers\TomanClientController;
use App\Http\Controllers\TomanClientKantaController;
use App\Http\Controllers\TomanSupplierController;
use App\Http\Controllers\TomanSupplierKantaController;
use App\Http\Controllers\UnitController;
use App\Models\TomanClientKanta;
use App\Http\Controllers\TomanTransactionController;
use App\Http\Controllers\TomanPurchasedetailController;
use App\Http\Controllers\TomanSaleController;
use App\Http\Controllers\TomanStockerController;
use App\Http\Controllers\TomanStockerKantaController;
use App\Http\Controllers\TomanTransactionDetailsController;
use App\Models\TomanSupplier;
use App\Models\TomanSupplierKanta;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//Unit routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Units', [UnitController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Unit/New', [UnitController::class, 'addnew'])->name('add_unit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Unit/delete', [UnitController::class, 'destroy'])->name('delete_unit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Unit/update', [UnitController::class, 'update'])->name('update_unit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Unit/rate', [UnitController::class, 'rate'])->name('update_rate');

//Sell routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Sell', [SellController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Sell/New', [SellController::class, 'store'])->name('add_sell');
Route::middleware(['auth:sanctum', 'verified'])->post('/Sell/delete', [SellController::class, 'destroy'])->name('delete_sell');
Route::middleware(['auth:sanctum', 'verified'])->post('/Sell/update', [SellController::class, 'update'])->name('update_sell');
Route::middleware(['auth:sanctum', 'verified'])->post('/Sell/close', [SellController::class, 'close'])->name('close_sell');

//SellDetail routes
Route::middleware(['auth:sanctum', 'verified'])->get('/SellDetail/{id}', [SellDetailController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/SellDetail/new', [SellDetailController::class, 'store'])->name('add_selldetail');
Route::middleware(['auth:sanctum', 'verified'])->post('/SellDetail/delete', [SellDetailController::class, 'destroy'])->name('delete_selldetail');

//Stock Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Stock', [StockController::class, 'index']);

// Stock details Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/StockDetails/{id}', [StockDetailController::class, 'show']);

//account routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Investment', [AccountController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Accounts/New', [AccountController::class, 'addnew'])->name('add_account');
Route::middleware(['auth:sanctum', 'verified'])->post('/Accounts/delete', [AccountController::class, 'destroy'])->name('delete_account');
Route::middleware(['auth:sanctum', 'verified'])->post('/Accounts/update', [AccountController::class, 'update'])->name('update_account');

//Purchase routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Purchase', [PurchaseController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Purchase/New', [PurchaseController::class, 'store'])->name('add_purchase');
Route::middleware(['auth:sanctum', 'verified'])->post('/Purchase/delete', [PurchaseController::class, 'destroy'])->name('delete_purchase');
Route::middleware(['auth:sanctum', 'verified'])->post('/Purchase/close', [PurchaseController::class, 'close'])->name('purchase-close');
Route::middleware(['auth:sanctum', 'verified'])->post('/Purchase/fish/print', [PurchaseController::class, 'print'])->name('purchase-fish-print');

//Purchase Details
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseDetails/{id}', [PurchaseDetailsController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseDetails/pay/{id}/{brokerid}/{fishtype}', [PurchaseDetailsController::class, 'pay']);
Route::middleware(['auth:sanctum', 'verified'])->get('/purchaseDetails/details/{id}', [PurchaseDetailsController::class, 'details']);
Route::middleware(['auth:sanctum', 'verified'])->post('/purchaseDetails/add', [PurchaseDetailsController::class, 'add'])->name('add_purchaseDetail');
Route::middleware(['auth:sanctum', 'verified'])->post('/purchaseDetails/print', [PurchaseDetailsController::class, 'displayreport2'])->name('purchase-details-print');

// account_details routes
Route::middleware(['auth:sanctum', 'verified'])->get('/AccountDetails/{id}', [AccountDetailsController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/AccountDetails/create', [AccountDetailsController::class, 'store'])->name('add-account-details');
Route::middleware(['auth:sanctum', 'verified'])->post('/AccountDetails/print', [AccountDetailsController::class, 'displayReport'])->name('accountdetails-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/AccountDetails/delete', [AccountDetailsController::class, 'destroy'])->name('accountdetails-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/AccountDetails/update', [AccountDetailsController::class, 'update'])->name('accountdetails-update');

//roznamcha routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Roznamcha', [RoznamchaController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/add', [RoznamchaController::class, 'store'])->name('add-roznamcha');
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/date', [RoznamchaController::class, 'date'])->name('roznamcha-get-date');
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/print', [RoznamchaController::class, 'displayReport2'])->name('roznamcha-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/delete', [RoznamchaController::class, 'destroy'])->name('roznamcha-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/edit', [RoznamchaController::class, 'edit'])->name('roznamcha-edit');
Route::middleware(['auth:sanctum', 'verified'])->post('/roznamcha/update', [RoznamchaController::class, 'update'])->name('roznamcha-update');

//salary routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Salary', [SalaryController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Salary/create', [SalaryController::class, 'store'])->name('add_salary');
Route::middleware(['auth:sanctum', 'verified'])->post('/Salary/print', [SalaryController::class, 'displayReport2'])->name('salary-print');

//Salary Details routes
Route::middleware(['auth:sanctum', 'verified'])->get('/SalaryDetails/{id}', [SalarydetailsController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/SalaryDetails/create', [SalarydetailsController::class, 'store'])->name('add-salarydetails');
Route::middleware(['auth:sanctum', 'verified'])->post('/SalaryDetails/print', [SalarydetailsController::class, 'displayReport2'])->name('salarydetails-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/SalaryDetails/delete', [SalarydetailsController::class, 'destroy'])->name('salarydetails-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/SalaryDetails/update', [SalarydetailsController::class, 'update'])->name('salarydetails-update');
Route::middleware(['auth:sanctum', 'verified'])->post('/SalaryDetails/paysalary', [SalarydetailsController::class, 'PaySalary'])->name('salarydetails-paysalary');

//Expenditure routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Expenditure', [ExpenditureController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Expenditure/AddItem', [ExpenditureController::class, 'store'])->name('add_expenditure');
Route::middleware(['auth:sanctum', 'verified'])->post('/Expenditure/date', [ExpenditureController::class, 'date'])->name('expenditure-get-date');
Route::middleware(['auth:sanctum', 'verified'])->post('/Expenditure/print', [ExpenditureController::class, 'displayReport2'])->name('expenditure-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/Expenditure/delete', [ExpenditureController::class, 'destroy'])->name('expenditure-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/Expenditure/update', [ExpenditureController::class, 'update'])->name('expenditure-update');

//party routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Party', [PartyController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Party/create', [PartyController::class, 'store'])->name('add_party');

//Party Kanta Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Partykanta/{id}', [PartykantaController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Partykanta/create', [PartykantaController::class, 'store'])->name('add-partykanta');
Route::middleware(['auth:sanctum', 'verified'])->post('/Partykanta/print', [PartykantaController::class, 'displayReport2'])->name('partykanta-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/Partykanta/delete', [PartykantaController::class, 'destroy'])->name('partykanta-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/Partykanta/edit', [PartykantaController::class, 'edit'])->name('partykanta-edit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Partykanta/update', [PartykantaController::class, 'update'])->name('partykanta-update');


//Toman Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/TomanTransactions', [TomanTransactionController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/date', [TomanTransactionController::class, 'date'])->name('toman-transactions-get-date');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/print', [TomanTransactionController::class, 'displayReport2'])->name('toman-transactions-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/delete', [TomanTransactionController::class, 'destroy'])->name('toman-transactions-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/edit', [TomanTransactionController::class, 'edit'])->name('toman-transactions-edit');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/update', [TomanTransactionController::class, 'update'])->name('toman-transactions-update');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactions/close', [TomanTransactionController::class, 'closeTransaction'])->name('close_tomantransaction');
// Toman purchase and sell routes
Route::middleware(['auth:sanctum', 'verified'])->post('/Toman/Purchase', [TomanTransactionController::class, 'storePurchase'])->name('toman_purchase');
Route::middleware(['auth:sanctum', 'verified'])->post('/Toman/Sell', [TomanTransactionController::class, 'storeSell'])->name('toman_sell');

// Toman Transaction Detial Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/TomanTransactionDetails/{id}', [TomanTransactionDetailsController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactionDetails/add', [TomanTransactionDetailsController::class, 'store'])->name('add_tomantransactiondetail');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanTransactionDetails/delete', [TomanTransactionDetailsController::class, 'destroy'])->name('delete_tomantransactiondetail');


//Toman Supplier
Route::middleware(['auth:sanctum', 'verified'])->get('/TomanSuppliers', [TomanSupplierController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanSupplier/create', [TomanSupplierController::class, 'store'])->name('add_toman_supplier');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanSupplier/delete', [TomanSupplierController::class, 'destroy'])->name('delete_toman_supplier');

//Toman Client
Route::middleware(['auth:sanctum', 'verified'])->get('/TomanClients', [TomanClientController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanClients/create', [TomanClientController::class, 'store'])->name('add_toman_client');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanClients/delete', [TomanClientController::class, 'destroy'])->name('delete_toman_client');


//Toman Supplier Kanta Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/SupplierKanta/{id}', [TomanSupplierKantaController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Supplierkanta/create', [TomanSupplierKantaController::class, 'store'])->name('add-supplierkanta');
Route::middleware(['auth:sanctum', 'verified'])->post('/Supplierkanta/print', [TomanSupplierKantaController::class, 'displayReport2'])->name('supplierkanta-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/Supplierkanta/delete', [TomanSupplierKantaController::class, 'destroy'])->name('supplierkanta-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/Supplierkanta/edit', [TomanSupplierKantaController::class, 'edit'])->name('supplierkanta-edit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Supplierkanta/update', [TomanSupplierKantaController::class, 'update'])->name('supplierkanta-update');


//Toman client Kanta Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Clientkanta/{id}', [TomanClientKantaController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Clientkanta/create', [TomanClientKantaController::class, 'store'])->name('add-clientkanta');
Route::middleware(['auth:sanctum', 'verified'])->post('/Clientkanta/print', [TomanClientKantaController::class, 'displayReport2'])->name('clientkanta-print');
Route::middleware(['auth:sanctum', 'verified'])->post('/Clientkanta/delete', [TomanClientKantaController::class, 'destroy'])->name('clientkanta-delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/Clientkanta/edit', [TomanClientKantaController::class, 'edit'])->name('clientkanta-edit');
Route::middleware(['auth:sanctum', 'verified'])->post('/Clientkanta/update', [TomanClientKantaController::class, 'update'])->name('clientkanta-update');



// Client Toman Balance Route
Route::middleware(['auth:sanctum', 'verified'])->post('/ClientTomanBalance/create', [TomanClientKantaController::class, 'update_toman_balance'])->name('clientkanta-toman-update');
Route::middleware(['auth:sanctum', 'verified'])->get('/ClientTomanBalance/{id}', [TomanClientKantaController::class, 'toman_show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/ClientTomanBalance/delete', [TomanClientKantaController::class, 'toman_balance_delete'])->name('clientkanta-tomin-delete');

//Toman Stocker
Route::middleware(['auth:sanctum', 'verified'])->get('/TomanStockers', [TomanStockerController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanStockers/create', [TomanStockerController::class, 'store'])->name('add_toman_stocker');
Route::middleware(['auth:sanctum', 'verified'])->post('/TomanStockers/delete', [TomanStockerController::class, 'destroy'])->name('delete_toman_stocker');
//Toman Stocker Kanta Routes
Route::middleware(['auth:sanctum', 'verified'])->get('/Stockerkanta/{id}', [TomanStockerKantaController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/Stockerkanta/print', [TomanStockerKantaController::class, 'displayReport2'])->name('print-stockerkanta');
Route::middleware(['auth:sanctum', 'verified'])->post('/Stockerkanta/create', [TomanStockerKantaController::class, 'store'])->name('add-stockerkanta');
Route::middleware(['auth:sanctum', 'verified'])->post('/Stockerkanta/delete', [TomanStockerKantaController::class, 'destroy'])->name('delete-stockerkanta');
// Route::middleware(['auth:sanctum', 'verified'])->post('/Stockerkanta/edit', [TomanStockerKantaController::class, 'edit'])->name('supplierkanta-edit');
// Route::middleware(['auth:sanctum', 'verified'])->post('/Stockerkanta/update', [TomanStockerKantaController::class, 'update'])->name('supplierkanta-update');

