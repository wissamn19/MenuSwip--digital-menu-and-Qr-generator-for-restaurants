<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Session;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/landing-page', function () {
    return view('landing-page');
});



Route::get('/contact-us', function () {
    return view('contact-us');
});



Route::get('/forget_password', function () {
    return view('forget_password');
});

Route::get('/reset_password', function () {
    return view('reset_password');
});

Route::get('/menu-type-1', function () {
    return view('menu-type-1');
});



Route::get('/menu-type-2', function () {
    return view('menu-type-2');
});



Route::get('/menu-type-3', function () {
    return view('menu-type-3');
});



Route::get('/owner-profile', function () {
    return view('owner-profile');
});

Route::get('/registration-done', function () {
    return view('registration-done', [
        'owner_id' => session('owner_id')
    ]);
})->name('registration.done');




Route::get('/registration-owner', function () {
    return view('registration-owner');
})->name('registration-owner');

Route::get('/registration-owner-2', function () {
    return view('registration-owner-2');
})->name('registration-owner-2');

Route::get('/registration-owner-3', function () {
    return view('registration-owner-3');
})->name('registration-owner-3');

use App\Http\Controllers\ForgetPassword;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\LogInOwner;


// Show forgot password form
Route::get('/forgot_password', function () {
    return view('forget_password');
})->name('forgot.password.form');

// Handle email submission
Route::post('/forgot_password', [ForgetPassword::class, 'sendResetLink'])->name('forgot.password');

// Show reset form via token in email
Route::get('/reset-password', [ResetPassword::class, 'showResetForm'])->name('reset.password.form');

// Handle actual password reset
Route::post('/reset-password', [ResetPassword::class, 'resetPassword'])->name('reset.password');

// Redirect fallback
Route::get('/password/request', function () {
    return redirect()->route('forgot.password.form');
})->name('password.request');

// Owner login
Route::get('/log-in-owner', [LogInOwner::class, 'showLoginForm']);
Route::get('/owner/login', [LogInOwner::class, 'showLoginForm'])->name('owner.login');
Route::post('/owner/login', [LogInOwner::class, 'login'])->name('owner.login.submit');
Route::post('/owner/logout', [LogInOwner::class, 'logout'])->name('owner.logout');










Route::get('/pos-home' , function() {
    return view('pos-home');
});

Route::get('/pos-menu', function() {
    return view('pos-menu');
});

Route::get('/pos-orders', function () {
    return view('pos-orders');
});

use App\Http\Controllers\RegistrationDone;

Route::post('/store-session', [RegistrationDone::class, 'storeSession']);

use App\Http\Controllers\RegistrationOwner1;

Route::post('/registration-owner-1', [RegistrationOwner1::class, 'store'])->name('store-1');

use App\Http\Controllers\RegistrationOwner2;

Route::post('/registration-owner-2', [RegistrationOwner2::class, 'store'])->name('store-2');

use App\Http\Controllers\RegistrationOwner3;

Route::post('/registration-owner-3', [RegistrationOwner3::class, 'store'])->name('store-3');



    


use App\Http\Controllers\SaveType;

Route::post('/type/store', [SaveType::class, 'store'])->name('type.store');



use App\Http\Controllers\Upload;

Route::post('/upload-restaurant-image', [Upload::class, 'upload']);

use App\Http\Controllers\RestaurantController;

Route::get('/owner-profile/{id}', [RestaurantController::class, 'ownerProfile'])->name('owner.profile');



// Restaurant routes
Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurant/create', [App\Http\Controllers\RestaurantController::class, 'create'])->name('restaurant.create');
Route::post('/restaurant', [App\Http\Controllers\RestaurantController::class, 'store'])->name('restaurant.store');
Route::get('/restaurant/{id}', [App\Http\Controllers\RestaurantController::class, 'show'])->name('restaurant.show');
Route::get('/restaurant/{id}/edit', [App\Http\Controllers\RestaurantController::class, 'edit'])->name('restaurant.edit');
Route::put('/restaurant/{id}', [App\Http\Controllers\RestaurantController::class, 'update'])->name('restaurant.update');
Route::delete('/restaurant/{id}', [App\Http\Controllers\RestaurantController::class, 'destroy'])->name('restaurant.destroy');

