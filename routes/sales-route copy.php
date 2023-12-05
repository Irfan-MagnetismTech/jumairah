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


Route::group(['middleware'=>'auth'], function(){
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

    Route::get('salesinvoice/{sellId}/{notifyThrough}', 'Sells\SellsReportController@salesinvoice')->name('salesinvoice');

    Route::get('addfollowup/{leadgeneration_id}', 'Sells\FollowupController@addfollowup')->name('addfollowup');
    Route::get('noactivity', 'Sells\LeadgenerationController@noactivity')->name('noactivity');
//    Route::get('accounceapproval/{salesCollection_id}', 'Sells\AccounceApprovalController@addaccounceapproval')->name('accounceapproval');

    Route::get('addsaleactivity/{sell_id}', 'Sells\SaleactivityController@addsaleactivity')->name('addsaleactivity');

    Route::get('salescollectionapproval/{salesCollection_id}', 'Sells\SalesCollectionApprovalController@addsalescollectionapproval')->name('salescollectionapproval');

    Route::get('saleCancellations/{saleCancellation_id}/approve', 'Sells\SaleCancellationController@approveSaleCancellation')->name('approveSaleCancellation');

    Route::post('approveSaleCancellation', 'Sells\SaleCancellationController@storeApprovalInformation');

    Route::get('salesperformance', 'Sells\SellController@salesperformance')->name('salesperformance');

    Route::get('sells/{sell}/saleactivity', 'Sells\SellController@saleactivity')->name('saleactivity');

    Route::get('salesCollections/{salesCollection}/acknowledgement', 'SalesCollectionController@acknowledgement')->name('acknowledgement'); // print acknowledgement report.

//    Route::get('sellNameTransfer', 'Sells\SellController@sellNameTransfer')->name('sellNameTransfer');

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
    ]);
});
