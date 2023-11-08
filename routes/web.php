<?php

use App\Http\Controllers\Admin\UserController as AdminUserConroller;
use App\Http\Controllers\BrtController;
use App\Http\Controllers\Deposit\TireController as DepositTireController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EasyFattController;
use App\Http\Controllers\KijijiController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LiftController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistryController;
use App\Http\Controllers\Reservation\ServiceController as ServiceReservationController;
use App\Http\Controllers\Reservation\TireController as TireReservationController;
use App\Http\Controllers\Reservation\DepositController as DepositReservationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Shipment\TireController as ShipmentTireController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StorageScanController;
use App\Http\Controllers\TireController;
use App\Http\Controllers\TireMergeController;
use App\Http\Controllers\TirePhotoController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;
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

Auth::routes(['register' => false, 'verify' => false]);

Route::get('/', \App\Http\Controllers\DashboardController::class)->name('dashboard');

Route::resource('users', UserController::class)->only(['index']);

Route::get('/tires/sell', [TireController::class, 'sell'])->name('tires.sell');
Route::post('/tires/sell/submit', [TireController::class, 'sellSubmit'])->name('tires.sellSubmit');
Route::get('/tires/discount', [DiscountController::class, 'create'])->name('tires.discount');
Route::post('/tires/discount/submit', [DiscountController::class, 'store'])->name('tires.discountSubmit');
Route::get('/tires/import', [TireController::class, 'importView'])->name('tires.import');
Route::post('/tires/importSubmit', [TireController::class, 'import'])->name('tires.importSubmit');
Route::get('/tires/restore/{tire}', [TireController::class, 'restore'])->name('tires.restore');
Route::get('/tires/buy', [TireController::class, 'buy'])->name('tires.buy');

Route::resource('tires', TireController::class);
Route::resource('tire-photos', TirePhotoController::class)->only(['store', 'destroy']);

Route::get('/tire-merge/{tire}/create', [TireMergeController::class, 'create'])->name('tire-merge.create');
Route::resource('tire-merge', TireMergeController::class)->only(['store']);

Route::resource('products', ProductController::class)->except(['show']);
Route::resource('services', ServiceController::class)->except(['show']);

Route::get('/shipments/print', [ShipmentController::class, 'print'])->name('shipments.print');
Route::get('/shipments/reprint', [ShipmentController::class, 'reprint'])->name('shipments.reprint');
Route::get('/shipments/ddt', [EasyFattController::class, 'ddt_shipment'])->name('shipments.ddt');
Route::get('/shipments/invoice', [EasyFattController::class, 'invoice_shipment'])->name('shipments.invoice');
Route::get('/shipments/{shipment}/bill', [ShipmentController::class, 'bill'])->name('shipments.bill');
Route::post('/shipments/{shipment}/ship', [ShipmentController::class, 'ship'])->name('shipments.ship');
Route::get('/shipments/{shipment}/track', [ShipmentController::class, 'track'])->name('shipments.track');
Route::get('/shipments/{shipment}/cancel_shipment', [ShipmentController::class, 'cancel_shipment'])->name('shipments.cancel_shipment');
Route::get('/shipments/import-easyfatt', [ShipmentController::class, 'importEasyfatt'])->name('shipments.import-easyfatt');
Route::resource('shipments.tire', ShipmentTireController::class)->except(['show']);
Route::resource('shipments', ShipmentController::class)->except(['show']);

Route::get('/brt/labels', [BrtController::class, 'labels'])->name('brt.labels');
Route::get('/brt/report', [BrtController::class, 'report'])->name('brt.report');
Route::get('/brt/ship_daily', [BrtController::class, 'shipDaily'])->name('brt.ship_daily');

Route::resource('deposits.tires', DepositTireController::class)->except('show');
Route::resource('deposits', DepositController::class)->except('show');
Route::resource('lifts', LiftController::class)->except('show');

Route::get('/reservations/{reservation}/print', [ReservationController::class, 'print'])->name('reservations.print');
Route::get('/reservations/printDay', [ReservationController::class, 'printDay'])->name('reservations.printDay');
Route::get('/reservations/printMorning', [ReservationController::class, 'printMorning'])->name('reservations.printMorning');
Route::get('/reservations/printAfternoon', [ReservationController::class, 'printAfternoon'])->name('reservations.printAfternoon');
Route::get('/reservations/reprint', [ReservationController::class, 'reprint'])->name('reservations.reprint');

Route::get('/reservations/{reservation}/counter-sale-deposit', [EasyFattController::class, 'counter_sale_deposit_reservation'])->name('reservations.counter-sale-deposit');
Route::get('/reservations/{reservation}/counter-sale', [EasyFattController::class, 'counter_sale_reservation'])->name('reservations.counter-sale');
Route::get('/reservations/{reservation}/invoice', [EasyFattController::class, 'invoice_reservation'])->name('reservations.invoice');
Route::get('/reservations/{reservation}/bill', [ReservationController::class, 'bill'])->name('reservations.bill');
Route::get('/reservations/{reservation}/deposit', [ReservationController::class, 'deposit'])->name('reservations.deposit');
Route::get('/reservations/{reservation}/warranty', [ReservationController::class, 'warranty'])->name('reservations.warranty');
Route::get('/reservations/{reservation}/createDeposit', [ReservationController::class, 'createDeposit'])->name('reservations.createDeposit');
Route::post('/reservations/{reservation}/storeDeposit', [ReservationController::class, 'storeDeposit'])->name('reservations.storeDeposit');

Route::resource('reservations.service', ServiceReservationController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
Route::resource('reservations.tire', TireReservationController::class)->except(['show']);
Route::resource('reservations.deposit', DepositReservationController::class)->except(['show']);
Route::resource('reservations', ReservationController::class)->except(['show']);

Route::resource('registries', RegistryController::class)->except(['show']);

Route::name('shops.')->prefix('shops')->group(function () {
    Route::resource('kijiji', KijijiController::class)->only(['index']);
});

Route::name('admin.')->namespace('App\Http\Controllers\Admin')->prefix('admin')->group(
    function () {
        Route::resource('users', AdminUserConroller::class)->except(['show']);
        Route::resource('price-list', PriceListController::class)->except(['show']);
    }
);

Route::get('/labels/tire', [LabelController::class, 'generateTireLabel'])->name('labels.tire');

Route::resource('storage-scan', StorageScanController::class)->except(['edit', 'update']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
