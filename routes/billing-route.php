<?php

use App\Http\Controllers\Billing\WorkCsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sells\LeadgenerationController;
use App\Http\Controllers\ProjectController;

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


Route::group(['middleware' => 'auth'], function () {
    // Route::post('projectAutoSuggest', 'JsonController@projectAutoSuggest')->name('projectAutoSuggest');
    Route::post('workOrderAutoSuggest', 'JsonController@workOrderAutoSuggest')->name('workOrderAutoSuggest');
    Route::post('workOrderAutoSuggestForSuppliers', 'JsonController@workOrderAutoSuggestForSuppliers')->name('workOrderAutoSuggestForSuppliers');
    Route::post('boqEmeWorkOrderAutoSuggestForSuppliers', 'JsonController@boqEmeWorkOrderAutoSuggestForSuppliers')->name('boqEmeWorkOrderAutoSuggestForSuppliers');
    Route::post('boqEmeWorkOrderAutoSuggest', 'JsonController@boqEmeWorkOrderAutoSuggest')->name('boqEmeWorkOrderAutoSuggest');
    Route::get('searchWorkType', 'JsonController@searchWorkType')->name('searchWorkType');

    Route::post('workCSRefAutoSuggest', 'Billing\AutoSuggestController@workCSRefAutoSuggest')->name('workCSRefAutoSuggest');
    Route::get('loadWorkCsSupplier/{work_cs_id}', 'Billing\AutoSuggestController@loadWorkCsSupplier')->name('loadWorkCsSupplier');
    Route::get('loadWorkCsRates/{cs_id}/{supplier_id}', 'Billing\AutoSuggestController@loadWorkCsRates')->name('loadWorkCsRates');

    Route::get('workcspdf/{workCs}', 'Billing\WorkCsController@pdf')->name('workcspdf');
    Route::post('WorkCs/DraftSave', 'Billing\WorkCsController@DraftSave')->name('WorkCs.DraftSave');
    Route::get('work_cs/approved/{work_cs}/{status}', 'Billing\WorkCsController@Approve')->name('work-cs.Approved');
    Route::get('work_cs/copy/{work_cs}', 'Billing\WorkCsController@Copy')->name('work-cs.copy');
    Route::get('workorder/approved/{workorder}/{status}', 'Billing\WorkorderController@Approve')->name('workorder.Approved');
    Route::get('workorderpdf/{workorder}', 'Billing\WorkorderController@pdf')->name('workorderpdf');
    Route::get('workorder-payments/{workorder}', 'Billing\WorkorderController@pdf')->name('workorderpdf');

    Route::get('workorder-terms/{workorder}', 'Billing\WorkorderController@terms')->name('workorder-terms');
    Route::post('workorder-terms/{workorder}/store', 'Billing\WorkorderController@storeTerms')->name('workorder-terms.store');

    Route::get('workorder-payments/{workorder}', 'Billing\WorkorderController@payment')->name('workorder-payments');
    Route::post('workorder-payments/{workorder}/store', 'Billing\WorkorderController@storePayment')->name('workorder-payments.store');

    Route::get('constructionbillpdf/{constructionBill}', 'Billing\ConstructionBillController@pdf')->name('constructionbillpdf');
    Route::get('construction-bill-approval/{constructionBill}/{status}', 'Billing\ConstructionBillController@constructionBillapproval')->name('construction-bill-approval');
    Route::post('construction-bill-approval-store', 'Billing\ConstructionBillController@constructionBillapprovalStore')->name('construction-bill-approval-store');
    Route::post('construction-bill/DraftSave', 'Billing\ConstructionBillController@DraftSave')->name('construction-bill.DraftSave');

    Route::resources([
        'work-cs' => 'Billing\WorkCsController',
        'workorders' => 'Billing\WorkorderController',
        'construction-bills' => 'Billing\ConstructionBillController',
        'bill-title' => 'Billing\BillingTitleController'
    ]);
});
