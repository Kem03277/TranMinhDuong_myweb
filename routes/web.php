<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PostController;
use Symfony\Component\Routing\Loader\Configurator\Traits\PrefixTrait;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return "Test";
});


Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);



//Buoi2 Lab3 tiep theo bo sung

//Lab 4
Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.home');

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);

// Route::prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.home');
// });

Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'postLogin'])
        ->name('login.post');


    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])
        ->name('forgotpass');

    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])
        ->name('forgotpass.post');

    Route::middleware('auth')->group(function () {

        Route::get('/change-password', [AuthController::class, 'changePassword'])
            ->name('change-password');

        Route::post('/change-password', [AuthController::class, 'postChangePassword'])
            ->name('change-password.post');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage']);
        Route::resource('posts', PostController::class);
    });
});
