<?php

use App\Http\Controllers\RestaurantController;

// Halaman Welcome
Route::get('/', function () {
    return view('home.welcome');
})->name('welcome');

// Halaman Home (dengan pilihan SIGN IN dan SIGN UP)
Route::get('/home', function () {
    return view('home.home');
})->name('home');

// Pilih role
Route::get('/register/role', [RestaurantController::class, 'showSelectRole'])->name('register.role');

// Proses pemilihan role
Route::post('/register/role', [RestaurantController::class, 'processRoleSelection'])->name('select-role');

// Form registrasi berdasarkan role
Route::get('/register', [RestaurantController::class, 'showRegistrationForm'])->name('register.form');

// Proses registrasi
Route::post('/register', [RestaurantController::class, 'register'])->name('register');

Route::get('/show_add_image', [RestaurantController::class, 'show_add_resto_pict'])->name('show_add_image');
Route::post('/add_image', [RestaurantController::class, 'add_resto_pict'])->name('add_image');

// Form login
Route::get('/login', [RestaurantController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [RestaurantController::class, 'login'])->name('login.submit');

Route::get('/customer/home', [RestaurantController::class, 'customerHome'])->name('customer.home')->middleware('auth');

Route::get('/restaurant/home', [RestaurantController::class, 'restaurantHome'])->name('restaurant.home')->middleware('auth');

// Route untuk redirect ke penyedia di bagian register(login with)
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::get('/restaurant/products/add', [RestaurantController::class, 'addProductForm'])->name('products.add');
Route::get('/restaurant/products/create', [RestaurantController::class, 'createProduct'])->name('products.create');
Route::post('/restaurant/products/add', [RestaurantController::class, 'storeProduct'])->name('products.store');
Route::get('/restaurant/products/edit/{id}', [RestaurantController::class, 'editProductForm'])->name('products.edit');
Route::put('/restaurant/products/update/{id}', [RestaurantController::class, 'updateProduct'])->name('products.update');
Route::delete('/restaurant/products/{id}', [RestaurantController::class, 'deleteProduct'])->name('products.destroy');
Route::post('/restaurant/products', [RestaurantController::class, 'storeProduct'])->name('products.store');

Route::get('/customer/restaurant/{id}/products', [RestaurantController::class, 'viewProducts'])->name('customer.products');
