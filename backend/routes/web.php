<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SeverityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\CheckUserRole;

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

Route::get('/', [LoginController::class, 'login'])->middleware(CheckSession::class)->name('login');
Route::post('/log', [LoginController::class, 'log'])->name('log');
Route::get('/user/firstlogin', [LoginController::class, 'firstlogin'])->middleware(CheckSession::class)->name('firstlogin');
Route::patch('/user/firstlogin/changepassword', [LoginController::class, 'changepassword'])->name('changepassword');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(CheckUserRole::class)->name('dashboard');
    Route::get('/register', [RegisterController::class, 'newuser'])->middleware(CheckUserRole::class)->name('newuser');
    Route::post('/adduser', [RegisterController::class, 'adduser'])->middleware(CheckUserRole::class)->name('adduser');
    Route::get('/users', [UserController::class, 'users'])->middleware(CheckUserRole::class)->name('users');
    Route::get('/user/{userid}', [UserController::class, 'user'])->name('user');
    Route::patch('/user/changepassword', [UserController::class, 'changepassword'])->name('changepassword');
    Route::patch('/user/disable', [UserController::class, 'disable'])->middleware(CheckUserRole::class)->name('disable');
    Route::patch('/user/reactivate', [UserController::class, 'reactivate'])->middleware(CheckUserRole::class)->name('reactivate');
    Route::patch('/user/resetpassword', [UserController::class, 'resetpassword'])->middleware(CheckUserRole::class)->name('resetpassword');
    Route::patch('/user/updateuserprofile', [UserController::class, 'updateuserprofile'])->name('updateuserprofile');
    Route::post('/users/search', [UserController::class, 'searchuser'])->middleware(CheckUserRole::class)->name('searchuser');
    Route::patch('/user/{id}/changeusername', [UserController::class, 'changeusername'])->middleware(CheckUserRole::class)->name('changeusername');

    Route::get('/newdepartment', [DepartmentController::class, 'newdepartment'])->middleware(CheckUserRole::class)->name('newdepartment');
    Route::post('/adddepartment', [DepartmentController::class, 'adddepartment'])->middleware(CheckUserRole::class)->name('adddepartment');
    Route::get('/departments', [DepartmentController::class, 'departments'])->middleware(CheckUserRole::class)->name('departments');
    Route::get('/department/{d_id}', [DepartmentController::class, 'department'])->middleware(CheckUserRole::class)->name('department');
    Route::patch('/department/{d_id}/edit', [DepartmentController::class, 'editdepartment'])->middleware(CheckUserRole::class)->name('editdepartment');

    Route::get('/newseverity', [SeverityController::class, 'newseverity'])->middleware(CheckUserRole::class)->name('newseverity');
    Route::post('/addseverity', [SeverityController::class, 'add'])->middleware(CheckUserRole::class)->name('addseverity');
    Route::get('/severities', [SeverityController::class, 'severities'])->middleware(CheckUserRole::class)->name('severities');
    Route::get('/severity/{s_id}', [SeverityController::class, 'severity'])->middleware(CheckUserRole::class)->name('severity');
    Route::patch('/severity/{s_id}/edit', [SeverityController::class, 'editseverity'])->middleware(CheckUserRole::class)->name('editseverity');

    Route::get('/newcategory', [CategoryController::class, 'newcategory'])->middleware(CheckUserRole::class)->name('newcategory');
    Route::post('/addcategory', [CategoryController::class, 'add'])->middleware(CheckUserRole::class)->name('addcategory');
    Route::get('/categories', [CategoryController::class, 'categories'])->middleware(CheckUserRole::class)->name('categories');
    Route::get('/category/{c_id}', [CategoryController::class, 'category'])->middleware(CheckUserRole::class)->name('category');
    Route::patch('/category/{c_id}/edit', [CategoryController::class, 'editcategory'])->middleware(CheckUserRole::class)->name('editcategory');
    Route::post('/categories/search', [CategoryController::class, 'searchcategory'])->middleware(CheckUserRole::class)->name('searchcategory');

    Route::get('/newticket', [TicketController::class, 'newticket'])->name('newticket');
    Route::post('/addticket', [TicketController::class, 'add'])->name('addticket');
    Route::patch('/openticket', [TicketController::class, 'openticket'])->middleware(CheckUserRole::class)->name('openticket');
    Route::get('/ticket/{ticket}', [TicketController::class, 'ticket'])->name('ticket');
    Route::patch('/acknowledge', [TicketController::class, 'acknowledge'])->middleware(CheckUserRole::class)->name('acknowledge');
    Route::patch('/resolve', [TicketController::class, 'resolve'])->middleware(CheckUserRole::class)->name('resolve');
    Route::patch('/close', [TicketController::class, 'close'])->name('close');
    Route::patch('/cancel', [TicketController::class, 'cancel'])->name('cancel');
    Route::post('{department}/tickets/{mytickets}/{column}/{order}', [TicketController::class, 'searchticket'])->name('searchticket');
    Route::post('/tickets/addcomment', [CommentController::class, 'addcomment'])->name('addcomment');
    Route::get('{department}/tickets/{mytickets}/{column}/{order}', [TicketController::class, 'sort'])->name('tickets');

    Route::get('/download/{file}', [TicketController::class, 'downloadfile'])->name('downloadfile');

    Route::get('/report', [ReportController::class, 'report'])->middleware(CheckUserRole::class)->name('report');
    Route::post('/report/generate', [ReportController::class, 'generate'])->middleware(CheckUserRole::class)->name('generate');
    Route::get('/report/export', [ReportController::class, 'export'])->middleware(CheckUserRole::class)->name('export');

    // Locals
    Route::get('/locals', [LocalController::class, 'locals'])->name('locals');
    Route::get('/locals/newlocal', [LocalController::class, 'newlocal'])->middleware(CheckUserRole::class)->name('newlocal');
    Route::post('/locals/addlocal', [LocalController::class, 'addlocal'])->middleware(CheckUserRole::class)->name('addlocal');
    Route::post('/locals/search', [LocalController::class, 'searchlocal'])->name('searchlocal');
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');