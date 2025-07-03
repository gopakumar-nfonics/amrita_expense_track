<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Staff\Controllers\Auth\StaffLoginController;
use App\Modules\Staff\Controllers\StaffController;
use App\Modules\Staff\Controllers\TravelExpenseController;

Route::middleware(['web'])->prefix('staff')->group(function () {
    Route::get('login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
    Route::post('login', [StaffLoginController::class, 'login']);
    Route::post('logout', [StaffLoginController::class, 'logout'])->name('staff.logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        Route::get('travel-expense/create', [TravelExpenseController::class, 'create'])->name('travel.create');
        Route::get('travel-expense/index', [TravelExpenseController::class, 'index'])->name('travel.index');
        Route::post('travel-expense/store', [TravelExpenseController::class, 'store'])->name('travel.store');
        Route::get('travel-expense/submit/{id}', [TravelExpenseController::class, 'submit_expense'])->name('travel.submit');
        Route::post('submit-expense/{id}', [TravelExpenseController::class, 'expense_store'])->name('travel.expense.store');
        Route::get('/get-allowance', [TravelExpenseController::class, 'getAllowance'])->name('travel.getAllowance');
        
    });

   
});

