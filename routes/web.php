<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\SettingController;


// Route::get('/page', function () {
//     return view('welcome'); 
// });



Route::get('/', function () {
    return redirect('login');
});

// Auth
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
// Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

// Setting
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'storeOrUpdate'])->name('settings.storeOrUpdate');

// Product Portfolio
Route::get('dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('add', [ProductController::class, 'create']);
Route::post('add', [ProductController::class, 'store'])->name('product.store');
Route::get('{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('{id}/update', [ProductController::class, 'update'])->name('product.update');
Route::delete('{id}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

//Show
Route::get('/{encodedId}', [ProductController::class, 'show'])->name('welcome.show');
Route::post('/product/copy/{id}', [ProductController::class, 'copy'])->name('product.copy');

Route::get('/get-sample-status', [SettingController::class, 'getSampleStatus'])->name('get.sample.status');



