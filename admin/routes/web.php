<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotDealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
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
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    //ckeditor image upload
    Route::post('ckeditor/upload', [HomeController::class, 'upload'])->name('ckeditor.upload');

    //Contacts
    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::get('/show', [ContactController::class, 'show'])->name('show');
        Route::post('/list', [ContactController::class, 'list'])->name('list');
        Route::post('delete', [ContactController::class, 'delete'])->name('delete');
    });

    //Settings
    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/show', [SettingController::class, 'show'])->name('show');
        Route::post('/list', [SettingController::class, 'list'])->name('list');
        Route::get('create', [SettingController::class, 'create'])->name('create');
        Route::post('store', [SettingController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SettingController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [SettingController::class, 'update'])->name('update');
        Route::post('delete', [SettingController::class, 'delete'])->name('delete');
    });

    //User
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        //user profile
        Route::get('user-profile', [UserController::class, 'userProfile'])->name('profile');
        Route::post('update-user-profile', [UserController::class, 'updateUserProfile'])->name('updateProfile');

        //customer
        Route::post('customer/search', [UserController::class, 'customerSearch'])->name('customer.search');
        Route::post('customer-data', [UserController::class, 'customerData'])->name('customer.data');
        Route::post('customer-store', [UserController::class, 'customerStore'])->name('customer.store');
    });

    //User Type
    Route::group(['prefix' => 'userType', 'as' => 'userType.'], function () {
        Route::get('/show', [UserTypeController::class, 'show'])->name('show');
        Route::post('/list', [UserTypeController::class, 'list'])->name('list');
        Route::get('create', [UserTypeController::class, 'create'])->name('create');
        Route::post('store', [UserTypeController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserTypeController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserTypeController::class, 'update'])->name('update');
        Route::post('delete', [UserTypeController::class, 'delete'])->name('delete');
    });

    //Category
    Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
        Route::get('/show', [CategoryController::class, 'show'])->name('show');
        Route::post('/list', [CategoryController::class, 'list'])->name('list');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('delete', [CategoryController::class, 'delete'])->name('delete');
    });

    //Banner
    Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {
        Route::get('/show', [BannerController::class, 'show'])->name('show');
        Route::post('/list', [BannerController::class, 'list'])->name('list');
        Route::get('create', [BannerController::class, 'create'])->name('create');
        Route::post('store', [BannerController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BannerController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [BannerController::class, 'update'])->name('update');
        Route::post('delete', [BannerController::class, 'delete'])->name('delete');
    });

    //Brand
    Route::group(['prefix' => 'brand', 'as' => 'brand.'], function () {
        Route::get('/show', [BrandController::class, 'show'])->name('show');
        Route::post('/list', [BrandController::class, 'list'])->name('list');
        Route::get('create', [BrandController::class, 'create'])->name('create');
        Route::post('store', [BrandController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [BrandController::class, 'update'])->name('update');
        Route::post('delete', [BrandController::class, 'delete'])->name('delete');
    });

    //Unit
    Route::group(['prefix' => 'unit', 'as' => 'unit.'], function () {
        Route::get('/show', [UnitController::class, 'show'])->name('show');
        Route::post('/list', [UnitController::class, 'list'])->name('list');
        Route::get('create', [UnitController::class, 'create'])->name('create');
        Route::post('store', [UnitController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UnitController::class, 'update'])->name('update');
        Route::post('delete', [UnitController::class, 'delete'])->name('delete');
    });

    //Slider
    Route::group(['prefix' => 'slider', 'as' => 'slider.'], function () {
        Route::get('/show', [SliderController::class, 'show'])->name('show');
        Route::post('/list', [SliderController::class, 'list'])->name('list');
        Route::get('create', [SliderController::class, 'create'])->name('create');
        Route::post('store', [SliderController::class, 'store'])->name('store');
        Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [SliderController::class, 'update'])->name('update');
        Route::post('delete', [SliderController::class, 'delete'])->name('delete');
    });

    //Menu
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function () {
        Route::get('/show', [MenuController::class, 'show'])->name('show');
        Route::post('/list', [MenuController::class, 'list'])->name('list');
        Route::get('create', [MenuController::class, 'create'])->name('create');
        Route::post('store', [MenuController::class, 'store'])->name('store');
        Route::get('edit/{id}', [MenuController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [MenuController::class, 'update'])->name('update');
        Route::post('delete', [MenuController::class, 'delete'])->name('delete');
        Route::post('check-parent-type', [MenuController::class, 'checkParentType'])->name('checkParentType');
    });

    //Pages
    Route::group(['prefix' => 'page', 'as' => 'page.'], function () {
        Route::get('/show', [PageController::class, 'show'])->name('show');
        Route::post('/list', [PageController::class, 'list'])->name('list');
        Route::get('create', [PageController::class, 'create'])->name('create');
        Route::post('store', [PageController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PageController::class, 'update'])->name('update');
        Route::post('delete', [PageController::class, 'delete'])->name('delete');
    });

    //Meta
    Route::group(['prefix' => 'meta', 'as' => 'meta.'], function () {
        Route::get('/show', [MetaController::class, 'show'])->name('show');
        Route::post('/list', [MetaController::class, 'list'])->name('list');
        Route::get('create', [MetaController::class, 'create'])->name('create');
        Route::post('store', [MetaController::class, 'store'])->name('store');
        Route::get('edit/{id}', [MetaController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [MetaController::class, 'update'])->name('update');
        Route::post('delete', [MetaController::class, 'delete'])->name('delete');
    });

    //Promotion
    Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function () {
        Route::get('/show', [PromotionController::class, 'show'])->name('show');
        Route::post('/list', [PromotionController::class, 'list'])->name('list');
        Route::get('create', [PromotionController::class, 'create'])->name('create');
        Route::post('store', [PromotionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PromotionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PromotionController::class, 'update'])->name('update');
        Route::post('delete', [PromotionController::class, 'delete'])->name('delete');
    });

    //Testimonial
    Route::group(['prefix' => 'testimonial', 'as' => 'testimonial.'], function () {
        Route::get('/show', [TestimonialController::class, 'show'])->name('show');
        Route::post('/list', [TestimonialController::class, 'list'])->name('list');
        Route::get('create', [TestimonialController::class, 'create'])->name('create');
        Route::post('store', [TestimonialController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TestimonialController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [TestimonialController::class, 'update'])->name('update');
        Route::post('delete', [TestimonialController::class, 'delete'])->name('delete');
    });

    //HotDeals
    Route::group(['prefix' => 'hotDeal', 'as' => 'hotDeal.'], function () {
        Route::get('/show', [HotDealController::class, 'show'])->name('show');
        Route::post('/list', [HotDealController::class, 'list'])->name('list');
        Route::get('create', [HotDealController::class, 'create'])->name('create');
        Route::post('store', [HotDealController::class, 'store'])->name('store');
        Route::get('edit/{id}', [HotDealController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [HotDealController::class, 'update'])->name('update');
        Route::post('delete', [HotDealController::class, 'delete'])->name('delete');
    });

    //Products
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/show', [ProductController::class, 'show'])->name('show');
        Route::post('/list', [ProductController::class, 'list'])->name('list');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('delete', [ProductController::class, 'delete'])->name('delete');

        Route::post('delete-product-image', [ProductController::class, 'deleteProductImage'])->name('deleteProductImage');

        Route::post('variation/addNew', [ProductController::class, 'variationAddNew'])->name('variation.addNew');
        Route::post('variation-type-change', [ProductController::class, 'variationTypeChange'])->name('variationTypeChange');
        Route::post('variation/type/change2', [ProductController::class, 'variationTypeChange2'])->name('variationTypeChange2');
        Route::post('variation-list-show', [ProductController::class, 'variationListShow'])->name('variationListShow');
        Route::post('variation-store', [ProductController::class, 'variationStore'])->name('variationStore');
        Route::post('delete-product-variation-temp', [ProductController::class, 'deleteProductVariationTemp'])->name('deleteProductVariationTemp');
        Route::post('search', [ProductController::class, 'productSearch'])->name('search');

        Route::post('variation/ajax/edit', [ProductController::class, 'variationAjaxEdit'])->name('variation.ajax.edit');
        Route::post('variation/update', [ProductController::class, 'variationUpdate'])->name('variation.update');
        Route::get('variation/image/delete/{id}', [ProductController::class, 'variationImageDelete'])->name('variation.image.delete');
        Route::post('variation/status', [ProductController::class, 'variationStatusChange'])->name('variation.status');

        //Product Category
        Route::post('find/subCategory', [ProductController::class, 'findSubCategory'])->name('find.subCategory');

        Route::post('productImage/delete', [ProductController::class, 'deleteProductImage'])->name('productImage.delete');

    });

    //Variation
    Route::group(['prefix' => 'variation', 'as' => 'variation.'], function () {
        Route::get('/show', [VariationController::class, 'show'])->name('show');
        Route::post('/list', [VariationController::class, 'list'])->name('list');
        Route::get('create', [VariationController::class, 'create'])->name('create');
        Route::post('store', [VariationController::class, 'store'])->name('store');
        Route::get('edit/{id}', [VariationController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [VariationController::class, 'update'])->name('update');
        Route::post('delete', [VariationController::class, 'delete'])->name('delete');
    });

    //Customer
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
        Route::get('/show', [CustomerController::class, 'show'])->name('show');
        Route::post('/list', [CustomerController::class, 'list'])->name('list');
        Route::get('create', [CustomerController::class, 'create'])->name('create');
        Route::post('store', [CustomerController::class, 'store'])->name('store');
        Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CustomerController::class, 'update'])->name('update');
        Route::post('delete', [CustomerController::class, 'delete'])->name('delete');
    });

    //Order
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/show', [OrderController::class, 'index'])->name('show');
        Route::post('/list', [OrderController::class, 'list'])->name('list');
        Route::get('create', [OrderController::class, 'create'])->name('create');
        Route::post('batch', [OrderController::class, 'addToOrder'])->name('batch');
        Route::post('/remove-item', [OrderController::class, 'removeItem'])->name('remove.item');
        Route::post('/upadate-quantity', [OrderController::class, 'updateQuantity'])->name('update.quantity');
        Route::post('/discount', [OrderController::class, 'discount'])->name('discount');
        Route::post('/order-submit', [OrderController::class, 'orderInsert'])->name('insert');
        Route::post('/order-update', [OrderController::class, 'orderUpdate'])->name('update');
        Route::get('/order-details/{id}', [OrderController::class, 'details'])->name('details');
        Route::get('/order-edit/{id}',[OrderController::class,'edit'])->name('edit');

        Route::post('/order-status', [OrderController::class, 'orderStatus'])->name('orderStatus');
        Route::post('/order-status-change', [OrderController::class, 'orderStatusChange'])->name('statusChangeSubmit');
        Route::post('/order-status-update/{id}', [OrderController::class, 'orderStatusUpdated'])->name('orderStatusUpdate');
        Route::post('/order-return-modal', [OrderController::class, 'returnModal'])->name('returnModal');
        Route::post('/order-return', [OrderController::class, 'singleReturn'])->name('singleReturn');
        // Route::post('store', [OrderController::class, 'store'])->name('store');
        // Route::get('edit/{id}', [OrderController::class, 'edit'])->name('edit');
        // Route::post('update/{id}', [OrderController::class, 'update'])->name('update');
        // Route::post('delete', [OrderController::class, 'delete'])->name('delete');
    });

     //Transaction
     Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::post('payment', [TransactionController::class, 'addPayment'])->name('payment');
        Route::post('customer-data', [TransactionController::class, 'savePayment'])->name('save.payment');
    });

});

Auth::routes();
