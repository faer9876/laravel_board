<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('/boards', BoardsController::class);
Route::get('/users/login',[UserController::class, 'login'])->name('users.login');
Route::post('/users/loginpost',[UserController::class, 'loginpost'])->name('users.login.post');
Route::get('/users/registration',[UserController::class, 'registration'])->name('users.registration');
Route::post('/users/registrationpost',[UserController::class, 'registrationpost'])->name('users.registration.post');
Route::get('/users/logout',[UserController::class, 'logout'])->name('users.logout');
Route::get('/users/withdraw',[UserController::class, 'withdraw'])->name('users.withdraw');
Route::get('/users/{id}/userEdit',[UserController::class, 'userEdit'])->name('users.userEdit');
Route::post('/users/userEditUpdate',[UserController::class, 'userEditUpdate'])->name('users.userEditUpdate');
Route::post('/users/userEditpost',[UserController::class, 'userEditpost'])->name('users.userEdit.post');
