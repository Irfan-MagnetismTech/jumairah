<?php

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
    Route::post('projectAutoSuggest', 'JsonController@projectAutoSuggest')->name('projectAutoSuggest');
    Route::post('clientAutoSuggest', 'JsonController@clientAutoSuggest')->name('clientAutoSuggest');
    Route::post('leadAutoSuggest', 'JsonController@leadAutoSuggest')->name('leadAutoSuggest');

    Route::get('loadProjectApartment/{project_id}', 'JsonController@loadProjectApartment')->name('loadProjectApartment');
    Route::get('loadClientInformations/{client_id}', 'JsonController@loadClientInformations')->name('loadClientInformations');
    Route::get('loadProjectTypes/{project_id}', 'JsonController@loadProjectTypes')->name('loadProjectTypes');
    Route::get('loadProjectBasement/{project_id}', 'JsonController@loadProjectBasement')->name('loadProjectBasement');
    Route::get('loadLeadInformations/{lead_id}', 'JsonController@loadLeadInformations')->name('loadLeadInformations');
    Route::get('loadSoldClientsWithApartment/{project_id}', 'JsonController@loadSoldClientsWithApartment')->name('loadSoldClientsWithApartment');
    Route::get('loadSoldApartmentInformation/{sell_id}', 'JsonController@loadSoldApartmentInformation')->name('loadSoldApartmentInformation');
    Route::get('loadCurrentInstallment/{sell_id}', 'JsonController@loadCurrentInstallment')->name('loadCurrentInstallment');
    Route::get('loadNextInstallment/{sell_id}/{installment_no}', 'JsonController@loadNextInstallment')->name('loadNextInstallment');


    Route::get('loadBookingMoney/{sell_id}', 'JsonController@loadBookingMoney')->name('loadBookingMoney');
    Route::get('loadDownpayment/{sell_id}', 'JsonController@loadDownpayment')->name('loadDownpayment');
    Route::get('loadProjectUnsoldParkings/{project_id}', 'JsonController@loadProjectUnsoldParkings')->name('loadProjectUnsoldParkings');


    //reports
    Route::get('inventoryreport', 'Sells\SellsReportController@inventoryreport')->name('inventoryreport');
    Route::get('projectsreport', 'Sells\SellsReportController@projectsreport')->name('projectsreport');
    Route::get('projectreport', 'Sells\SellsReportController@projectreport')->name('projectreport');
    Route::get('monthlyprojectsreport', 'Sells\SellsReportController@monthlyprojectsreport')->name('monthlyprojectsreport');
    Route::get('collectionsreport', 'Sells\SellsReportController@collectionsreport')->name('collectionsreport');

    Route::get('finalsettlementreport', 'Sells\SellsReportController@finalsettlementreport')->name('finalsettlementreport');
    Route::get('clientcollectionreport', 'Sells\SellsReportController@clientcollectionreport')->name('clientcollectionreport');

    Route::get('revenueinflowreport', 'Sells\SellsReportController@revenueinflowreport')->name('revenueinflowreport');

    Route::get('yearlycollectionreport', 'Sells\SellsReportController@yearlycollectionreport')->name('yearlycollectionreport');

    Route::get('salesinvoice/{sell}/{notifyThrough}', 'Sells\SellsReportController@salesinvoice')->name('salesinvoice');

    Route::get('addfollowup/{leadgeneration_id}', 'Sells\FollowupController@addfollowup')->name('addfollowup');
    Route::get('todayFollowups', 'Sells\FollowupController@todayFollowups')->name('todayFollowups');
    Route::get('missedFollowup', 'Sells\FollowupController@missedFollowup')->name('missedFollowup');
    Route::get('dead-list', 'Sells\LeadgenerationController@deadList')->name('dead-list');
    Route::get('noactivity', 'Sells\LeadgenerationController@noactivity')->name('noactivity');
    Route::post('lead-transfer', 'Sells\LeadgenerationController@leadTransfer')->name('lead-transfer');
    Route::get('contactMessage/{contact}/{code}', 'Sells\LeadgenerationController@contactMessage')->name('contactMessage');

    Route::get('monthly-sales-report', 'Sells\SellsReportController@monthlySalesReport')->name('monthly-sales-report');
    Route::get('collection-forecast', 'Sells\SellsReportController@collectionForecast')->name('collection-forecast');
    Route::get('project-wise-lead-report', 'Sells\LeadgenerationController@projectWiseLeadReport')->name('project-wise-lead-report');
    Route::get('yearly-quarterly-sales-report/{year?}/{print_type?}', 'Sells\SellsReportController@yearlyQuarterlySalesReport')->name('yearly-quarterly-sales-report');
    Route::get('category-wise-lead-generation-report/{month?}/{print_type?}', 'Sells\SellsReportController@categoryWiseLeadGenerationReport')->name('category-wise-lead-generation-report');
    Route::get('week-wise-lead-generation-report/{month?}/{print_type?}', 'Sells\SellsReportController@weekWiseLeadGenerationReport')->name('week-wise-lead-generation-report');


    //    Route::get('accounceapproval/{salesCollection_id}', 'Sells\AccounceApprovalController@addaccounceapproval')->name('accounceapproval');

    Route::get('addsaleactivity/{sell_id}', 'Sells\SaleactivityController@addsaleactivity')->name('addsaleactivity');

    Route::get('salescollectionapproval/{salesCollection_id}', 'Sells\SalesCollectionApprovalController@addsalescollectionapproval')->name('salescollectionapproval');

    Route::get('saleCancellations/{saleCancellation_id}/approve', 'Sells\SaleCancellationController@approveSaleCancellation')->name('approveSaleCancellation');

    Route::post('approveSaleCancellation', 'Sells\SaleCancellationController@storeApprovalInformation');

    Route::get('salesperformance', 'Sells\SellController@salesperformance')->name('salesperformance');

    Route::get('sells/{sell}/saleactivity', 'Sells\SellController@saleactivity')->name('saleactivity');
    Route::get('payment-details-pdf/{sell}', 'Sells\SellController@paymentDetailsPdf')->name('payment-details-pdf');

    Route::get('sells/{sell}/handover', 'Sells\ApartmentHandoverController@handover')->name('handover');

    Route::get('salesCollections/{salesCollection}/acknowledgement', 'SalesCollectionController@acknowledgement')->name('acknowledgement'); // print acknowledgement report.

    Route::post('apartment-handover-approval', 'Sells\ApartmentHandoverController@apartmentHandoverApproval')->name('apartment-handover-approval');
    Route::get('name-transfer-approval/{nameTransfer}/{status}', 'Sells\NameTransferController@approval')->name('name-transfer-approval');
    Route::get('apartment-shiftings-approval/{apartmentShifting}/{status}', 'Sells\ApartmentShiftingController@approval')->name('apartment-shiftings-approval');
    Route::get('yearly-sales-plan-report', 'Sells\SellsReportController@yearlySalesPlan')->name('yearly-sales-plan-report');
    Route::get('yearly-collection-plan-report', 'Sells\SellsReportController@yearlyCollectionPlan')->name('yearly-collection-plan-report');

    //    Route::get('sellNameTransfer', 'Sells\SellController@sellNameTransfer')->name('sellNameTransfer');

    Route::match(['get', 'post'], 'search/leadgeneration', 'Sells\LeadgenerationController@search')->name('search-leadgeneration');

    Route::resources([
        'projects' => 'ProjectController',
        'parkings' => 'Sells\ParkingController',
        'apartments' => 'Sells\ApartmentController',
        'leadgenerations' => 'Sells\LeadgenerationController',
        'followups' => 'Sells\FollowupController',
        'clients' => 'Sells\ClientController',
        'sells' => 'Sells\SellController',
        'saleactivities' => 'Sells\SaleactivityController',
        'salesCollections' => 'SalesCollectionController',
        'sellCollectionHeads' => 'SellCollectionHeadController',
        'salesCollectionApprovals' => 'Sells\SalesCollectionApprovalController',
        'saleCancellations' => 'Sells\SaleCancellationController',
        'apartment-handovers' => 'Sells\ApartmentHandoverController',
        'final-settlements' => 'Sells\FinalSettlementController',
        'name-transfers' => 'Sells\NameTransferController',
        'apartment-shiftings' => 'Sells\ApartmentShiftingController',
        'sales-yearly-budgets' => 'Sells\SalesYearlyBudgetController',
        'collection-yearly-budgets' => 'Sells\CollectionYearlyBudgetController',
    ]);
});
