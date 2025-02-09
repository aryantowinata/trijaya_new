<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;



Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/product', [PageController::class, 'product'])->name('product');
Route::get('/product_detail/{id}', [PageController::class, 'product_detail'])->name('product_detail');
Route::get('/user/cart', [CartController::class, 'view'])->name('user.cart');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');


Route::middleware([AdminMiddleware::class])->name('admin.')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'loginAdmin'])->name('login');
    Route::post('admin/postLogin', [AdminController::class, 'postLogin'])->name('postLogin');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboardAdmin'])->name('dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profileAdmin'])->name('profile');
    Route::get('/admin/product', [AdminController::class, 'productAdmin'])->name('product');
    Route::get('/admin/orders', [AdminController::class, 'ordersAdmin'])->name('orders');
    Route::get('/admin/users', [AdminController::class, 'usersAdmin'])->name('users');
    Route::get('/admin/orders/{order}/detail', [AdminController::class, 'detailOrderAdmin'])->name('order-detail');

    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('logout');
    Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/admin/storeProductAdmin', [AdminController::class, 'storeProductAdmin'])->name('storeProductAdmin');
    Route::post('/admin/storeKategoriAdmin', [AdminController::class, 'storeKategoriAdmin'])->name('storeKategoriAdmin');
    Route::post('/admin/product/update/{product}', [AdminController::class, 'updateProductAdmin'])->name('updateProductAdmin');
    Route::post('/admin/users/update/{id}', [AdminController::class, 'updateUsersAdmin'])->name('updateUsersAdmin');
    Route::post('/admin/update-password', [AdminController::class, 'updatePassword'])->name('updatePassword');
    Route::delete('/admin/hapusProductAdmin/{id}', [AdminController::class, 'hapusProductAdmin'])->name('hapusProductAdmin');
    Route::delete('/admin/hapusOrderAdmin/{id}', [AdminController::class, 'hapusOrderAdmin'])->name('hapusOrderAdmin');
    Route::delete('/admin/hapusUsersAdmin/{id}', [AdminController::class, 'hapusUsersAdmin'])->name('hapusUsersAdmin');
});

Route::middleware([UserMiddleware::class])->name('user.')->group(function () {
    Route::get('/user/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/user/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/user/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/user/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/user/register', [LoginController::class, 'register'])->name('register.submit');
    Route::post('/user/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/user/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/user/cart/buy-now/{id}', [CartController::class, 'buyNow'])->name('cart.buyNow');
    Route::delete('/user/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('/user/order', [OrderController::class, 'order'])->name('order');
    Route::get('/user/history', [OrderController::class, 'history'])->name('history');
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/user/history/{order}/detail', [OrderController::class, 'order_detail_user'])->name('order-detail-user');
    Route::post('/user/profile/update', [ProfileController::class, 'updateProfileUser'])->name('updateProfileUser');
    Route::post('/user/password/update', [ProfileController::class, 'updatePasswordUser'])->name('updatePasswordUser');
});
