<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// QC Routes
Route::middleware(['auth', 'user.type:qc'])->prefix('qc')->name('qc.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Qc\CallController::class, 'dashboard'])->name('dashboard');
    Route::get('/calls', [App\Http\Controllers\Qc\CallController::class, 'index'])->name('calls.index');
    Route::post('/calls/sync', [App\Http\Controllers\Qc\CallController::class, 'sync'])->name('calls.sync');
    Route::get('/calls/{call}', [App\Http\Controllers\Qc\CallController::class, 'show'])->name('calls.show');
    Route::post('/calls/{call}/score', [App\Http\Controllers\Qc\CallController::class, 'storeScore'])->name('calls.store_score');
});

