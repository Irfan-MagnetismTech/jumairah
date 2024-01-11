<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth', 'prefix' => 'construction', 'as' => 'construction.'], function ()
{
    Route::post('LoadboqWorkHead', 'Procurement\ProcurementAutoSuggestController@LoadboqWorkHead')->name('LoadboqWorkHead');
    Route::post('LoadmaterialName', 'Procurement\ProcurementAutoSuggestController@LoadmaterialName')->name('LoadmaterialName');

    Route::get('yearList/{project}', 'Construction\WorkPlanController@yearList')->name('yearList');
    Route::get('monthList/{year}', 'Construction\WorkPlanController@monthList')->name('monthList');
    Route::get('planDetails/{year}/{month}', 'Construction\WorkPlanController@planDetails')->name('planDetails');
    Route::get('work-plan-show/{year}/{month}/{id}', 'Construction\WorkPlanController@showByProjectEng')->name('work-plan-show');
    Route::get('pdf/{year}/{month}', 'Construction\WorkPlanController@pdf')->name('pdf');
    Route::post('workPlan/DraftSave', 'Construction\WorkPlanController@DraftSave')->name('workPlan.DraftSave');
    Route::get('work_plan/approved/{work_plan}/{status}/{year}/{month}','Construction\WorkPlanController@Approve')->name('workPlan.Approved');

    Route::get('material-plan-year-List}', 'Construction\MaterialPlanController@yearList')->name('material-plan-year-List');
    Route::get('material-plan-month-List/{year}', 'Construction\MaterialPlanController@monthList')->name('material-plan-month-List');
    Route::get('material-budget-project-list/{year}/{month}', 'Construction\MaterialPlanController@projectList')->name('material-budget-project-list');
    Route::get('material-budget-details/{year}/{month}/{id}', 'Construction\MaterialPlanController@budgetDetails')->name('material-budget-details');
    Route::get('material-budget-show/{year}/{month}/{id}', 'Construction\MaterialPlanController@showByProjectEng')->name('material-budget-show');
    Route::post('gm-construction-pending/{year}/{month}/{id}', 'Construction\MaterialPlanController@pending')->name('gm-construction-pending');
    Route::get('material-budget-pdf/{year}/{month}/{id}', 'Construction\MaterialPlanController@pdf')->name('material-budget-pdf');
    Route::post('materialPlan/DraftSave', 'Construction\MaterialPlanController@DraftSave')->name('materialPlan.DraftSave');
    Route::get('material-plan/approved/{material_plan}/{status}','Construction\MaterialPlanController@MaterialPlanApproved')->name('materialPlan.Approved');

    Route::get('labour-budget-year-List}', 'Construction\LaborBudgetController@yearList')->name('labour-budget-year-List');
    Route::get('labour-budget-month-List/{year}', 'Construction\LaborBudgetController@monthList')->name('labour-budget-month-List');
    Route::get('budget-details/{year}/{month}', 'Construction\LaborBudgetController@budgetDetails')->name('budget-details');
    Route::get('labor-budget-pdf/{year}/{month}', 'Construction\LaborBudgetController@pdf')->name('labor-budget-pdf');

    Route::get('tentative-budget-year-List', 'Construction\TentativeBudgetController@yearList')->name('tentative-budget-list');
    Route::get('tentative-budget-details/{year}', 'Construction\TentativeBudgetController@budgetDetails')->name('tentative-budget-details');
    Route::get('tentative-budget-edit/{year}/{cost_center_id}', 'Construction\TentativeBudgetController@TentativeBudgetEdit')->name('tentative-budget-edit');
    Route::post('tentative_budget_update', 'Construction\TentativeBudgetController@TentativeBudgetUpdate')->name('tentative-budget-update');
    Route::get('tentative_budget_pdf/{id}', 'Construction\TentativeBudgetController@TentativeBudgetPdf');

    Route::get('project-progress-report-year-list', 'Construction\ProjectProgressReportController@year')->name('project-progress-report-year-list');
    Route::get('project-progress-report-month-list/{year}', 'Construction\ProjectProgressReportController@month')->name('project-progress-report-month-list');
    Route::get('project-progress-report-list/{year}/{month}', 'Construction\ProjectProgressReportController@progressReport')->name('project-progress-report-list');
    Route::get('cost-incurred-year-list', 'Construction\CostIncurredReport@CostIncurredYearList')->name('cost-incurred-year-list');
    Route::get('cost-incurred-report/{year}', 'Construction\CostIncurredReport@CostIncurredReport')->name('cost-incurred-report');


        Route::resources([
        'work_plan'                  => 'Construction\WorkPlanController',
        'material_plan'              => 'Construction\MaterialPlanController',
        'labor_budget'               => 'Construction\LaborBudgetController',
        'tentative_budget'           => 'Construction\TentativeBudgetController',
        'monthly_progress_report'    => 'Construction\ProjectProgressReportController'
    ]);
});
