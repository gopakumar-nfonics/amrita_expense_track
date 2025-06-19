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

Route::middleware(['auth'])->group(function () {

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
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('user',\App\Http\Controllers\resource\user::class);
});
Route::post('/user/deleteUser', [\App\Http\Controllers\resource\user::class, 'deleteUser'])->name('user.deleteUser');
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('stream',\App\Http\Controllers\resource\stream::class);
Route::resource('company',\App\Http\Controllers\resource\company::class);
Route::resource('vendor',\App\Http\Controllers\resource\vendor::class);
});
Route::post('/vendor/approve', [\App\Http\Controllers\resource\vendor::class, 'approve'])->name('vendor.approve');
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('category',\App\Http\Controllers\resource\category::class);
});
Route::post('/category/deletecat', [\App\Http\Controllers\resource\category::class, 'deletecat'])->name('category.deletecat');
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('budget',\App\Http\Controllers\resource\budget::class);
});
Route::post('/budget/deletebudget', [\App\Http\Controllers\resource\budget::class, 'deletebudget'])->name('budget.deletebudget');
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('payment',\App\Http\Controllers\resource\payment::class);
});
Route::get('/payment/{id}/updatepayment', [\App\Http\Controllers\resource\payment::class, 'updatepayment'])->name('payment.updatepayment');
Route::group(['middleware' => 'checkRole'], function () {
Route::resource('department',\App\Http\Controllers\resource\department::class);
Route::resource('campus',\App\Http\Controllers\resource\campus::class);
});
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

Route::get('/lead/{id}/save-pdf', [\App\Http\Controllers\resource\lead::class, 'saveReleaseOrderAsPdf'])->name('lead.save-pdf');

Route::get('/get-budget-details', [\App\Http\Controllers\resource\payment::class, 'getBudgetDetails']);

Route::get('/payment/{id}/save-pdf', [\App\Http\Controllers\resource\payment::class, 'savepaymentrequestPdf'])->name('payment.save-pdf');

Route::post('/update-payment-status', [\App\Http\Controllers\resource\payment::class, 'updatePaymentStatus'])->name('update.payment.status');

Route::post('/lead/reject', [\App\Http\Controllers\resource\lead::class, 'reject'])->name('lead.reject');

Route::group(['middleware' => 'checkRole'], function () {
Route::get('/catreport', [App\Http\Controllers\ReportsController::class, 'index'])->name('catreport');
Route::post('/reportdata', [App\Http\Controllers\ReportsController::class, 'reportdata'])->name('reports.reportdata');
Route::get('/vendorreport', [App\Http\Controllers\ReportsController::class, 'vendorreport'])->name('vendorreport');
Route::post('/vendordata', [App\Http\Controllers\ReportsController::class, 'vendordata'])->name('reports.vendordata');

Route::get('/programmereport', [App\Http\Controllers\ReportsController::class, 'programmereport'])->name('programmereport');
Route::post('/programmedata', [App\Http\Controllers\ReportsController::class, 'programmedata'])->name('reports.programmedata');
});
Route::get('lead/rejectionreason/{proposal_id}', [\App\Http\Controllers\resource\lead::class, 'rejectionReason']);
Route::group(['middleware' => 'checkRole'], function () {
Route::get('/export-budget-report', [App\Http\Controllers\ReportsController::class, 'exportBudgetReport'])->name('reports.exportcatreport');
Route::get('/export-vendor-report', [App\Http\Controllers\ReportsController::class, 'vendordataexport'])->name('reports.vendordataexport');
Route::get('/exportprogrammedata', [App\Http\Controllers\ReportsController::class, 'exportprogrammedata'])->name('reports.programmedataexport');
});
Route::get('/lead/{id}/resubmit', [\App\Http\Controllers\resource\lead::class, 'edit'])->name('lead.resubmit');

Route::get('getPrograms', [\App\Http\Controllers\resource\lead::class, 'getPrograms'])->name('getPrograms');
Route::post('/campus/deleteCampus', [\App\Http\Controllers\resource\campus::class, 'deleteCampus'])->name('campus.deleteCampus');
Route::post('/department/deleteDepartment', [\App\Http\Controllers\resource\department::class, 'deleteDepartment'])->name('department.deleteDepartment');
Route::post('/stream/deleteProgramme', [\App\Http\Controllers\resource\stream::class, 'deleteProgramme'])->name('stream.deleteProgramme');
Route::post('/vendor/deleteVendor', [\App\Http\Controllers\resource\vendor::class, 'deleteVendor'])->name('vendor.deleteVendor');
Route::get('/userprofile', [App\Http\Controllers\HomeController::class, 'userprofile'])->name('userprofile');
Route::put('/userupdate', [App\Http\Controllers\HomeController::class, 'userupdate'])->name('userupdate');

Route::get('/support-center', function () {
    return view('support');
})->name('support.center');

Route::get('/getCategories/{financialYearId}', [\App\Http\Controllers\resource\budget::class, 'getCategories'])->name('getCategories');

Route::get('getNextRoNumber', [\App\Http\Controllers\resource\lead::class, 'getNextRoNumber'])->name('getNextRoNumber');

Route::get('/get-payment-details', [\App\Http\Controllers\resource\payment::class, 'getPaymentDetails'])->name('getPaymentDetails');

});

Route::resource('noninvoicepayment',\App\Http\Controllers\resource\noninvoicepayment::class);
Route::resource('designation',\App\Http\Controllers\resource\designation::class);

Route::get('/staffs/importstaff', [\App\Http\Controllers\resource\staffs::class, 'importstaff'])->name('staffs.import');
Route::post('/staffs/import', [App\Http\Controllers\resource\staffs::class, 'import'])->name('staffs.importproceed');
Route::resource('staffs',\App\Http\Controllers\resource\staffs::class);

Route::resource('travelmode',\App\Http\Controllers\resource\travelmode::class);
