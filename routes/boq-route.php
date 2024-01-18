<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Procurement\BoqSupremeBudgetController;
use Boq\Departments\Civil\BoqCivilMaterialSpecificationController;
use Boq\Configurations\BoqSanitaryProjectWiseMaterialPriceController;
use Boq\Departments\Electrical\Configurations\EMELaborHeadController;
use App\Http\Controllers\Boq\Departments\Civil\BoqCivilJsonController;
use Boq\Configurations\BoqElectricalProjectWiseMaterialPriceController;
use Boq\Departments\Civil\BoqCivilGlobalMaterialSpecificationController;
use App\Http\Controllers\Boq\Departments\Sanitary\SanitaryAllocationController;
use App\Http\Controllers\Boq\Departments\Sanitary\ProjectWiseMaterialController;

/*
|--------------------------------------------------------------------------
| BOQ Web Routes
|--------------------------------------------------------------------------
|
| All the BOQ related web routes are defined here.
|
 */



Route::middleware( 'auth' )->prefix( 'boq' )->as( 'boq.' )->group( function () {
	Route::get( 'conversion-sheets/materialunit', 'Boq\Departments\Civil\ConversionSheet\BoqCivilConversionSheetController@getUnit' )->name( 'materialunit' );

	// configurations routes
	Route::get('budget-list', [BoqSupremeBudgetController::class, 'budgetList'])->name('budget-list');

	Route::prefix( 'configurations' )->as( 'configurations.' )->group( function () {
		//crud for floor type
		Route::resource( '/floortype', Boq\Configurations\BoqFloorTypeController::class )
			->parameter( 'floortype', 'floorType' );

		//crud for floor configuration
		Route::resource( '/floors', Boq\Configurations\BoqFloorController::class )
			->parameter( 'floors', 'floor' );

		//crud for work floor type configuration
		Route::resource( '/floor-type-work', Boq\Configurations\BoqFloorTypeBoqWorkController::class )
			->parameter( 'floorTypeWork', 'floorTypeWork' );
	} );

	Route::get( 'select-project', [App\Http\Controllers\Boq\Projects\BoqSelectProjectController::class, 'index'] )
		->name( 'select_project' );

	// project routes
	Route::prefix( 'project/{project}' )->as( 'project.' )->group( function () {

		Route::get( '', [\App\Http\Controllers\Boq\BoqController::class, 'index'] )
			->name( 'index' );

		Route::get( 'construction-abstract-sheet', [\App\Http\Controllers\Boq\BoqController::class, 'abstractSheet'] )
			->name( 'construction-abstract-sheet' );

		Route::get( 'download-construction-abstract-sheet', [\App\Http\Controllers\Boq\BoqController::class, 'downloadAbstractSheet'] )
			->name( 'download-construction-abstract-sheet' );

		Route::get( 'civil/construction-cost-summary', [\App\Http\Controllers\Boq\BoqController::class, 'costSummarySheetCivil'] )
			->name( 'construction-cost-summary-civil' );
		Route::get( 'download/civil/construction-cost-summary', [\App\Http\Controllers\Boq\BoqController::class, 'downloadCostSummarySheetCivil'] )
			->name( 'download-construction-cost-summary-civil' );

		Route::resource( 'material-specifications', BoqCivilMaterialSpecificationController::class );

		Route::get( 'material-specifications/{materialSpecificationItemHead}/editItem', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilMaterialSpecificationController::class, 'editmatSpecItemHead'] )
			->name( 'editmatSpecItemHead' );

		Route::put( 'material-specifications/{materialSpecificationItemHead}/update', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilMaterialSpecificationController::class, 'updatematSpecItemHead'] )
			->name( 'updatematSpecItemHead' );

		Route::delete( 'material-specifications/{materialSpecificationItemHead}/delete', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilMaterialSpecificationController::class, 'deletematSpecItemHead'] )->name( 'deletematSpecItemHead' );
		Route::resource( 'global-material-specifications', BoqCivilGlobalMaterialSpecificationController::class );

		Route::get( 'global-material-specifications/{materialSpecificationItemHead}/editItem', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecificationController::class, 'editglobalmatSpecItemHead'] )
			->name( 'editglobalmatSpecItemHead' );

		Route::put( 'global-material-specifications/{materialSpecificationItemHead}/update', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecificationController::class, 'updateglobalmatSpecItemHead'] )
			->name( 'updateglobalmatSpecItemHead' );

		Route::delete( 'global-material-specifications/{materialSpecificationItemHead}/delete', [App\Http\Controllers\Boq\Departments\Civil\BoqCivilGlobalMaterialSpecificationController::class, 'deleteglobalmatSpecItemHead'] )->name( 'deleteglobalmatSpecItemHead' );

		// configurations routes
		Route::prefix( 'configurations' )->as( 'configurations.' )->group( function () {
			Route::resource( 'areas', \Boq\Projects\Configurations\BoqProjectAreaConfigController::class )
				->parameter( 'areas', 'area' );
		} );

		// departments routes
		Route::prefix( 'departments' )->as( 'departments.' )->group( function () {
			// civil routes
			Route::prefix( 'civil' )->as( 'civil.' )->group( function () {
				Route::get( '/', Boq\Departments\Civil\BoqCivilHomeController::class )
					->name( 'home' );

				Route::get( '/', Boq\Departments\Civil\BoqCivilHomeController::class )
					->name( 'home' );

				Route::get( '/previous/revised-sheet/{escalation_no}', [\App\Http\Controllers\Boq\Departments\Civil\BoqCivilHomeController::class, 'showRevisedSheet'] )
					->name( 'previous.revised-sheet' );

				Route::post( '/previous/calculation/list', [\App\Http\Controllers\Boq\Departments\Civil\BoqCivilCalcController::class, 'getPreviousCalculationList'] )
					->name( 'previous.calculation.list' );

				Route::post( '/remove/budget/from/supreme/revised', [\App\Http\Controllers\Boq\Departments\Civil\BoqCivilCalcController::class, 'removeBudgetFromSupremeRevised'] )
					->name( 'remove.budget.from.supreme.revised' );

				Route::post( '/previous/material/list', [\App\Http\Controllers\Boq\Departments\Civil\BoqCivilCalcController::class, 'getPreviousMaterialList'] )
					->name( 'previous.material.list' );

				// Configurations routes
				Route::prefix( 'configurations' )->as( 'configurations.' )->group( function () {
					//crud for boq work configuration
					Route::resource( '/works', Boq\Configurations\BoqWorkController::class )
						->parameter( 'works', 'work' );

					//crud for boq material formula
					Route::resource( '/material-formulas', Boq\Configurations\BoqMaterialFormulaController::class )
						->parameter( 'material-formulas', 'materialFormula' );

					//crud for boq material price and wastage
					Route::resource( '/material-price-wastage', Boq\Configurations\BoqMaterialPriceWastageController::class )
						->parameter( 'material-price-wastage', 'materialPriceWastage' );

					//crud for project wise boq material price
					Route::resource( '/projectwise-material-price', Boq\Configurations\BoqProjectWiseMaterialPriceController::class )
						->parameter( 'projectwise-material-price', 'projectWiseMaterialPrice' );

					//API Route
					Route::post( '/get-boq-work-by-work-id', [App\Http\Controllers\Boq\Configurations\BoqWorkController::class, 'getBoqWorksByWorkId'] )
						->name( 'get_boq_work_by_work_id' );

					Route::post( 'get-boq-sub-work-by-work-id', [App\Http\Controllers\Boq\Configurations\BoqWorkController::class, 'getBoqSubWorksByWorkId'] )
						->name( 'get_boq_sub_work_by_work_id' );

					//crud for boq reinforcement measurement crud
					Route::resource( '/reinforcement-measurement', \Boq\Configurations\BoqReinforcementMeasurementController::class )
						->parameter( 'reinforcement-measurement', 'reinforcementMeasurement' );
				} );

				Route::resource( '/{calculation_type}/calculations', Boq\Departments\Civil\BoqCivilCalcController::class )
					->where( ['calculation_type' => 'material|labour|material-labour'] );

				Route::resource( 'revised-sheets', Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheetController::class );
				Route::resource( 'conversion-sheets', Boq\Departments\Civil\ConversionSheet\BoqCivilConversionSheetController::class );

				// Cost routes
				Route::prefix( 'costs' )->as( 'costs.' )->group( function () {
					Route::resource( '/labours', \Boq\Departments\Civil\Cost\BoqCivilLabourBudgetController::class )
						->parameter( 'labours', 'labour' );

					Route::resource( '/consumables', \Boq\Departments\Civil\Cost\BoqCivilConsumableBudgetController::class )
						->parameter( 'consumables', 'consumable' );

					Route::get( '/edit/consumables/{head}', [\App\Http\Controllers\Boq\Departments\Civil\Cost\BoqCivilConsumableBudgetController::class, 'editConsumableBudgetWithHead'] )
						->name( 'related-material.edit' );
				} );

				// Cost analysis routes
				Route::prefix( 'cost-analysis' )->as( 'cost_analysis.' )->group( function () {
					Route::get( 'work-quantity', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilWorkQuantityController::class, 'index'] )
						->name( 'work.quantity' );

					Route::get( 'download-work-quantity-pdf', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilWorkQuantityController::class, 'workQuantityPdf'] )
						->name( 'download.work.quantity.pdf' );

					Route::get( 'reinforcement-sheet', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'reinforcementSheet'] )
						->name( 'reinforcement.sheet' );

					Route::get( 'download-ms-rod-pdf', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'msRodPdf'] )
						->name( 'download.ms.rod.pdf' );
					// floor wise routes
					Route::prefix( 'floor-wise' )->as( 'floor_wise.' )->group( function () {
						Route::get( '/material/statement', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'materialStatementFloorWise'] )
							->name( 'material.statement' );
						Route::get( '/workwise/material/statement', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'materialStatementWorkWise'] )
							->name( 'workwise.material.statement' );

						Route::get( '/material/summary', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'materialSummary'] )
							->name( 'material.summary' );
						Route::get( 'download/material/summary', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadMaterialSummary'] )
							->name( 'download.material.summary' );

						Route::get( '/material/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'materialCostFloorWise'] )
							->name( 'material.costs' );
						Route::get( 'download/material/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadMaterialCostFloorWise'] )
							->name( 'download.material.costs' );

						Route::get( '/labour/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'labourCostFloorWise'] )
							->name( 'labour.costs' );
						Route::get( 'download/labour/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadLabourCostFloorWise'] )
							->name( 'download.labour.costs' );

						Route::get( '/material-labour/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'materialLabourCostFloorWise'] )
							->name( 'material_labour.costs' );
						Route::get( 'download/material-labour/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadMaterialLabourCostFloorWise'] )
							->name( 'download.material-labour.costs' );

						Route::get( '/related-material/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'relatedMaterialCost'] )
							->name( 'related_material.costs' );
						Route::get( 'download/related-material/costs', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadRelatedMaterialCostFloorWise'] )
							->name( 'download.related-material.costs' );
					} );

					// percentage sheet routes
					Route::prefix( 'percentage-sheet' )->as( 'percentage_sheet.' )->group( function () {
						Route::get( '/workwise', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'percentageSheetWorkWise'] )
							->name( 'workwise' );
						Route::get( '/download-workwise-percentage-sheet', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadPercentageSheetWorkWise'] )
							->name( 'download.workwise' );

						Route::get( '/floorwise', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'percentageSheetFloorWise'] )
							->name( 'floorwise' );
						Route::get( '/download-floorwise-percentage-sheet', [\App\Http\Controllers\Boq\Departments\Civil\CostAnalysis\BoqCivilCostAnalysisController::class, 'downloadPercentageSheetFloorWise'] )
							->name( 'download.floorwise' );
					} );
				} );

				// Summary routes
				Route::prefix( 'summary' )->as( 'summary.' )->group( function () {
					//
				} );

				Route::post( 'get-floor-by-type', [BoqCivilJsonController::class, 'getFloorByType'] )
					->name( 'get_floor_by_type' );

				Route::post( 'get-floor-for-copy', [BoqCivilJsonController::class, 'getFloorForCopy'] )
					->name( 'get_floor_for_copy' );

				Route::post( 'get-work-by-location-type', [BoqCivilJsonController::class, 'getWorkByLocationType'] )
					->name( 'get_work_by_location_type' );

				Route::post( 'get_consumable_material_by_head', [BoqCivilJsonController::class, 'getConsumableMaterialByHead'] )
					->name( 'get-consumable-material-by-head' );

				Route::post( 'get_consumable_material_by_id', [BoqCivilJsonController::class, 'getConsumableMaterialById'] )
					->name( 'get-consumable-material-by-id' );

				Route::post( 'get_material_revised_budget_by_id', [BoqCivilJsonController::class, 'getMaterialRevisedBudgetById'] )
					->name( 'get-material-revised-budget-by-id' );
				Route::post( 'get_material_conversion_data_by_id', [BoqCivilJsonController::class, 'getMaterialConversionDataById'] )
					->name( 'get-material-conversion-data-by-id' );

				Route::post( 'get_material_left_balance_quantity_by_date', [BoqCivilJsonController::class, 'getMaterialLeftBalanceByDate'] )
					->name( 'get-material-left-balance-quantity-by-date' );

				Route::post( 'get_material_current_price', [BoqCivilJsonController::class, 'getMaterialCurrentPrice'] )
					->name( 'get-material-current-price' );

				Route::post( 'get-units', [BoqCivilJsonController::class, 'getUnits'] )->name( 'get_units' );
			} );

			//sanitary  routes
			Route::prefix( 'sanitary' )->as( 'sanitary.' )->group( function () {
				Route::prefix( 'configurations' )->as( 'configurations.' )->group( function () {
					Route::resource( '/projectwise-material-price', BoqSanitaryProjectWiseMaterialPriceController::class )
						->parameter( 'projectwise-material-price', 'ProjectWiseMaterialPrice' )->only( [
						'index', 'edit', 'update',
					] );
				} );
				Route::get( '/', \Boq\Departments\Sanitary\BoqSanitaryHomeController::class )->name( 'home' );
				Route::get( '/sanitary-allocations-edit/{type}', [SanitaryAllocationController::class, 'sanitaryAllocationEdit'] );
				Route::get( '/sanitary-allocations-view/{type}', [SanitaryAllocationController::class, 'show'] );
				//                Route::get('/sanitary-allocations-edit', [SanitaryAllocationController::class, 'sanitaryAllocationEdit']);
				Route::post( '/get-sanitary-material', [BoqCivilJsonController::class, 'getSanitaryMaterial'] );
				Route::post( '/get-project-wise-material-rate', [BoqCivilJsonController::class, 'getProjectWiseMaterialRate'] )
					->name( 'get-project-wise-material-rate' );
				Route::get( '/project-wise-materials-create/{parent_id}', [ProjectWiseMaterialController::class, 'projectWiseMaterialRateCreate'] )
					->name( 'project-wise-materials-create' );

				Route::get( '/sanitary-allocations-create/{type}', [SanitaryAllocationController::class, 'sanitaryAllocationCreate'] )
					->name( 'sanitary-allocations-create' );
				Route::get( '/sanitary-allocations-edit/{type}', [SanitaryAllocationController::class, 'sanitaryAllocationEdit'] )
					->name( 'sanitary-allocations-edit' );
				Route::resource( 'sanitary-budget-summaries', \Boq\Departments\Sanitary\SanitaryBudgetSummaryController::class );
				Route::resource( 'material-rates', \Boq\Departments\Sanitary\SanitaryMaterialRateController::class );
				Route::resource( 'project-wise-materials', \Boq\Departments\Sanitary\ProjectWiseMaterialController::class );
				Route::get( 'getProjectWiseMaterialDetailsInfo/{id}', 'Boq\Departments\Sanitary\ProjectWiseMaterialController@getProjectWiseMaterialDetailsInfo' )->name( 'getProjectWiseMaterialDetailsInfo' );
				Route::post( 'UpdateIndividualProjectWiseMaterialDetails', 'Boq\Departments\Sanitary\ProjectWiseMaterialController@UpdateIndividualProjectWiseMaterialDetails' )->name( 'UpdateIndividualProjectWiseMaterialDetails' );
				Route::delete( '/DeleteIndividualProjectWiseMaterialDetails/{id}', 'Boq\Departments\Sanitary\ProjectWiseMaterialController@DeleteIndividualProjectWiseMaterialDetails' )->name( 'DeleteIndividualProjectWiseMaterialDetails.destroy' );
				Route::resource( 'labor-cost', \Boq\Departments\Sanitary\SanitaryLaborCostController::class );
				Route::resource( 'project-wise-labor-cost', \Boq\Departments\Sanitary\ProjectWiseLaborCostController::class );
				Route::resource( 'sanitary-allocations', \Boq\Departments\Sanitary\SanitaryAllocationController::class );
				Route::resource( 'sanitary-formulas', \Boq\Departments\Sanitary\SanitaryFormulaController::class );
				Route::post( 'sanitary-allocations/update', [SanitaryAllocationController::class, 'update'] )->name( 'sanitary-allocations.update' );
				Route::get( 'getSanitaryFormulaDetailsInfo/{id}', 'Boq\Departments\Sanitary\SanitaryFormulaController@getSanitaryFormulaDetailsInfo' )->name( 'getSanitaryFormulaDetailsInfo' );
				Route::post( 'UpdateIndividualSanitaryFormulaDetails', 'Boq\Departments\Sanitary\SanitaryFormulaController@UpdateIndividualSanitaryFormulaDetails' )->name( 'UpdateIndividualSanitaryFormulaDetails' );
				Route::delete( '/DeleteIndividualSanitaryFormulaDetails/{id}', 'Boq\Departments\Sanitary\SanitaryFormulaController@DeleteIndividualSanitaryFormulaDetails' )->name( 'DeleteIndividualSanitaryFormulaDetails.destroy' );
				Route::get( '/cost-analysis/floor-wise/material/summary', [\App\Http\Controllers\Boq\Departments\Sanitary\CostAnalysis\BoqSanitaryCostAnalysisController::class, 'materialSummary'] )->name( 'cost_analysis.floor_wise.material.summary' );
				Route::get( '/cost-analysis/floor-wise/download/material/summary', [\App\Http\Controllers\Boq\Departments\Sanitary\CostAnalysis\BoqSanitaryCostAnalysisController::class, 'downloadMaterialSummary'] )
					->name( 'cost_analysis.floor_wise.download.material.summary' );
			} );

			// electrical routes
			Route::prefix( 'electrical' )->as( 'electrical.' )->group( function () {
				Route::get( '/', \Boq\Departments\Electrical\BoqElectricalHomeController::class )
					->name( 'home' );

				// Configurations routes
				Route::prefix( 'configurations' )->as( 'configurations.' )->group( function () {
					// Route::resource('/items', \Boq\Departments\Electrical\Configurations\BoqEmeItemController::class);

					Route::resource( '/projectwise-material-price', BoqElectricalProjectWiseMaterialPriceController::class )
						->parameter( 'projectwise-material-price', 'ProjectWiseMaterialPrice' )->only( [
						'index', 'edit', 'update',
					] );
					Route::resource( '/rates', \Boq\Departments\Electrical\Configurations\BoqElectricalRateController::class );

					Route::prefix( 'rates' )->as( 'rates.' )->group( function () {
						Route::post( 'boqWorkAutoSuggest', [BoqCivilJsonController::class, 'boqWorkAutoSuggest'] )->name( 'boqWorkAutoSuggest' );

						//API Route
						Route::post( '/get-boq-work-by-work-id', [BoqCivilJsonController::class, 'getBoqWorksByWorkId'] )
							->name( 'get_boq_work_by_work_id' );

						Route::post( 'get_boq_sub_work_by_work_id', [BoqCivilJsonController::class, 'getBoqSubWorksByWorkId'] )
							->name( 'get_boq_sub_work_by_work_id' );

						Route::post( 'getDecendentsBasedOnParent', [BoqCivilJsonController::class, 'getDecendentsBasedOnParent'] )->name( 'getDecendentsBasedOnParent' );
					} );
					Route::resource( '/eme-budget-head', \Boq\Departments\Electrical\Configurations\EmeBudgetHeadController::class );
					Route::resource( '/eme-labor-head',  \Boq\Departments\Electrical\Configurations\EmeLaborHeadController::class );

					/********************* cs supplier eval  ********************/
					Route::resource( '/cs_supplier_eval_option', \Boq\Departments\Electrical\Configurations\BoqEmeCsSupplierEvaluationFieldController::class );
				} );

				//electrical calculations
				Route::resource( '/calculations', \Boq\Departments\Electrical\Calculations\BoqElectricalCalculationController::class );
				Route::resource('/eme-labor-budgets', \Boq\Departments\Electrical\EmeLaborBudgetController::class);
				Route::get( '/calculation/pdf', 'Boq\Departments\Electrical\Calculations\BoqElectricalCalculationController@pdf' )->name( 'calculation.pdf' );
				Route::prefix( 'calculations' )->as( 'calculations.' )->group( function () {
					Route::get( 'approved/{calculations}/{status}', 'Boq\Departments\Electrical\Calculations\BoqElectricalCalculationController@Approve' )->name( 'Approved' );
				} );

				//EME budgets
				Route::resource( '/budgets', \Boq\Departments\Electrical\Budget\BoqEmeBudgetController::class );
				Route::get( '/budget/pdf', 'Boq\Departments\Electrical\Budget\BoqEmeBudgetController@pdf' )->name( 'budget.pdf' );
				Route::prefix( 'budgets' )->as( 'budgets.' )->group( function () {
					Route::get( 'approved/{budgets}/{status}', 'Boq\Departments\Electrical\Budget\BoqEmeBudgetController@Approve' )->name( 'Approved' );

				} );

				// load calculation
				Route::resource( '/load_calculations', \Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController::class );
				Route::get( '/show_load_cal', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@LoadCalculation' )
					->name( 'show_load_cal' );
				Route::prefix( 'load_calculations' )->as( 'load_calculations.' )->group( function () {
					Route::post( 'materialAutoSuggestWhereDepthMorethanThree', [BoqCivilJsonController::class, 'materialAutoSuggestWhereDepthMorethanThree'] )->name( 'materialAutoSuggestWhereDepthMorethanThree' );
					Route::post( 'floorAutoSuggest', [BoqCivilJsonController::class, 'floorAutoSuggest'] )->name( 'floorAutoSuggest' );
					Route::get( 'approved/{load_calculations}/{status}', 'Boq\Departments\Electrical\Loadcalculation\EmeLoadCalculationController@Approve' )->name( 'Approved' );
				} );
				/******* utility bill ******/

				/********************* labor_rate ********************/

				Route::resource( 'labor_rate', \Boq\Departments\Electrical\BoqElectricalLaborRateController::class );
				Route::prefix( 'labor_rate' )->as( 'labor_rate.' )->group( function () {
					Route::post( 'materialSuggestWithLaborRate', [BoqCivilJsonController::class, 'materialSuggestWithLaborRate'] )->name( 'materialSuggestWithLaborRate' );
					Route::post( 'workSuggestWithLaborRate', [BoqCivilJsonController::class, 'workSuggestWithLaborRate'] )->name( 'workSuggestWithLaborRate' );
					Route::get( 'approved/{labor_rate}/{status}', 'Boq\Departments\Electrical\BoqElectricalLaborRateController@Approve' )->name( 'Approved' );
				} );

				Route::get( '/cost-analysis/floor-wise/material/summary', [\App\Http\Controllers\Boq\Departments\Electrical\CostAnalysis\BoqElectricalCostAnalysisController::class, 'materialSummary'] )->name( 'cost_analysis.floor_wise.material.summary' );
				Route::get( '/cost-analysis/floor-wise/download/material/summary', [\App\Http\Controllers\Boq\Departments\Electrical\CostAnalysis\BoqElectricalCostAnalysisController::class, 'downloadMaterialSummary'] )
					->name( 'cost_analysis.floor_wise.download.material.summary' );

				/********************* construction bill ********************/
				Route::resource( 'construction_bill', \Boq\Departments\Electrical\BoqEmeConstructionBillController::class );
			} );
		} );
	} );

	Route::resources( [
		'MaterialServincing' => 'Boq\MaterialServicingController',
	] );

	Route::post( '/get_boq_material_unit_by_material_id', [App\Http\Controllers\Boq\Departments\Electrical\Calculations\BoqElectricalCalculationController::class, 'getMaterialUnitById'] )
		->name( 'get_boq_material_unit_by_material_id' );
} );
