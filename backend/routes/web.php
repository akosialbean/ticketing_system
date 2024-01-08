<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->name('index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('/home');

Auth::routes();

// Route::middleware(['auth'])->group(function(){
    Route::get('/register', [RegistrationController::class, 'register'])->name('register');
// });


