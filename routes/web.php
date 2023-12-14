<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Auth;
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

//Route::get('/multipleAddMore', 'Procurement\SupplierbillController@multipleAddMore');

Auth::routes( ['register' => false] );

Route::get( '/test-input', function () {
	$requisitions = \App\Procurement\Requisition::all();
	foreach ( $requisitions as $requisition ) {
		foreach ( $requisition->requisitiondetails as $detail ) {
			$projectId = $requisition->costCenter->project_id;
			$detail->project_id = $projectId;
			$detail->save();
		}
	}
} );

Route::get( '/list', function () {return view( 'indexTest' );} );
Route::group( ['middleware' => 'auth'], function () {

	Route::get( '/', 'HomeController@index' )->name( 'home' );
	Route::get( '/password-change-config', 'Auth\ResetOldPasswordController@PasswordResetForm' )->name( 'password-change-form' );
	Route::post( '/password-change', 'Auth\ResetOldPasswordController@ResetPassword' )->name( 'password-change' );
//JSON Controller
	Route::get( 'getDepartmentEmployee/{departmentId}', 'JsonController@getDepartmentEmployee' );

//JSON Controller

	Route::get( 'getDistricts/{division_id}', 'JsonController@getDistrict' )->name( 'getDistricts' );
	Route::get( 'getThanas/{district_id}', 'JsonController@getThana' );
	Route::get( 'getMouzas/{thana_id}', 'JsonController@getMouza' );

//    AutoSuggesst
	Route::get( 'employeeAutoComplete/{employee_id}', 'JsonController@employeeAutoComplete' );
	Route::get( 'bankAutoComplete/{bank_id}', 'JsonController@bankAutoComplete' );
	Route::get( 'supplierAutoComplete/{supplier_id}', 'JsonController@supplierAutoComplete' );
	Route::get( 'lcCostHeadAutoComplete/{lc_cost_heads_id}', 'JsonController@lcCostHeadAutoComplete' );

	Route::post( '/countryAutoSuggest', 'JsonController@countryAutoSuggest' )->name( 'countryAutoSuggest' );

//    Route::get('getPerDistricts/{per_division_id}', 'JsonController@getDistrict');

	Route::resource( 'departments', 'DepartmentController' );
	Route::resource( 'mouzas', 'MouzaController' );
	Route::resource( 'designations', 'DesignationController' );
	Route::resource( 'to_do_lists', 'ToDoListController' );

	Route::resource( 'users', 'UserController' );
	Route::resource( 'permissions', 'PermissionController' );
	Route::resource( 'roles', 'RoleController' );

	Route::resource( 'employees', 'EmployeeController' );
	Route::resource( 'teams', 'TeamController' );

	Route::get( 'requisitions/issued/{id}', 'Procurement\RequisitionController@issued' );

	//inventory
	Route::get( 'inventoryReport/currentStockPDF', 'InventoryReportController@currentstockPdf' )->name( 'currentStockPDF' );
	Route::get( 'inventoryReport/availableStockSearch', 'InventoryReportController@currentInventoryList' )->name( 'availableStockSearch' );
	Route::post( 'inventoryReport/supplierStock', 'InventoryReportController@supplierStock' )->name( 'supplierStock' );
	Route::get( 'inventoryReport/suppStockSearch', 'InventoryReportController@suppStockSearch' )->name( 'suppStockSearch' );
	Route::get( 'inventoryReport/minimumStock', 'InventoryReportController@minimumStock' )->name( 'minimumStock' );
	Route::post( 'inventoryReport/minimumStockPDF', 'InventoryReportController@minimumStockPDF' )->name( 'minimumStockPDF' );
	Route::get( 'purchasepdf/{id}', 'Procurement\PurchaseController@purchasepdf' );

	//General Requisitions
	Route::resource( 'general-requisitions', 'GeneralRequisitionController' );
	Route::get( 'general-requisition-pdf/{id}', 'GeneralRequisitionController@pdf' )->name( 'general-requisition-pdf' );
	Route::get( 'generalRequisitions/approved/{requisition}/{status}', 'GeneralRequisitionController@generalRequisitionApproved' )->name( 'generalRequisitionApproved' );

	// Route::get('seed_material', 'GeneralRequisitionController@seed_material')->name('seed_material');

	/******************* Bill Register ******************/
	Route::resource( 'bill-register', 'BillRegisterController' );
	Route::get( 'bill-accept/{bill_register_id}', 'BillRegisterController@bill_accept' )->name( 'bill-accept' );
	Route::get( 'bill-delivered/{bill_register_id}', 'BillRegisterController@bill_delivered' )->name( 'bill-delivered' );
	Route::get( 'bill-register-approve/{bill_register_id}', 'BillRegisterController@bill_register_approve' )->name( 'bill-register-approve' );
	Route::resource( 'leayer-name', 'config\LeayerNameController' );
	Route::resource( 'budget-head', 'config\BudgetHeadController' );
	Route::resource( 'costMemo', 'CostMemoController' );
	Route::get( 'notification', [NotificationController::class, 'index'] );

	/******************* Profitability */
	Route::get( '/profitabilityBasicInformation', 'ProfitabilityController@index' )->name( 'profitabilityBasicInformation' );

	Route::get( '/profitabilityData', 'ProfitabilityController@getDataByProject' )->name( 'profitabilityData' );

} );
