<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [HomeController::class,'index']);
 
Route::get('/redirects', [HomeController::class,'redirects']);

Route::post('/addcart/{id}', [HomeController::class,'addcart']);

Route::get('/showcart/{id}', [HomeController::class,'showcart']);

Route::get('/deletecart/{id}', [HomeController::class,'deletecart']);

Route::post('/orderconfirm', [HomeController::class,'orderconfirm']);

Route::get('/users', [AdminController::class,'user']);

Route::get('/foodmenu', [AdminController::class,'food']);

Route::get('/viewchef', [AdminController::class,'viewchef']);

Route::get('/viewreservation', [AdminController::class,'viewreservation']);

Route::post('/reservation', [AdminController::class,'reservation']);

Route::post('/uploadfood', [AdminController::class,'upload']);

Route::post('/uploadchef', [AdminController::class,'uploadchef']);

Route::post('/updatechef', [AdminController::class,'updatechef']);

Route::post('/updatefood', [AdminController::class,'update']);

Route::get('/deletefood/{id}', [AdminController::class,'deletefood']);

Route::get('/deletechef/{id}', [AdminController::class,'deletechef']);

Route::get('/orders', [AdminController::class,'orders']);

Route::get('/search', [AdminController::class,'search']);

Route::get('/delete/{id}', [AdminController::class,'destroy']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
