<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', static function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', static function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/settings/update', static function () {
        return Inertia::render('UpdateSetting');
    });
    Route::get('/user/settings/verify-code', static function () {
        return Inertia::render('VerifyCode');
    });

    Route::post('/user/settings/update', [UserSettingController::class, 'updateSetting'])->name('user.settings.update');
    Route::post('/user/settings/verify-code', [UserSettingController::class, 'verifyCode'])->name('user.settings.verify');
});



require __DIR__.'/auth.php';
