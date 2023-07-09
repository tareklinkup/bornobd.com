<?php

use App\Http\Controllers\BulkQuantityController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\WishlistController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use GuzzleHttp\Psr7\Request;

// use GuzzleHttp\Middleware;

// Route::get('/', function () {
//     return view('welcome');
// });

// optimiZe
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/product', [HomeController::class, 'productList'])->name('product.list');
Route::get('/category-wise/{slug}', [HomeController::class, 'CategoryWiseProduct'])->name('categroy.product');
Route::get('/subcategory-wise/{slug}', [HomeController::class, 'SubcateogryWiseProduct'])->name('subcategory.product');
Route::get('/sub-subcategory-wise/{slug}', [HomeController::class, 'SubsubcateogryWiseProduct'])->name('sub.subcategory.product');
Route::get('/another-category-wise/{slug}', [HomeController::class, 'anotherCategoryWiseProduct'])->name('another.category.product');
Route::get('/session-collection-one', [HomeController::class, 'collectionProductOne'])->name('collection_one.product');
Route::get('/session-collection-two', [HomeController::class, 'collectionProductTwo'])->name('collection_two.product');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs.website');
Route::get('/terms-and-condition', [HomeController::class, 'tramsCondition'])->name('trams.website');
Route::get('/mission-and-vission', [HomeController::class, 'missionVission'])->name('mission.website');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact.website');
Route::get('/our-management', [HomeController::class, 'management'])->name('management.website');
Route::post('/contact-store', [HomeController::class, 'contactStore'])->name('contact.store.website');

// partner page
Route::get('/partner-details/{id}', [HomeController::class, 'partnerPage'])->name('partnerPage.details');
// store list
Route::get('/store-list', [HomeController::class, 'storeList'])->name('store.list');
   
// track with quriar
Route::get('/tracking-order', [HomeController::class, 'track'])->name('website.track');

// // popular product
// Route::get('/popular-product', [HomeController::class, 'popularPorduct'])->name('popular.product');
// Route::get('/price-filter/{price}', [HomeController::class, 'highToLowPrice'])->name('priceWise.product');
Route::get('/price-filter', [HomeController::class, 'productFileter'])->name('filter.product');
Route::get('/trending-product', [HomeController::class, 'trendproductList'])->name('trending.product');
Route::get('/new-arrival-product', [HomeController::class, 'newArrival'])->name('newarrival.product');
Route::get('/hot-deal-product', [HomeController::class, 'dealProduct'])->name('deal.product');
   
// product review    
Route::post('review-product', [ReviewController::class, 'reviewStore'])->name('review.store');
Route::get('rewiew-list/{id}', [ReviewController::class, 'showReview'])->name('review.show');

// mother api branch 
Route::get('mother-api-branch', [HomeController::class, 'getMotherApiContent'])->name('mother.branch');


Route::get('/product-details/{id}', [HomeController::class, 'productDetails'])->name('product.details');
Route::get('/other-product-img/{id}',[HomeController::class,'otherImage'])->name('other.image');
Route::get('/modal-single-product/{id}',[HomeController::class,'modalProduct'])->name('modal.product');
Route::get('/single-partner-details/{id}',[HomeController::class,'modalPartner'])->name('modal.partner');
Route::post('/cartAdd/{id}',[CartController::class,'cartAdd'])->name('cart.add');
Route::get('/cart-remove/{id}',[CartController::class,'cartRemove'])->name('cart.remove');
Route::post('/cart-update/{id}',[CartController::class,'cartUpdate'])->name('cart.update');
Route::post('/checkout-cart/{id}',[CartController::class,'checkoutCart'])->name('checkout.cart');
Route::get('/cart-increment-decrement/{data}/{id}',[CartController::class,'cartIncrementDecrement'])->name('cart.increment.decrement');
Route::post('/gift-cart-update/{id}',[CartController::class,'giftCartUpdate'])->name('gift.cart.update');
Route::get('/ajax-cart-remove/{id}',[CartController::class,'ajaxCartRemove'])->name('ajax.cart.remove');
Route::post('/trailoring-add/{id}',[CartController::class,'trailoringAdd'])->name('trailoring.add');
    
Route::get('/cart-list',[HomeController::class,'cartList'])->name('cart.list');
// wish list
Route::get('/size-Guide',[HomeController::class, 'sizeGuide'])->name('sizeGuide.web');
// serarch route
Route::get('/get_suggestions', [HomeController::class, 'getSearchSuggestions'])->name('get.suggetion');
Route::get('/search', [HomeController::class, 'productSearch'])->name('search');

// bulk quantity

Route::post('/store-Quntity', [BulkQuantityController::class, 'storeQuntity'])->name('bulk-quation.store');
// admin all route
require __DIR__ . '/admin.php';

// customer all route
require __DIR__ . '/customer.php';

   

