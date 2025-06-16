<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Staff\Controllers\Auth\StaffLoginController;
use App\Modules\Staff\Controllers\StaffController;
use App\Modules\Staff\Controllers\TravelExpenseController;

Route::prefix('staff')->group(function () {
    Route::get('login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
    Route::post('login', [StaffLoginController::class, 'login']);
    Route::post('logout', [StaffLoginController::class, 'logout'])->name('staff.logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        Route::get('travel-expense/create', [TravelExpenseController::class, 'create'])->name('travel.create');
        Route::post('travel-expense/store', [TravelExpenseController::class, 'store'])->name('travel.store');
    });

   
});

