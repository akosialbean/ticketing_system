<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SeverityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

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
Route::get('/users', [UserController::class, 'users'])->name('users');

Route::get('/newdepartment', [DepartmentController::class, 'newdepartment'])->name('newdepartment');
Route::post('/adddepartment', [DepartmentController::class, 'adddepartment'])->name('adddepartment');
Route::get('/departments', [DepartmentController::class, 'departments'])->name('departments');

Route::get('/newseverity', [SeverityController::class, 'newseverity'])->name('newseverity');
Route::post('/addseverity', [SeverityController::class, 'add'])->name('addseverity');
Route::get('/severities', [SeverityController::class, 'severities'])->name('severities');

Route::get('/newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
Route::post('/addcategory', [CategoryController::class, 'add'])->name('addcategory');
Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');

Route::get('/newticket', [TicketController::class, 'newticket'])->name('newticket');
Route::post('/addticket', [TicketController::class, 'add'])->name('addticket');
Route::get('/alltickets', [TicketController::class, 'alltickets'])->name('alltickets');
Route::patch('/openticket', [TicketController::class, 'openticket'])->name('openticket');
Route::get('/ticket/{ticket}', [TicketController::class, 'ticket'])->name('ticket');
Route::patch('/acknowledge', [TicketController::class, 'acknowledge'])->name('acknowledge');
Route::patch('/resolve', [TicketController::class, 'resolve'])->name('resolve');
Route::patch('/close', [TicketController::class, 'close'])->name('close');
Route::patch('/cancel', [TicketController::class, 'cancel'])->name('cancel');