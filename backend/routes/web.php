<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SeverityController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/log', [LoginController::class, 'log'])->name('log');

Route::get('/register', [RegisterController::class, 'newuser'])->name('newuser');
Route::post('/adduser', [RegisterController::class, 'adduser'])->name('adduser');

Route::get('/newdepartment', [DepartmentController::class, 'newdepartment'])->name('newdepartment');
Route::post('/adddepartment', [DepartmentController::class, 'adddepartment'])->name('adddepartment');

Route::get('/newseverity', [SeverityController::class, 'newseverity'])->name('newseverity');

Route::get('/newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');