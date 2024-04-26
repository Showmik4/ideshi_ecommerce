<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/account', [HomeController::class, 'myaccount'])->name('account');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('product.checkout');    
    Route::get('/view_cart', [ProductController::class, 'view_cart'])->name('product.view_cart');  
    Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('product.wishlist');  
    Route::post('/addtowishlist', [HomeController::class, 'addToWishlist'])->name('product.addToWishlist'); 
    Route::post('/delete-wishlist/', [HomeController::class, 'deleteWishlist'])->name('deleteWishlist');
    Route::post('/applyCoupon', [HomeController::class, 'applyPromoCode'])->name('applyCoupon');
    
});

   
Route::middleware(['web'])->group(function () 
{
    Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('product.addToCart');
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/my-account-update/{id}', [HomeController::class, 'myAccountUpdate'])->name('myAccountUpdate');
    Route::get('/shop/{categoryId?}', [ShopController::class, 'view'])->name('shop');
    // Route::post('/search', [ShopController::class, 'search'])->name('search');
    // Route::get('/get-products', [ShopController::class, 'getProducts'])->name('get-products');
    Route::any('/getFilteredProducts/{query?}', [ShopController::class, 'getFilteredProducts'])->name('getFilteredProducts');
    Route::get('/product_details/{id}', [ProductController::class, 'view_product_details'])->name('product_details');
    Route::get('/subtotal', [ProductController::class, 'getSubTotal'])->name('product.subtotal');
    Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('product.updateCart');
    Route::post('/clear-cart', [ProductController::class, 'clearCart'])->name('product.clearCart');
    Route::post('/remove-cart-item', [ProductController::class, 'removeCartItem'])->name('product.removeCartItem');
    Route::get('/remove_CartItem/{id}', [ProductController::class, 'remove_CartItem'])->name('product.remove_CartItem');
    Route::get('/search_product', [ShopController::class, 'search_product'])->name('product.search');
    Route::post('/checkout', [ProductController::class, 'checkout'])->name('product.submit_checkout');
    Route::post('/shipment-zone-charge', [ProductController::class, 'shipmentZoneCharge'])->name('product.shipmentZoneCharge');
    Route::get('/page/{id}', [HomeController::class, 'page'])->name('page');
});

Auth::routes();


