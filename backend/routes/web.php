<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SeverityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

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
Route::get('/user/firstlogin', [LoginController::class, 'firstlogin'])->name('firstlogin');
Route::patch('/user/firstlogin/changepassword', [LoginController::class, 'changepassword'])->name('changepassword');

Route::get('/test/mail', [TestController::class, 'sendEmail'])->name('testmail');



Route::middleware(['auth'])->group(function() {
    Route::get('/register', [RegisterController::class, 'newuser'])->name('newuser');
    Route::post('/adduser', [RegisterController::class, 'adduser'])->name('adduser');
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::get('/user/{userid}', [UserController::class, 'user'])->name('user');
    Route::patch('/user/changepassword', [UserController::class, 'changepassword'])->name('changepassword');
    Route::patch('/user/disable', [UserController::class, 'disable'])->name('disable');
    Route::patch('/user/reactivate', [UserController::class, 'reactivate'])->name('reactivate');
    Route::patch('/user/resetpassword', [UserController::class, 'resetpassword'])->name('resetpassword');
    Route::patch('/user/updateuserprofile', [UserController::class, 'updateuserprofile'])->name('updateuserprofile');
    Route::post('/users/search', [UserController::class, 'searchuser'])->name('searchuser');
    Route::patch('/user/{id}/changeusername', [UserController::class, 'changeusername'])->name('changeusername');

    Route::get('/newdepartment', [DepartmentController::class, 'newdepartment'])->name('newdepartment');
    Route::post('/adddepartment', [DepartmentController::class, 'adddepartment'])->name('adddepartment');
    Route::get('/departments', [DepartmentController::class, 'departments'])->name('departments');
    Route::get('/department/{d_id}', [DepartmentController::class, 'department'])->name('department');
    Route::patch('/department/{d_id}/edit', [DepartmentController::class, 'editdepartment'])->name('editdepartment');

    Route::get('/newseverity', [SeverityController::class, 'newseverity'])->name('newseverity');
    Route::post('/addseverity', [SeverityController::class, 'add'])->name('addseverity');
    Route::get('/severities', [SeverityController::class, 'severities'])->name('severities');
    Route::get('/severity/{s_id}', [SeverityController::class, 'severity'])->name('severity');
    Route::patch('/severity/{s_id}/edit', [SeverityController::class, 'editseverity'])->name('editseverity');

    Route::get('/newcategory', [CategoryController::class, 'newcategory'])->name('newcategory');
    Route::post('/addcategory', [CategoryController::class, 'add'])->name('addcategory');
    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    Route::get('/category/{c_id}', [CategoryController::class, 'category'])->name('category');
    Route::patch('/category/{c_id}/edit', [CategoryController::class, 'editcategory'])->name('editcategory');
    Route::post('/categories/search', [CategoryController::class, 'searchcategory'])->name('searchcategory');

    Route::get('/newticket', [TicketController::class, 'newticket'])->name('newticket');
    Route::post('/addticket', [TicketController::class, 'add'])->name('addticket');
    Route::get('/tickets', [TicketController::class, 'alltickets'])->name('tickets');
    Route::patch('/openticket', [TicketController::class, 'openticket'])->name('openticket');
    Route::get('/ticket/{ticket}', [TicketController::class, 'ticket'])->name('ticket');
    Route::patch('/acknowledge', [TicketController::class, 'acknowledge'])->name('acknowledge');
    Route::patch('/resolve', [TicketController::class, 'resolve'])->name('resolve');
    Route::patch('/close', [TicketController::class, 'close'])->name('close');
    Route::patch('/cancel', [TicketController::class, 'cancel'])->name('cancel');
    Route::get('/tickets/mytickets', [TicketController::class, 'mytickets'])->name('mytickets');
    Route::get('/tickets/opentickets', [TicketController::class, 'opentickets'])->name('opentickets');
    Route::get('/tickets/acknowledgedtickets', [TicketController::class, 'acknowledgedtickets'])->name('acknowledgedtickets');
    Route::get('/tickets/resolvedtickets', [TicketController::class, 'resolvedtickets'])->name('resolvedtickets');
    Route::get('/tickets/closedtickets', [TicketController::class, 'closedtickets'])->name('closedtickets');
    Route::get('/tickets/cancelledtickets', [TicketController::class, 'cancelledtickets'])->name('cancelledtickets');
    Route::get('/ticket/{ticket}/editticket', [TicketController::class, 'editticket'])->name('editticket');
    Route::patch('/ticket/{ticket}/editticket/edit', [TicketController::class, 'edit'])->name('edit');
    Route::patch('/ticket/{ticket}/setseverity', [TicketController::class, 'setseverity'])->name('setseverity');
    Route::patch('/ticket/{ticket}/assignto', [TicketController::class, 'assignto'])->name('assignto');
    Route::get('/tickets/assignedtickets', [TicketController::class, 'assignedtickets'])->name('assignedtickets');
    Route::post('/tickets/search', [TicketController::class, 'searchticket'])->name('searchticket');
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');