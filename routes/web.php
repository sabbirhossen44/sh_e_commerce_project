<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
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
Route::post('/getstatus', [ProductController::class, 'getstatus']);

// Brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');

// variation
Route::get('/variation', [VariationController::class, 'variation'])->name('variation');
Route::post('/variation/store', [VariationController::class, 'color_store'])->name('color.store');
Route::post('/size/store', [VariationController::class, 'size_store'])->name('size.store');