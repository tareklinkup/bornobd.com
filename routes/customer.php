<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\DashboardController;

Route::get('/customer-login',[CustomerController::class,'customer'])->name('customer.login');

Route::post('/customer-login-store',[CustomerController::class,'AuthCheck'])->name('customer.login.store');
Route::get('/customer-register-form',[CustomerController::class,'customerForm'])->name('customer.register.form');
Route::post('/customer-register',[CustomerController::class,'customerStore'])->name('customer.register');


Route::post('/wishlist',[WishlistController::class,'wishtlistStore'])->name('wishlist.store');
Route::get('/wishlist-count',[WishlistController::class,'wishtlistShow'])->name('wishlist.count');

Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/chekcout-store',[CheckoutController::class,'checkoutStore'])->name('checkout.store');
Route::get('/delivery-charge-get',[CustomerController::class,'getCharge'])->name('get.charge');

Route::group(['middleware'=> 'customerCheck'],function(){

    Route::get('/customer-logout',[CustomerController::class, 'logout'])->name('customer.logout');
    Route::get('/customer-dashboard',[DashboardController::class,'dashboard'])->name('customer.dashboard');
    Route::post('/customer-update',[DashboardController::class,'customerUpdate'])->name('auth.customer.update');
    Route::post('/customer-address',[DashboardController::class,'addressChange'])->name('auth.customer.address');
    Route::get('/customer-invoice/{id}',[DashboardController::class,'customerInvoice'])->name('customer-indivisual.invoice');
    Route::post('/password-update-customer',[CustomerController::class,'customerPasswordUpdate'])->name('password.update.customer');

    // wishlist
    Route::get('/cupon-Check', [CheckoutController::class, 'cuponCheck'])->name('cupon.check');
    Route::get('/wishlist-delete/{delete}',[WishlistController::class,'deleteWishlist'])->name('wishlist.delete');

});