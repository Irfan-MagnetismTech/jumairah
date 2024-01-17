<?php

use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth', 'prefix' => 'scj', 'as' => 'scj.'], function () {
    Route::post('projectAutoSuggest', 'Procurement\SupplyChainJsonController@projectAutoSuggest')->name('projectAutoSuggest');
    Route::post('costCenterAutoSuggest', 'Procurement\SupplyChainJsonController@costCenterAutoSuggest')->name('costCenterAutoSuggest');
    Route::get('projectAutoSuggestwithCostCenter', 'Procurement\SupplyChainJsonController@projectAutoSuggestwithCostCenter')->name('projectAutoSuggestwithCostCenter');
    Route::post('bdProgressBudgetProjectAutoSuggest', 'Procurement\SupplyChainJsonController@bdProgressBudgetProjectAutoSuggest')->name('bdProgressBudgetProjectAutoSuggest');
    Route::post('bdFutureBudgetProjectAutoSuggest', 'Procurement\SupplyChainJsonController@bdFutureBudgetProjectAutoSuggest')->name('bdFutureBudgetProjectAutoSuggest');
    Route::post('projectAutoSuggestWithoutBOQ', 'Procurement\SupplyChainJsonController@projectAutoSuggestWithoutBOQ')->name('projectAutoSuggestWithoutBOQ');
    Route::get('floorswiseBOQbudgetedMaterials', 'Procurement\SupplyChainJsonController@floorswiseBOQbudgetedMaterials')->name('floorswiseBOQbudgetedMaterials');
    Route::post('materialAutoSuggest', 'Procurement\SupplyChainJsonController@materialAutoSuggest')->name('materialAutoSuggest');
    Route::post('materialAutoSuggestWhereDepthThree', 'Procurement\SupplyChainJsonController@materialAutoSuggestWhereDepthThree')->name('materialAutoSuggestWhereDepthThree');
    Route::post('CheckMaterialAutoSuggestWhereDepthThree', 'Procurement\SupplyChainJsonController@CheckMaterialAutoSuggestWhereDepthThree')->name('CheckMaterialAutoSuggestWhereDepthThree');
    Route::post('floorAutoSuggest', 'Procurement\SupplyChainJsonController@floorAutoSuggest')->name('floorAutoSuggest');
    Route::get('loadProjectWiseFloor/{project_id}', 'Procurement\SupplyChainJsonController@loadProjectWiseFloor')->name('loadProjectWiseFloor');
    Route::post('ProjectWiseBOQbudgetedMaterials', 'Procurement\SupplyChainJsonController@ProjectWiseBOQbudgetedMaterials')->name('ProjectWiseBOQbudgetedMaterials');

    Route::post('projectAutoSuggestBeforeBOQ', 'Procurement\SupplyChainJsonController@projectAutoSuggestBeforeBOQ')->name('projectAutoSuggestBeforeBOQ');
    Route::post('mprAutoSuggest', 'Procurement\SupplyChainJsonController@mprAutoSuggest')->name('mprAutoSuggest');
    Route::post('requisitionWiseMaterialAutoSuggest', 'Procurement\SupplyChainJsonController@requisitionWiseMaterialAutoSuggest')->name('requisitionWiseMaterialAutoSuggest');
    Route::get('loadMprMaterial/{mpr_id}/{cs_id}', 'Procurement\SupplyChainJsonController@loadMprMaterial')->name('loadMprMaterial');
    Route::get('loadrequisitionmaterial/{material_id}/{mpr_no}', 'Procurement\SupplyChainJsonController@loadrequisitionmaterial')->name('loadrequisitionmaterial');
    Route::post('MprAutoSuggestWithPO', 'Procurement\SupplyChainJsonController@MprAutoSuggestWithPO')->name('MprAutoSuggestWithPO');
    Route::post('SupplierWisePo', 'Procurement\SupplyChainJsonController@SupplierWisePo')->name('SupplierWisePo');
    Route::get('loadMPRWiseFloor/{requisition_id}', 'Procurement\SupplyChainJsonController@loadMPRWiseFloor')->name('loadMPRWiseFloor');
    Route::get('floorWsiseRequisitionMaterials', 'Procurement\SupplyChainJsonController@floorWsiseRequisitionMaterials')->name('floorWsiseRequisitionMaterials');
    Route::get('getRequisitionMaterialDetailsForRow', 'Procurement\SupplyChainJsonController@getRequisitionMaterialDetailsForRow')->name('getRequisitionMaterialDetailsForRow');
    Route::post('projectWsiseRequisitionMaterials', 'Procurement\SupplyChainJsonController@projectWsiseRequisitionMaterials')->name('projectWsiseRequisitionMaterials');
    Route::post('getRequisionDetailsByProjectAndMaterial', 'Procurement\SupplyChainJsonController@getRequisionDetailsByProjectAndMaterial')->name('getRequisionDetailsByProjectAndMaterial');
    Route::post('getMrrDetailsByProjectAndMaterial', 'Procurement\SupplyChainJsonController@getMrrDetailsByProjectAndMaterial')->name('getMrrDetailsByProjectAndMaterial');
    Route::post('headOfficeWiseRequisitionMaterials', 'Procurement\SupplyChainJsonController@headOfficeWiseRequisitionMaterials')->name('headOfficeWiseRequisitionMaterials');
    Route::post('getFloorForMaterials', 'Procurement\SupplyChainJsonController@getFloorForMaterials')->name('getFloorForMaterials');
    Route::post('getMrrQuantity', 'Procurement\SupplyChainJsonController@getMrrQuantity')->name('getMrrQuantity');
    Route::post('getPresentStockQuantity', 'Procurement\SupplyChainJsonController@getPresentStockQuantity')->name('getPresentStockQuantity');
    Route::get('getMaterialsAndQuantityByPoNo/{po_no}', 'Procurement\SupplyChainJsonController@getMaterialsAndQuantityByPoNo')->name('getMaterialsAndQuantityByPoNo');
    Route::post('LoadMrr', 'Procurement\SupplyChainJsonController@LoadMrr')->name('LoadMrr');
    Route::get('getMaterialsAndQuantityByMprNo/{mpr_no}/{po_no}', 'Procurement\SupplyChainJsonController@getMaterialsAndQuantityByMprNo')->name('getMaterialsAndQuantityByMprNo');
    Route::get('getMrrByProject/{cost_center_id}', 'Procurement\SupplyChainJsonController@getMrrByProject')->name('getMrrByProject');
    Route::post('projectAutoSuggestAfterMRR', 'Procurement\SupplyChainJsonController@projectAutoSuggestAfterMRR')->name('projectAutoSuggestAfterMRR');
    Route::get('loadProjectWiseFloorAfterMrr/{project_id}', 'Procurement\SupplyChainJsonController@loadProjectWiseFloorAfterMrr')->name('loadProjectWiseFloorAfterMrr');
    Route::get('floorswiseMrrMaterials', 'Procurement\SupplyChainJsonController@floorswiseMrrMaterials')->name('floorswiseMrrMaterials');
    Route::get('projectWiseMrrMaterials', 'Procurement\SupplyChainJsonController@projectWiseMrrMaterials')->name('projectWiseMrrMaterials');
    Route::get('headOfficeWiseMrrMaterials', 'Procurement\SupplyChainJsonController@headOfficeWiseMrrMaterials')->name('headOfficeWiseMrrMaterials');
    Route::get('getMrrDetailsByMaterial', 'Procurement\SupplyChainJsonController@getMrrDetailsByMaterial')->name('getMrrDetailsByMaterial');

    Route::post('getMaterialsAndQuantityByProject', 'Procurement\SupplyChainJsonController@getMaterialsAndQuantityByProject')->name('getMaterialsAndQuantityByProject');
    // Route::get('getMaterialsAndQuantityByProject/{cost_center_id}', 'Procurement\SupplyChainJsonController@getMaterialsAndQuantityByProject')->name('getMaterialsAndQuantityByProject');

    Route::post('bdLeadAtoSuggest', 'Procurement\SupplyChainJsonController@bdLeadAtoSuggest')->name('bdLeadAtoSuggest');

    Route::get('getChildMaterial', 'Procurement\SupplyChainJsonController@getChildMaterial');
    Route::get('getEmeWorks', 'Procurement\SupplyChainJsonController@getEmeWorks')->name('getEmeWorks');
    Route::post('getLaborWorks', 'Procurement\SupplyChainJsonController@getLaborWorks');
    Route::post('ConstructionTentativeBudgetProjectAutoSuggestWithBoq', 'Procurement\SupplyChainJsonController@ConstructionTentativeBudgetProjectAutoSuggestWithBoq')->name('ConstructionTentativeBudgetProjectAutoSuggestWithBoq');

    Route::get('getParentMaterial', 'Procurement\SupplyChainJsonController@getParentMaterial')->name('getParentMaterial');
    Route::get('getLayer2ParentMaterial', 'Procurement\SupplyChainJsonController@getLayerParentMaterial')->name('getLayer2ParentMaterial');
    Route::get('getLayer3Material', 'Procurement\SupplyChainJsonController@getLayerParentMaterial')->name('getLayer3Material');
    Route::get('getLayer3MaterialRateWise', 'Procurement\SupplyChainJsonController@getLayer3MaterialRateWise')->name('getLayer3MaterialRateWise');
    Route::post('DepartmentWiseBillSearch', 'Procurement\SupplyChainJsonController@DepartmentWiseBillSearch')->name('DepartmentWiseBillSearch');

    Route::get('GetCsPriceforMpr/{cs_id}/{material_id}/{supplier_id}', 'Procurement\SupplyChainJsonController@GetCsPriceforMpr')->name('GetCsPriceforMpr');
    Route::get('ProjectAutoSearchHavingIou', 'Procurement\SupplyChainJsonController@ProjectAutoSearchHavingIou')->name('ProjectAutoSearchHavingIou');
    Route::get('SearchAccountHead', 'Procurement\SupplyChainJsonController@SearchAccountHead')->name('SearchAccountHead');
    Route::get('SearchIouNo', 'Procurement\SupplyChainJsonController@SearchIouNo')->name('SearchIouNo');
    Route::get('getMprByCostCenter', 'Procurement\SupplyChainJsonController@getMprByCostCenter')->name('getMprByCostCenter');
    Route::get('getMrrByCostCenter', 'Procurement\SupplyChainJsonController@getMrrByCostCenter')->name('getMrrByCostCenter');
    Route::get('getMrrByCostCenterAndIou', 'Procurement\SupplyChainJsonController@getMrrByCostCenterAndIou')->name('getMrrByCostCenterAndIou');
    Route::get('getBoqBudgetMax', 'Procurement\SupplyChainJsonController@getBoqBudgetMax')->name('getBoqBudgetMax');
    Route::get('materialAutoSuggestHavingBoqOrAll', 'Procurement\SupplyChainJsonController@materialAutoSuggestHavingBoqOrAll')->name('materialAutoSuggestHavingBoqOrAll');

    Route::post('LoadSgsf', 'Procurement\SupplyChainJsonController@LoadSgsf')->name('LoadSgsf');
    Route::get('getSgsfMaterial/{sgsf_id}', 'Procurement\SupplyChainJsonController@getSgsfMaterial')->name('getSgsfMaterial');

    Route::post('getMTRFInfobyMaterial', 'Procurement\SupplyChainJsonController@getMTRFInfobyMaterial')->name('getMTRFInfobyMaterial');
    Route::get('loadFixedCost/{material_id}', 'Procurement\SupplyChainJsonController@loadFixedCost');

    Route::post('getScrapMaterial', 'Procurement\SupplyChainJsonController@getScrapMaterial')->name('getScrapMaterial');
    Route::post('getUnitForMaterial', 'Procurement\SupplyChainJsonController@getUnitForMaterial')->name('getUnitForMaterial');

    Route::get('getFARvalue', 'Procurement\SupplyChainJsonController@getFARvalue')->name('getFARvalue');
    Route::post('getProposedStory', 'Procurement\SupplyChainJsonController@getProposedStory')->name('getProposedStory');

    Route::get('getFeasibilityEntryData', 'Procurement\SupplyChainJsonController@getFeasibilityEntryData')->name('getFeasibilityEntryData');

    Route::get('getTotalCostwithoutInterest', 'Procurement\SupplyChainJsonController@getTotalCostwithoutInterest')->name('getTotalCostwithoutInterest');

    Route::post('feasiFloorAutoSuggest', 'Procurement\SupplyChainJsonController@feasiFloorAutoSuggest')->name('feasiFloorAutoSuggest');
    Route::get('getSubStructureTotal/{location_id}', 'Procurement\SupplyChainJsonController@getSubStructureTotal')->name('getSubStructureTotal');

    Route::post('findSupplierDetailInfo', 'Procurement\SupplyChainJsonController@findSupplierDetailInfo')->name('findSupplierDetailInfo');
    Route::post('allFloorAutoSuggest', 'Procurement\SupplyChainJsonController@allFloorAutoSuggest')->name('allFloorAutoSuggest');
});
