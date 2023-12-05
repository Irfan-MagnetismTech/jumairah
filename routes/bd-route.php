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


Route::group(['middleware' => 'auth'], function () {

    Route::get('followup/{id}', 'BD\BdLeadGenerationController@followup')->name('followup');
    Route::post('followupStore/{id}', 'BD\BdLeadGenerationController@followupStore')->name('followupStore');
    Route::get('bd-budget-list/{year}', 'BD\BdBudgetController@BdBudgetList')->name('bd-budget-list');
    Route::get('bd-budget-pdf/{id}', 'BD\BdBudgetController@pdf')->name('bd-budget-pdf');

    Route::get('bd-priority-land-list/{year}', 'BD\PriorityLandController@BdPriorityLandList')->name('bd-priority-land-list');
    Route::get('bd-priority-land-pdf/{id}', 'BD\PriorityLandController@pdf')->name('bd-priority-land-pdf');

    Route::get('bd-inventory-details/{year}', 'BD\BdInventoryController@BdInventoryList')->name('bd-inventory-details');
    Route::get('bd-inventory-pdf/{id}', 'BD\BdInventoryController@pdf')->name('bd-inventory-pdf');

    Route::get('bd-yearly-budget-pdf/{id}', 'BD\BdYearlyBudgetController@pdf')->name('bd-yearly-budget-pdf');

    Route::get('project-layout-create/{bd_lead_location}', 'BD\ProjectLayoutController@create')->name('project-layout-create');
    Route::post('/project-layout-store/{bd_lead_location}', 'BD\ProjectLayoutController@store')->name('project-layout-store');

    Route::post('permissionHeadAutoSuggest', 'Procurement\SupplyChainJsonController@permissionHeadAutoSuggest')->name('permissionHeadAutoSuggest');
    Route::post('permissionHeadAutoSuggestwithType', 'Procurement\SupplyChainJsonController@permissionHeadAutoSuggestwithType')->name('permissionHeadAutoSuggestwithType');
    Route::post('referenceHeadAutoSuggest', 'Procurement\SupplyChainJsonController@referenceHeadAutoSuggest')->name('referenceHeadAutoSuggest');
    Route::post('generatorHeadAutoSuggest', 'Procurement\SupplyChainJsonController@generatorHeadAutoSuggest')->name('generatorHeadAutoSuggest');

    Route::get('scrapCs-pdf/{scrapCs}/{selectedSupplierId}', 'BD\ScrapCsController@pdf')->name('scrapCs-pdf');
    Route::get('bd_lead/ShowFile/{bd_lead}', 'BD\BdLeadGenerationController@ShowFile')->name('bd_lead.ShowFile');
    Route::get('bd_lead/attachment/ShowFile/{bd_lead}', 'BD\BdLeadGenerationController@attachmentShowFile')->name('bd_lead.attachment.ShowFile');
    Route::post('bd/sourceAutoSuggest', 'Procurement\SupplyChainJsonController@bd_sourceAutoSuggest')->name('bd.sourceAutoSuggest');
    Route::get('bd_lead_index', 'BD\ProjectLayoutController@bd_lead_index')->name('bd_lead_index');
    Route::post('projectAutoSuggestForScrap', 'Procurement\SupplyChainJsonController@projectAutoSuggestForScrap')->name('projectAutoSuggestForScrap');
    Route::post('materialAutoSuggestForScrap', 'Procurement\SupplyChainJsonController@materialAutoSuggestForScrap')->name('materialAutoSuggestForScrap');
    Route::post('supplierAutoSuggestForScrap', 'Procurement\SupplyChainJsonController@supplierAutoSuggestForScrap')->name('supplierAutoSuggestForScrap');
    Route::get('scrapCsAutoSuggest', 'Procurement\SupplyChainJsonController@scrapCsAutoSuggest')->name('scrapCsAutoSuggest');
    Route::get('percentForYearAndLocation', 'Procurement\SupplyChainJsonController@percentForYearAndLocation')->name('percentForYearAndLocation');

    Route::get('paymentSchedule', 'BD\BdFeasiFinanceController@paymentSchedule')->name('paymentSchedule');


    Route::get('scrapForm/approved/{scrapForm}/{status}', 'BD\scrapFormController@Approved')->name('scrapForm.Approved');
    Route::get('scrapSale/approved/{scrapSale}/{status}', 'BD\ScrapSaleController@Approved')->name('scrapSale.Approved');
    Route::get('scrapCs/approved/{scrapSale}/{status}', 'BD\ScrapCsController@Approved')->name('scrapCs.Approved');
    Route::get('finance/approved/{finance}/{status}', 'BD\BdFeasiFinanceController@Approved')->name('finance.Approved');
    Route::get('boq_fees_cost', 'BD\BdFeasiFessAndCostController@BoqFeesCostCreate')->name('boq_fees_cost.create');
    Route::get('ref_fees_and_other_cost', 'BD\BdFeasiFessAndCostController@RefFeesCreate')->name('boq_ref_fees_cost.create');
    Route::post('boq_fees_cost', 'BD\BdFeasiFessAndCostController@BoqFeesCostStore')->name('boq_fees_cost.create');


    Route::get('feasibility-entry-locations', 'BD\BdFeasibilityEntryController@locations')->name('feasibility-entry.locations');
    Route::get('feasibility-copy', 'BD\BdFeasibilityEntryController@feasibilityCopy')->name('feasibility-copy');
    Route::post('feasibility-copy', 'BD\BdFeasibilityEntryController@feasibilityCopyStore');
    Route::get('feasibility-entry', 'BD\BdFeasibilityEntryController@index')->name('feasibility-entry.index');
    Route::get('feasibility-entry/create/{location_id}', 'BD\BdFeasibilityEntryController@create')->name('feasibility-entry.create');
    Route::get('calculateFinance', 'BD\BdFeasibilityEntryController@calculateFinance')->name('calculateFinance');
    Route::post('feasibility-entry', 'BD\BdFeasibilityEntryController@store')->name('feasibility-entry.store');
    Route::post('getAutoFinaceData', 'BD\BdFeasibilityEntryController@getAutoFinaceData')->name('getAutoFinaceData');
    Route::post('bdFesibilityUpdateData', 'BD\BdFeasibilityEntryController@bdFesibilityUpdateData')->name('bdFesibilityUpdateData');

    Route::resources([
        'source'                   => 'BD\SourceController',
        'bd_lead'                  => 'BD\BdLeadGenerationController',
        'project-layout'           => 'BD\ProjectLayoutController',
        'bd_budget'                => 'BD\BdBudgetController',
        'priority_land'            => 'BD\PriorityLandController',
        'bd_inventory'             => 'BD\BdInventoryController',
        'bd_yearly_budget'         => 'BD\BdYearlyBudgetController',
        'feasibility_locations'    => 'BD\BdFeasibilityLocationController',
        'memo'                     => 'BD\memoController',
        'scrapForm'                => 'BD\scrapFormController',
        'scrapCs'                  => 'BD\ScrapCsController',
        'scrapSale'                => 'BD\ScrapSaleController',

        'feasi_perticular'         => 'BD\BdFeasi_perticularController',
        'fees_cost'                => 'BD\BdFeasiFessAndCostController',
        'reference_fees'           => 'BD\BdFesiReferenceFessController',
        'ctc'                      => 'BD\BdFeasibilityCtcController',
        'revenue'                  => 'BD\BdFeasiRevenueController',
        'utility'                  => 'BD\BdFesiUtilityController',
        'finance'                  => 'BD\BdFeasiFinanceController',
        'rnc_percent'              => 'BD\BdFeasRncPercentController',
        'rnc_calculation'          => 'BD\BdFeasRncCalculationController',

    ]);
});
