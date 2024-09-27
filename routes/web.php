<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function(){
    if ( Auth::user()->isAdmin() ) {
        return redirect(route('dashboard'));
    }
    if ( Auth::user()->isExpenseManager() ) {
        return redirect(route('dashboard'));
    }
    if ( Auth::user()->isvendor() ) {
        return redirect(route('dashboard'));
    }
})->name('dashboard');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::resource('user',\App\Http\Controllers\resource\user::class);
Route::post('/user/deleteUser', [\App\Http\Controllers\resource\user::class, 'deleteUser'])->name('user.deleteUser');
Route::resource('stream',\App\Http\Controllers\resource\stream::class);
Route::resource('company',\App\Http\Controllers\resource\company::class);
Route::resource('vendor',\App\Http\Controllers\resource\vendor::class);
Route::post('/vendor/approve', [\App\Http\Controllers\resource\vendor::class, 'approve'])->name('vendor.approve');
Route::resource('category',\App\Http\Controllers\resource\category::class);
Route::post('/category/deletecat', [\App\Http\Controllers\resource\category::class, 'deletecat'])->name('category.deletecat');
Route::resource('budget',\App\Http\Controllers\resource\budget::class);
Route::post('/budget/deletebudget', [\App\Http\Controllers\resource\budget::class, 'deletebudget'])->name('budget.deletebudget');
Route::resource('payment',\App\Http\Controllers\resource\payment::class);
Route::get('/payment/{id}/updatepayment', [\App\Http\Controllers\resource\payment::class, 'updatepayment'])->name('payment.updatepayment');
Route::resource('department',\App\Http\Controllers\resource\department::class);
Route::resource('campus',\App\Http\Controllers\resource\campus::class);
Route::get('campus/getdepartments/{campusId}', [\App\Http\Controllers\resource\campus::class, 'getdepartments'])->name('campus.getdepartments');
Route::resource('lead',\App\Http\Controllers\resource\lead::class);
Route::post('/lead/approve', [\App\Http\Controllers\resource\lead::class, 'approve'])->name('lead.approve');
Route::resource('invoice',\App\Http\Controllers\resource\invoice::class);
Route::get('lead/get-milestones/{proposal_id}', [\App\Http\Controllers\resource\lead::class, 'getMilestones']);
Route::get('lead/milestone-details/{milestone_id}', [\App\Http\Controllers\resource\lead::class, 'getMilestonesdetails']);
Route::get('lead/ro/{id}', [\App\Http\Controllers\resource\lead::class, 'ro'])->name('lead.ro');

Route::get('/registration', [App\Http\Controllers\HomeController::class, 'registration'])->name('registration');
Route::put('/registrationprocess', [App\Http\Controllers\HomeController::class, 'registrationprocess'])->name('registrationprocess');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::put('/profileupdate', [App\Http\Controllers\HomeController::class, 'profileupdate'])->name('profileupdate');

Route::get('/payment/create/{id?}', [\App\Http\Controllers\resource\payment::class, 'create'])->name('payment.create');

Route::get('/email', [App\Http\Controllers\HomeController::class, 'email'])->name('email');

use App\Http\Controllers\ProposalController;

Route::get('/lead/{id}/save-pdf', [\App\Http\Controllers\resource\lead::class, 'saveReleaseOrderAsPdf'])->name('lead.save-pdf');

Route::get('/get-budget-details', [\App\Http\Controllers\resource\payment::class, 'getBudgetDetails']);

