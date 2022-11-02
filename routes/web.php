<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/create-request',[RequestController::class,'createView'])->name('create.request')->middleware('throttle:only_three_requests')->middleware('role:0');
    Route::any('/post-request',[RequestController::class,'postRequest'])->name('post.request')->middleware('throttle:only_three_requests')->middleware('role:0');
    Route::any('/post-approve',[RequestController::class,'postApprove'])->name('post.approve')->middleware('throttle:only_two_approves')->middleware('min.role:1');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('throttle:api');
    Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');
});
//Route::put('/post/{id}', function ($id) {
//    //
//})->middleware('role:editor');
