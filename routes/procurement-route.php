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

Route::group(['middleware' => 'auth'], function ()
{
    // requisitions
    Route::get('loadBOQbudgetedMaterialsDropdown/{project_id}', 'Procurement\ProcurementAutoSuggestController@loadBOQbudgetedMaterialsDropdown')->name('loadBOQbudgetedMaterialsDropdown');
    Route::get('requisition-pdf/{id}', 'Procurement\RequisitionController@pdf')->name('requisition-pdf');


    Route::post('materialAutoSuggest', 'Procurement\ProcurementAutoSuggestController@materialAutoSuggest')->name('materialAutoSuggest');
    Route::post('budgetedmaterialAutoSuggest', 'Procurement\ProcurementAutoSuggestController@budgetedmaterialAutoSuggest')->name('budgetedmaterialAutoSuggest');
    Route::post('getRequisionDetailsByProjectAndMaterial', 'Procurement\ProcurementAutoSuggestController@getRequisionDetailsByProjectAndMaterial')->name('getRequisionDetailsByProjectAndMaterial');
    Route::post('supplierAutoSuggest', 'Procurement\ProcurementAutoSuggestController@supplierAutoSuggest')->name('supplierAutoSuggest');
    Route::post('csAutoSuggest', 'Procurement\ProcurementAutoSuggestController@csAutoSuggest')->name('csAutoSuggest');
    Route::post('poAutoSuggest', 'Procurement\ProcurementAutoSuggestController@poAutoSuggest')->name('poAutoSuggest');
    Route::post('mprAutoSuggest', 'Procurement\ProcurementAutoSuggestController@mprAutoSuggest')->name('mprAutoSuggest');
    Route::post('iouAutoSuggest', 'Procurement\ProcurementAutoSuggestController@iouAutoSuggest')->name('iouAutoSuggest');
    Route::post('MprByPoAutoSuggest', 'Procurement\ProcurementAutoSuggestController@MprByPoAutoSuggest')->name('MprByPoAutoSuggest');

    Route::get('loadCsSupplier/{cs_id}', 'Procurement\ProcurementAutoSuggestController@loadCsSupplier')->name('loadCsSupplier');
    Route::get('loadCsProject/{cs_id}', 'Procurement\ProcurementAutoSuggestController@loadCsProject')->name('loadCsProject');
    Route::get('loadCsMaterial/{cs_id}', 'Procurement\ProcurementAutoSuggestController@loadCsMaterial')->name('loadCsMaterial');
    Route::get('loadMprMaterial/{mpr_id}/{cs_id}', 'Procurement\ProcurementAutoSuggestController@loadMprMaterial')->name('loadMprMaterial');
    Route::get('loadMprMaterialByPoNo/{po_no}', 'Procurement\ProcurementAutoSuggestController@loadMprMaterialByPoNo')->name('loadMprMaterialByPoNo');
    Route::get('loadMprMaterialByMprNo/{mpr_id}', 'Procurement\ProcurementAutoSuggestController@loadMprMaterialByMprNo')->name('loadMprMaterialByMprNo');
    Route::get('loadMprAmount/{mpr_id}', 'Procurement\ProcurementAutoSuggestController@loadMprAmount')->name('loadMprAmount');
    Route::get('loadrequisitionmaterial/{material_id}/{mpr_no}', 'Procurement\ProcurementAutoSuggestController@loadrequisitionmaterial')->name('loadrequisitionmaterial');
    Route::get('loadmaterialDetailsByPoNo/{material_id}/{po_no}', 'Procurement\ProcurementAutoSuggestController@loadmaterialDetailsByPoNo')->name('loadmaterialDetailsByPoNo');
    Route::get('getmaterialDetailsByPoNo/{material_id}/{po_no}', 'Procurement\ProcurementAutoSuggestController@getmaterialDetailsByPoNo')->name('getmaterialDetailsByPoNo');
    // loadIouMaterials - param mpr_no

    Route::get('loadMPRWisePo/{mpr_id}', 'Procurement\ProcurementAutoSuggestController@loadMPRWisePo')->name('loadMPRWisePo');
    Route::get('getCSReferrenceByPoNo/{po_no}', 'Procurement\ProcurementAutoSuggestController@getCSReferrenceByPoNo')->name('getCSReferrenceByPoNo');
    Route::get('loadIouMaterials/{mpr_id}', 'Procurement\ProcurementAutoSuggestController@loadIouMaterials')->name('loadIouMaterials');
    Route::get('getIOUMaterialDetails/{mpr_no}/{material_id}', 'Procurement\ProcurementAutoSuggestController@getIOUMaterialDetails')->name('getIOUMaterialDetails');

    Route::post('materialAutoSuggest', 'Procurement\ProcurementAutoSuggestController@materialAutoSuggest')->name('materialAutoSuggest');
    Route::get('LoadPoMprSupplierByMrr/{mrr_no}', 'Procurement\ProcurementAutoSuggestController@LoadPoMprSupplierByMrr')->name('LoadPoMprSupplierByMrr');
    Route::post('LoadMrr', 'Procurement\ProcurementAutoSuggestController@LoadMrr')->name('LoadMrr');

    Route::get('loadmrramount/{mrr_id}', 'Procurement\ProcurementAutoSuggestController@loadmrramount')->name('loadmrramount');
    Route::get('loadpobasedmaterial/{material_id}/{po_id}', 'Procurement\ProcurementAutoSuggestController@loadpobasedmaterial')->name('loadpobasedmaterial');
    Route::post('loadposupplier', 'Procurement\ProcurementAutoSuggestController@loadposupplier')->name('loadposupplier');
    Route::get('getSuppliers/{type}', 'Procurement\ProcurementAutoSuggestController@getSupplier');
    Route::get('getMaterialName/{raw_item_name}', 'Procurement\ProcurementAutoSuggestController@getMaterialName');
    Route::get('purchase/getPurchaseOrder/{po_id}', 'JsonController@getPurchaseOrder');
    Route::get('stockReturn/getStockOutDetail/{so_id}', 'JsonController@getStockOutDetail');
    Route::get('inventoryReport/stockout', 'InventoryReportController@availableStock')->name('availableStock');
    Route::get('purchaseorderpdf/{id}', 'PurchaseOrderController@purchaseorderpdf');
    // for requisition approval
    Route::get('requisitions/approved/{requisition}/{status}', 'Procurement\RequisitionController@requisitionApproved')->name('requisitionApproved');
    Route::get('general-requisitions/approved/{requisition}/{status}', 'GeneralRequisitionController@generalRequisitionApproved')->name('generalRequisitionApproved');
    Route::get('cs/approved/{comparative_statement}/{status}', 'Procurement\CsController@csApproved')->name('csApproved');
    Route::get('purchaseOrders/approved/{purchaseOrder}/{status}', 'PurchaseOrderController@purchaseOrderApproval')->name('purchaseOrdersApproved');

    Route::get('store-issue/approved', 'Procurement\StoreissueController@StoreIssueApproved')->name('store-issue-approved');
    Route::post('StoreIssueApprovedStore', 'Procurement\StoreissueController@StoreIssueApproved')->name('StoreIssueApprovedStore');
    Route::get('store-issue-view/approved/{storeissue}/{status}', 'Procurement\StoreissueController@StoreIssueApprovedView')->name('store-issue-approved-view');

    // for report

    Route::get('purchaseorderreport', 'Procurement\ProcurementReportController@purchaseorderreport')->name('purchaseorderreport');
    Route::get('requisitionreport', 'Procurement\ProcurementReportController@requisitionreport')->name('requisitionreport');
    Route::get('ioureport', 'Procurement\ProcurementReportController@ioureport')->name('ioureport');
    Route::get('advanceadjustmentreport', 'Procurement\ProcurementReportController@advanceadjustmentreport')->name('advanceadjustmentreport');
    Route::get('csreport', 'Procurement\ProcurementReportController@csreport')->name('csreport');
    Route::get('storeissuenotereport', 'Procurement\ProcurementReportController@storeissuenotereport')->name('storeissuenotereport');
    // Route::get('store-issue-approve/{storeissue}', 'Procurement\StoreissueController@storeissueApproval');
    Route::get('supplierbillreport', 'Procurement\ProcurementReportController@supplierbillreport')->name('supplierbillreport');
    Route::get('comparative-statements/pdf/{comparative_statement}', 'Procurement\CsController@getCsPdf')->name('comparative-statements-pdf');
    Route::get('material-movements-pdf/pdf/{material_movement}', 'Procurement\MaterialmovementController@getmaterialmovementsPdf')->name('material-movements-pdf');

    Route::get('purchase-orders-pdf/{id}/{type}', 'PurchaseOrderController@purchaseorderpdf')->name('purchase_order_pdf');
    Route::get('iouapprovalview/{iou}', 'Procurement\IouApprovalController@iouapprovalview');
    Route::get('iou/approved/{iou}/{status}', 'Procurement\IouController@Approve')->name('iouApproved');
    Route::get('generalBill/approved/{generalBill}/{status}', 'Procurement\GeneralBillController@Approve')->name('generalBillApproved');
//    Route::get('supplierBillApproveView/{supplierbill}/{status}', 'Procurement\SupplierbillController@supplierBillApproveView');
    Route::get('supplierBillApprove/{supplierbill}/{status}', 'Procurement\SupplierbillController@supplierBillApprove');
    Route::get('supplierBillRequest/{supplierbill}', 'Procurement\SupplierbillController@supplierBillRequest')->name('supplierBillRequest');
    Route::get('supplierBillReject/{supplierbill}', 'Procurement\SupplierbillController@supplierBillReject')->name('supplierBillReject');
    Route::get('material-receive-approve/{materialReceive}/{status}', 'Procurement\MaterialReceiveController@materialReceiveApproval');
    Route::get('material-list', 'Procurement\NestedMaterialController@materialList')->name('material-list');


    Route::get('cost-center-list', 'Procurement\MaterialInventoryReportController@projectList')->name('mir-costcenter-List');
    Route::get('get-report/{cost_center_id}', 'Procurement\MaterialInventoryReportController@GetReportAll')->name('mir-getall-report');
    Route::post('get-report', 'Procurement\MaterialInventoryReportController@GetReport')->name('mir-get-report');
    Route::get('mirPdf','Procurement\MaterialInventoryReportController@mirPdf')->name('mirPdf');

    Route::get('cost_center_list', 'Procurement\MaterialLedgerController@projectList')->name('costcenter_List');
    Route::get('get-material/{cost_center_id}', 'Procurement\MaterialLedgerController@Getmaterial')->name('get_material');
    Route::get('get-material-ledger/{cost_center_id}/{material_id}', 'Procurement\MaterialLedgerController@GetMaterialLedger')->name('get_material_ledger');
    Route::get('get-material-ledger-pdf/{cost_center_id}/{material_id}', 'Procurement\MaterialLedgerController@GetMaterialLedgerPdf')->name('get_material_ledger_pdf');
    Route::get('get-material-ledger', 'Procurement\MaterialLedgerController@GetMaterialLedgers')->name('get_material_ledgers');

    Route::get('scm-material-budget-year-List}', 'Procurement\ScmMaterialBudgetController@yearList')->name('scm-material-budget-year-List');
    Route::get('scm-material-plan-month-List/{year}', 'Procurement\ScmMaterialBudgetController@monthList')->name('scm-material-plan-month-List');
    Route::get('scm-material-budget-project-list/{year}/{month}', 'Procurement\ScmMaterialBudgetController@projectList')->name('scm-material-budget-project-list');
    Route::get('scm-material-budget-details/{year}/{month}/{project_id}/{id}', 'Procurement\ScmMaterialBudgetController@budgetDetails')->name('scm-material-budget-details');
    Route::get('scm-material-budget-direction/{year}/{month}', 'Procurement\ScmMaterialBudgetController@direction')->name('scm-material-budget-direction');

    Route::get('scm-material-budget-dashboard/{year}/{month}', 'Procurement\ScmMaterialBudgetController@budgetDashboard')->name('scm-material-budget-dashboard');
    Route::get('scm-material-payment-dashboard/{year}/{month}', 'Procurement\ScmMaterialBudgetController@paymentDashboard')->name('scm-material-payment-dashboard');
    Route::get('vendors_outstanding_statement', 'Procurement\VendorsOutstandingStatementController@statement')->name('vendors_outstanding_statement');
    Route::post('vendor-outstanding-report', 'Procurement\VendorsOutstandingStatementController@getReport')->name('vendor-outstanding-report');
    Route::get('vendors-outstanding-statement-pdf', 'Procurement\VendorsOutstandingStatementController@pdf')->name('vendors-outstanding-statement-pdf');
    Route::get('budget-deshboard-pdf', 'Procurement\ScmMaterialBudgetController@budgetDashboardPDF')->name('budget-deshboard-pdf');
    Route::get('payment-deshboard-pdf', 'Procurement\ScmMaterialBudgetController@paymentDashboardPDF')->name('payment-deshboard-pdf');
    Route::get('scm-material-budget-pdf/{year}/{month}/{project_id}/{id}', 'Procurement\ScmMaterialBudgetController@ScmMaterialBudgetPdf')->name('scm-material-budget-pdf');

    Route::get('advanceadjustments/approved/{advanceAdjustment}/{status}', 'Procurement\AdvanceAdjustmentController@approve')->name('employeeadjustments-approve');
    Route::get('advanceadjustments/ShowFile/{advanceadjustmentdetail}', 'Procurement\AdvanceAdjustmentController@ShowFile')->name('advanceadjustments.ShowFile');

    Route::get('supreme-budget-list/{budgetFor}', 'Procurement\BoqSupremeBudgetController@ProjectList')->name('supreme-budget-list');
    Route::get('supreme-budget-show/{budgetFor}/{project_id}', 'Procurement\BoqSupremeBudgetController@floorWiseSummery')->name('supreme-budget-show');
    Route::get('supreme-budget-edit/{budgetFor}/{project_id}', 'Procurement\BoqSupremeBudgetController@supremeBudgetEdit')->name('supreme-budget-edit');
    Route::put('supreme-budget-update/{budgetFor}/{project_id}', 'Procurement\BoqSupremeBudgetController@supremeBudgetUpdate')->name('supreme-budget-update');
    Route::get('material_summery/{budgetFor}/{project_id}', 'Procurement\BoqSupremeBudgetController@material_summery');
    Route::get('warehouses/approved/{warehouse}/{status}', 'Procurement\WarehouseController@Approved')->name('warehouses.Approved');
    Route::get('supplierbills_pdf/{id}', 'Procurement\SupplierbillController@Pdf')->name('supplierbills-pdf');
    Route::get('requestedSupplierbills', 'Procurement\SupplierbillController@requestedSupplierbills')->name('requestedSupplierbills');

    Route::get('ious/pdf/{id}', 'Procurement\IouController@Pdf')->name('iou.pdf');
    Route::get('icmdLaborBudget/pdf/{id}', 'Procurement\IcmdLaborBudgetController@Pdf')->name('icmdLaborBudget.pdf');
    Route::get('icmdLaborBudget/approve/{icmdLaborBudget}/{status}', 'Procurement\IcmdLaborBudgetController@Approve')->name('icmdLaborBudget.approve');

    Route::get('floor-wise-consumption', 'Procurement\ProcurementReportController@floorWiseConsumption')->name('floor-wise-consumption');
    Route::get('getFloor/{project_id}', 'Procurement\SupplyChainJsonController@getFloor')->name('getFloor');

    Route::get('generalBilldetail/ShowFile/{generalBilldetail}', 'Procurement\GeneralBillController@ShowFile')->name('generalBilldetail.ShowFile');

    Route::resources([
        'units'                  => 'Procurement\UnitController',
        'suppliers'              => 'Procurement\SupplierController',
        'nestedmaterials'        => 'Procurement\NestedMaterialController',
        'materialbudgets'        => 'Procurement\MaterialbudgetController',
        'ScmMaterialBudgets'     => 'Procurement\ScmMaterialBudgetController',
        'boqSupremeBudgets'      => 'Procurement\BoqSupremeBudgetController',
        'comparative-statements' => 'Procurement\CsController',
        'requisitions'           => 'Procurement\RequisitionController',
        'purchaseOrders'         => 'PurchaseOrderController',
        'purchases'              => 'Procurement\PurchaseController',
        'materialReceives'       => 'Procurement\MaterialReceiveController',
        'materialmovements'      => 'Procurement\MaterialmovementController',
        'payments'               => 'Procurement\PaymentController',
        'ious'                   => 'Procurement\IouController',
        'icmdLaborBudget'        => 'Procurement\IcmdLaborBudgetController',
        'advanceadjustments'     => 'Procurement\AdvanceAdjustmentController',
        'procurementreports'     => 'Procurement\ProcurementReportController',
        'warehouses'             => 'Procurement\WarehouseController',
        'storeissues'            => 'Procurement\StoreissueController',
        'supplierbills'          => 'Procurement\SupplierbillController',
        'iouapprovals'           => 'Procurement\IouApprovalController',
        'opening-material'       => 'Procurement\OpeningRawMaterialController',
        'generalBill'            => 'Procurement\GeneralBillController',
    ]);
});
