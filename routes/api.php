<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/category', [ApiController::class, 'index']);
// Route::post('/category/post', [ApiController::class, 'store']);

Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});

Route::get('/hotline', [ApiController::class, 'hotline']);
Route::get('/product', [ApiController::class, 'product']);
Route::get('/get-product-image/{id}', [ApiController::class, 'getProductImage']);
Route::get('/hot-deal-product', [ApiController::class, 'dealProduct']);

Route::get('/slider', [ApiController::class, 'banner']);
// category
Route::get('/category-with-subcategory', [ApiController::class, 'getCategory']);
Route::get('/category', [ApiController::class, 'getCategoryOnly']);
Route::get('/category-wise-subcategory/{id}', [ApiController::class, 'getSubcategory']);
// category wise product
// Route::get('/category-wise/{slug}', [HomeController::class, 'CategoryWiseProduct'])->name('categroy.product');
// product
Route::get('/recent-home', [ApiController::class, 'recentProduct']);
Route::get('/recent-inner', [ApiController::class, 'recentProductInner']);
// popular product
Route::get('/popular-inner', [ApiController::class, 'popularInner']);

Route::get('/newarrival', [ApiController::class, 'newArrival']);
Route::get('/trending', [ApiController::class, 'trending']);
Route::get('/trending-home', [ApiController::class, 'trendingHome']);
Route::get('/feature', [ApiController::class, 'featureProduct']);
// search
Route::get('search/{name}',[ApiController::class, 'search']);

Route::get('/category-wise-product/{id}',[ApiController::class, 'categoryWiseProduct']);
Route::get('/subcategory-wise-product/{id}',[ApiController::class, 'subcategoryWiseProduct']);
Route::get('/get-area',[ApiController::class, 'getArea']);
Route::get('/getCharge/{id}',[ApiController::class, 'getCharge']);

Route::get('/product-details/{id}', [ApiController::class, 'productDetails']);

// Add to Cart
Route::post('/cartAdd/{id}',[ApiController::class,'cartAdd']);
Route::get('/get-cart',[ApiController::class,'getCart']);

Route::post('/customer-store', [ApiController::class, 'CustomerStore']);
Route::get('/checkout',[ApiController::class,'checkout']);

Route::post('/register', [AuthController::class, 'register']);
// Route::get('/get-data', [AuthController::class, 'GetData']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], 
function ($router) {
    // Route::post('refresh', [AuthController::class, 'refresh']);
    // Route::get('token', [AuthController::class, 'Token']);
    Route::get('/customer-logout',[AuthController::class, 'logout']);
    Route::get('/customer-dashboard',[ApiController::class,'dashboard']);
    Route::post('/just-order', [ApiController::class, 'justOrderStore']);
    Route::get('/get_user', [ApiController::class, 'get_user']);
    Route::post('/order-store', [ApiController::class, 'orderStore']);
});