// Additional restaurant routes
Route::post('/restaurant/upload-image', [App\Http\Controllers\RestaurantController::class, 'uploadImage'])->name('restaurant.upload-image');
Route::get('/restaurants/owner/{ownerId}', [App\Http\Controllers\RestaurantController::class, 'getByOwner'])->name('restaurant.by-owner');
Route::get('/restaurants/search', [App\Http\Controllers\RestaurantController::class, 'search'])->name('restaurant.search');
Route::get('/restaurant/{id}/hours', [App\Http\Controllers\RestaurantController::class, 'getWorkingHours'])->name('restaurant.hours');
Route::put('/restaurant/{id}/hours', [App\Http\Controllers\RestaurantController::class, 'updateWorkingHours'])->name('restaurant.update-hours');


use App\Http\Controllers\FoodItemController;

// Food Item Routes
Route::get('/menu/type/1', [FoodItemController::class, 'create'])->name('menu.type.1');
Route::post('/menu/food-items', [FoodItemController::class, 'store'])->name('food-items.store');
Route::post('/menu/upload-image', [FoodItemController::class, 'uploadImage'])->name('food-items.upload-image');




use App\Http\Controllers\DrinkItemController;

// Drink Item Routes
Route::get('/menu/type/3', [DrinkItemController::class, 'create'])->name('menu.type.3');
Route::post('/menu/drink-items', [DrinkItemController::class, 'store'])->name('drink-items.store');


use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PosController;

Route::get('/debug-routes', function () {
    $routes = Route::getRoutes();
    foreach ($routes as $route) {
        echo $route->uri() . ' - ' . $route->getName() . '<br>';
    }
});



// POS Home Page
Route::get('/pos/{owner_id}/home', [PosController::class, 'home'])->name('pos.home');

// POS Menu Page
Route::get('/pos/{owner_id}/menu', [PosController::class, 'menu'])->name('pos.menu');

// POS Confirm Order
Route::post('/pos/{owner_id}/confirm-order', [PosController::class, 'confirmOrder'])->name('pos.confirmOrder');

// POS Order Status Check
Route::get('/pos/{owner_id}/order-status', [PosController::class, 'orderStatusCheck'])->name('pos.orderStatus');

// POS Orders Page
Route::get('/pos/{owner_id}/orders', [PosController::class, 'orders'])->name('pos.orders');


// Update Order Status
Route::post('/pos/{owner_id}/orders/{orderId}/status', [PosController::class, 'updateOrderStatus'])->name('pos.updateOrderStatus');
// Print Order Receipt
Route::get('/pos/{owner_id}/orders/{orderId}/receipt', [PosController::class, 'printReceipt'])->name('pos.printReceipt');
// Get Receipt Data (JSON)
Route::get('/pos/{owner_id}/orders/{orderId}/receipt-data', [PosController::class, 'getReceiptData'])->name('pos.receiptData');
// Toggle Order Status (ON/OFF)
Route::post('/pos/{owner_id}/order-status/toggle', [PosController::class, 'toggleOrderStatus'])->name('pos.toggleOrderStatus');

// Update Menu Item
Route::post('/pos/{owner_id}/menu/{itemId}/update', [PosController::class, 'updateMenuItem'])->name('pos.updateMenuItem');



// Menu item



Route::get('/menutype-1/{restaurant}', [MenuItemController::class,'showType1'])->name('menu.type1');
Route::get('/menu-type-2/{restaurant}', [MenuItemController::class,'showType2'])->name('menu.type2');
Route::get('/menu-type-3/{restaurant}', [MenuItemController::class, 'showType3'])->name('menu.type3');

Route::post('/food-items', [MenuItemController::class, 'store'])->name('food-items.store');
use App\Http\Controllers\FoodImageUploadController;
Route::post('/food-items/upload-image', [FoodImageUploadController::class, 'upload'])->name('food-items.upload-image');




Route::post('/menu/type1/{restaurant}', [MenuItemController::class, 'store'])->name('menu.store');
Route::post('/menu/type2/{restaurant}', [MenuItemController::class, 'storeType2'])->name('menu.storeType2');
Route::post('/menu/type3/{restaurant}', [MenuItemController::class, 'storeType3'])->name('menu.storeType3');


Route::get('/menus/default/{restaurant_id}', [MenuItemController::class, 'defaultMenu'])->name('menu.default');

use App\Http\Controllers\QrCodeController;

Route::get('/qr-code/generate/{restaurant_id}', [QrCodeController::class, 'generate'])->name('qr-code.generate');
Route::get('/show', [QrCodeController::class, 'showQR'])->name('qrcode.show');

