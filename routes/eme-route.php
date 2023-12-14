<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Boq\Departments\Civil\BoqCivilJsonController;

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
    // electrical routes
    Route::prefix('eme')->as('eme.')->group(function () {
        Route::resource('utility_bill', \Boq\Departments\Electrical\UtilityBillController::class);
        Route::prefix('utility_bill')->as('utility_bill.')->group(function () {
            Route::post('clientAutoSuggest', [BoqCivilJsonController::class, 'clientAutoSuggest'])->name('clientAutoSuggest');
            Route::post('getApartmentName', [BoqCivilJsonController::class, 'getApartmentName'])->name('getApartmentName');
            Route::post('previousBillPeriod', [BoqCivilJsonController::class, 'previousBillPeriod'])->name('previousBillPeriod');
            Route::get('pdf/{utility_bill}', 'Boq\Departments\Electrical\UtilityBillController@pdf')->name('pdf');
        });

        /********************* work-cs ********************/
        Route::resource('work_cs', \Boq\Departments\Electrical\BoqEmeWorkCsController::class);
        Route::prefix('work_cs')->as('work_cs.')->group(function () {
            Route::get('approved/{work_cs}/{status}', 'Boq\Departments\Electrical\BoqEmeWorkCsController@Approve')->name('Approved');
            Route::get('pdf/{work_c}', 'Boq\Departments\Electrical\BoqEmeWorkCsController@pdf')->name('pdf');
        });
        /********************* work-order ********************/
        Route::resource('work_order', \Boq\Departments\Electrical\BoqEmeWorkOrderController::class);
        Route::prefix('workorder')->as('workorder.')->group(function () {
            Route::post('workCSRefAutoSuggest', [BoqCivilJsonController::class, 'workCSRefAutoSuggest'])->name('workCSRefAutoSuggest');
            Route::get('loadWorkCsSupplier/{work_cs_id}', [BoqCivilJsonController::class, 'loadWorkCsSupplier'])->name('loadWorkCsSupplier');

            Route::get('terms/{workorder}', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@terms')->name('terms');
            Route::post('terms/{workorder}/store', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@storeTerms')->name('terms.store');

            Route::get('technical_specification/{workorder}', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@technical_specification')->name('technical_specification');
            Route::post('technical_specification/{workorder}/store', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@storeTechnical_specification')->name('technical_specification.store');

            Route::get('other_feature/{workorder}', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@other_feature')->name('other_feature');
            Route::post('other_feature/{workorder}/store', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@storeOther_feature')->name('other_feature.store');
            Route::get('approved/{workorder}/{status}', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@Approve')->name('Approved');
            Route::get('pdf/{work_order}', 'Boq\Departments\Electrical\BoqEmeWorkOrderController@pdf')->name('pdf');
        });
        Route::get('eme-bill-approval/{emeBill}/{status}', 'Boq\Departments\Electrical\BoqEmeConstructionBillController@emeBillapproval')->name('eme-bill-approval');
        Route::post('eme-bill-approval-store', 'Boq\Departments\Electrical\BoqEmeConstructionBillController@emeBillapprovalStore')->name('eme-bill-approval-store');
        Route::resources([
            'bills' => 'Boq\Departments\Electrical\BoqEmeConstructionBillController',
            'labor_rate' => 'Boq\Departments\Electrical\BoqElectricalLaborRateController',
        ]);
        Route::prefix('bills')->as('bills.')->group(function () {
             Route::get('pdf/{bills}', 'Boq\Departments\Electrical\BoqEmeConstructionBillController@pdf')->name('pdf');
        });
        // API Route
        Route::prefix('labor_rate')->as('labor_rate.')->group(function () {
            Route::get('approved/{labor_rate}/{status}', 'Boq\Departments\Electrical\BoqElectricalLaborRateController@Approve')->name('Approved');
            Route::get('pdf/{labor_rate}', 'Boq\Departments\Electrical\BoqElectricalLaborRateController@pdf')->name('pdf');
        });

        Route::resource('/load_calculations', \Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController::class);
        Route::get('/show_load_cal/{project}', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@LoadCalculation')
            ->name('show_load_cal');
        Route::get('eme_projects', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@eme_projects')->name('eme_projects');

        Route::prefix('load_calculations')->as('load_calculations.')->group(function () {
            Route::get('total_view/{project}', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@index')->name('total_view');
            Route::get('pdf/{project}', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@pdf')->name('pdf');
            Route::post('materialAutoSuggestWhereDepthMorethanThree', [BoqCivilJsonController::class, 'materialAutoSuggestWhereDepthMorethanThree'])->name('materialAutoSuggestWhereDepthMorethanThree');
            Route::post('floorAutoSuggest', [BoqCivilJsonController::class, 'floorAutoSuggest'])->name('floorAutoSuggest');
            Route::get('approved/{load_calculations}/{status}', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@Approve')->name('Approved');
        });
    });
});
