<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;
Route::group([
  'middleware' => ['auth', 'user.type:admin'], //auth means login,user.type:admin, means user type
  'prefix' => 'admin', // this means all the roues will start with admin
  'as' => 'admin.' // this means all the routes will start with admin. name('admin.dashboard.index');
], function () {
  // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index'); //admin.dashboard.index
   Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard.index');
  /** Profile Routes */
  Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
  Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('/profile-password', [ProfileController::class, 'passwordUpdate'])->name('profile-password.update');
});

