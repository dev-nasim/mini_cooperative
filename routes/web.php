<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CooperativeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingAccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::resource('/user', UserController::class);
    Route::resource('/cooperative', CooperativeController::class);
    Route::resource('/group', GroupController::class);
    Route::resource('/member', MemberController::class);
    Route::get('/get-group-details/{group_id}', [MemberController::class, 'getGroupDetails']);
    Route::get('/get-groups-by-cooperative/{coop_id}', [MemberController::class, 'getGroupsByCooperative']);
    Route::resource('/saving_accounts', SavingAccountController::class);
    Route::get('/get-member-details/{memberId}', [SavingAccountController::class, 'getMemberDetails']);

});
