<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

// Halaman Welcome
Route::get('/', function () {
    return view('home.welcome');
})->name('welcome');

// Halaman Home (dengan pilihan SIGN IN dan SIGN UP)
Route::get('/home', function () {
    return view('home.home');
})->name('home');

// Pilih role
Route::get('/register/role', [RegistrationController::class, 'showSelectRole'])->name('register.role');

// Proses pemilihan role
Route::post('/register/role', [RegistrationController::class, 'processRoleSelection'])->name('select-role');

// Form registrasi berdasarkan role
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register.form');

// Proses registrasi
Route::post('/register', [RegistrationController::class, 'register'])->name('register');

// Form login
Route::get('/login', [RegistrationController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [RegistrationController::class, 'login'])->name('login.submit');

Route::get('/show_add_image', [RegistrationController::class, 'show_add_resto_pict'])->name('show_add_image');
Route::post('/add_image', [RegistrationController::class, 'add_resto_pict'])->name('add_image');

Route::get('/restaurant/home', [RestaurantController::class, 'restaurantHome'])->name('restaurant.home')->middleware('auth');

Route::get('/customer/home', [CustomerController::class, 'customerHome'])->name('customer.home')->middleware('auth');

// Route untuk redirect ke penyedia di bagian register(login with)
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::get('/restaurant/products/add', [ProductController::class, 'addProductForm'])->name('products.add');
Route::get('/restaurant/products/create', [ProductController::class, 'createProduct'])->name('products.create');
Route::post('/restaurant/products/add', [ProductController::class, 'storeProduct'])->name('products.store');
Route::get('/restaurant/products/edit/{id}', [ProductController::class, 'editProductForm'])->name('products.edit');
Route::put('/restaurant/products/update/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
Route::delete('/restaurant/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.destroy');
// Route::post('/restaurant/products', [RestaurantController::class, 'storeProduct'])->name('products.store');

Route::get('/customer/restaurant/{id}/products', [CustomerController::class, 'viewProducts'])->name('customer.products');//untuk product by resto
Route::get('/test', [CustomerController::class, 'test'])->name('test');

// Order Controller
Route::post('/customer/order', [OrderController::class, 'create'])->name('customer.order');
// Route::post('/customer/category/{name}', [RestaurantController::class, 'select_category'])->name('select.category');
Route::get('/customer/category/{category_id}/products', [CustomerController::class, 'productByCategory'])->name('category.products');//untuk product by category
