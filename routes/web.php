<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaveiconController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'welcome'])->name('welcome');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//  user
Route::get('/user/info', [UserController::class, 'user_info'])->name('user.info');
Route::post('/user/info/update', [UserController::class, 'user_info_update'])->name('user.info.update');
Route::post('/user/password/update', [UserController::class, 'user_password_update'])->name('user.password.update');
Route::post('/user/photo/update', [UserController::class, 'user_photo_update'])->name('user.photo.update');

// users
Route::post('/user/list', [HomeController::class, 'user_add'])->name('user.add');
Route::get('/user/list', [HomeController::class, 'user_list'])->name('user.list');
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');


// category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'category_store'])->name('category.store');
Route::post('/category/update/{category_id}', [CategoryController::class, 'category_update'])->name('category.update');
Route::get('/category/delet/{category_id}', [CategoryController::class, 'category_soft_delete'])->name('category.soft.delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/parmarent/delete/{category_id}', [CategoryController::class, 'parmarent_delete'])->name('category.parmarent.delete');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/checked_delete/', [CategoryController::class, 'checked_delete'])->name('checked.delete');
Route::post('/category/checked_restore/', [CategoryController::class, 'checked_restore'])->name('checked.restore');
Route::get('/category/trash/', [CategoryController::class, 'category_trash'])->name('category.trash');


// subcategory

Route::get('/subcategory', [SubcategoryController::class, 'sub_category'])->name('sub.category');
Route::post('/subcategory/store', [SubcategoryController::class, 'sub_category_store'])->name('sub.category.store');
Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'sub_category_edit'])->name('sub.category.edit');
Route::post('/subcategory/update/{id}', [SubcategoryController::class, 'sub_category_update'])->name('sub.category.update');
Route::get('/subcategory/delete/{id}', [SubcategoryController::class, 'sub_category_delete'])->name('sub.category.delete');

// Products
Route::get('/product', [ProductController::class, 'product_add'])->name('product.add');
Route::post('/getsubcategory', [ProductController::class, 'getsubcategory']);
Route::post('/product/store', [ProductController::class, 'product_stroe'])->name('product.stroe');
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/edit/{id}', [ProductController::class, 'product_edit'])->name('product.edit');
Route::post('/product/update/{id}', [ProductController::class, 'product_update'])->name('product.update');
Route::get('/product/delete/{id}', [ProductController::class, 'product_delete'])->name('product.delete');
Route::post('/getstatus', [ProductController::class, 'getstatus']);
Route::delete('/ajax-gallery-image-delete/{id}', [ProductController::class, 'ajaxDeleteGalleryImage'])->name('gallery.image.ajax.delete');

// Brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');
Route::get('/brand/delete/{id}', [BrandController::class, 'brand_delete'])->name('brand.delete');

// variation
Route::get('/variation', [VariationController::class, 'variation'])->name('variation');
Route::post('/variation/store', [VariationController::class, 'color_store'])->name('color.store');
Route::post('/size/store', [VariationController::class, 'size_store'])->name('size.store');
Route::get('/size/delete/{id}', [VariationController::class, 'variation_delete'])->name('variation.delete');
Route::get('/color/delete/{id}', [VariationController::class, 'color_delete'])->name('color.delete');


// inventory
Route::get('/inventory/{id}', [InventoryController::class, 'add_inventory'])->name('add.inventory');
Route::post('/inventory/store/{id}', [InventoryController::class, 'inventory_store'])->name('inventory.store');
Route::get('/inventory/delete/{id}', [InventoryController::class, 'inventory_delete'])->name('inventory.delete');

// banner
Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
Route::post('/banner/store', [BannerController::class, 'banner_store'])->name('banner.store');
Route::get('/banner/edit/{id}', [BannerController::class, 'banner_edit'])->name('banner.edit');
Route::Post('/banner/update/{id}', [BannerController::class, 'banner_update'])->name('banner.update');
Route::get('/banner/delete/{id}', [BannerController::class, 'banner_delete'])->name('banner.delete');

// logo
Route::get('/logo', [LogoController::class, 'logo'])->name('logo');
Route::post('/logo/store', [LogoController::class, 'logo_store'])->name('logo.store');
Route::get('/logo/delete/{id}', [LogoController::class, 'logo_delete'])->name('logo.delete');
Route::post('/getstatus-logo', [LogoController::class, 'getstatus_logo']);

// faveicon
Route::post('/faveicon/store', [FaveiconController::class, 'faveicon_store'])->name('faveicon.store');
Route::post('/getstatus-faveicon', [FaveiconController::class, 'getstatus_faveicon']);
Route::get('/faveicon/edit/{id}', [FaveiconController::class, 'faveicon_edit'])->name('faveicon.edit');
Route::post('/faveicon/update/{id}', [FaveiconController::class, 'faveicon_update'])->name('faveicon.update');
Route::get('/faveicon/delete/{id}', [FaveiconController::class, 'faveicon_delete'])->name('faveicon.delete');

// offer
Route::get('/offer', [OfferController::class, 'offer'])->name('offer');
Route::post('/offer/update/{id}', [OfferController::class, 'offer1_update'])->name('offer1.update');
Route::post('/offer/update2/{id}', [OfferController::class, 'offer2_update'])->name('offer2.update');

// subscribe
Route::post('/subscribe/store', [FrontendController::class, 'subscribe_store'])->name('subscribe.store');
Route::get('/subscribe/list', [HomeController::class, 'Subscriber_list'])->name('Subscriber.list');