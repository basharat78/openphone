<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Qc\CallController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        
        if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard.index');
        }
        
        if ($user->user_type === 'qc') {
            return redirect()->route('qc.dashboard');
        }
    }
    
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// QC Routes
Route::middleware(['auth', 'user.type:qc'])->prefix('qc')->name('qc.')->group(function () {
    Route::get('/dashboard', [CallController::class, 'dashboard'])->name('dashboard');
    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::post('/calls/sync', [CallController::class, 'sync'])->name('calls.sync');
    Route::get('/calls/{call}', [CallController::class, 'show'])->name('calls.show');
    Route::post('/calls/{call}/score', [CallController::class, 'storeScore'])->name('calls.store_score');
});

require __DIR__.'/auth.php';