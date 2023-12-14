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
    Route::get('projects/{project}/log', 'LogController@projectLog')->name('projectLog');
    Route::get('parkings/{id}/log', 'LogController@parkingLog')->name('parkingLog');
    Route::get('apartments/{id}/log', 'LogController@apartmentLog')->name('apartmentLog');
    Route::get('leadgenerations/{id}/log', 'LogController@leadgenerationLog')->name('leadgenerationLog');
    Route::get('followups/{id}/log', 'LogController@followupLog')->name('followupLog');
    Route::get('clients/{id}/log', 'LogController@clientLog')->name('clientLog');
    Route::get('sells/{id}/log', 'LogController@sellLog')->name('sellLog');
    Route::get('salesCollections/{id}/log', 'LogController@salesCollectionLog')->name('salesCollectionLog');
    Route::get('sellCollectionHeads/{id}/log', 'LogController@sellCollectionHeadLog')->name('sellCollectionHeadLog');
    Route::get('salesCollectionApprovals/{id}/log', 'LogController@salesCollectionApprovalLog')->name('salesCollectionApprovalLog');
    Route::get('saleCancellations/{saleCancellation_id}/log', 'LogController@saleCancellationLog')->name('saleCancellationLog');
    Route::get('ious/{iou}/log', 'LogController@iouLog')->name('iouLog');
    Route::get('name-transfers/{nameTransfer}/log', 'LogController@nameTransferLog')->name('nameTransferLog');
    Route::get('requisitionLog/{id}/log', 'LogController@requisitionLog')->name('requisitionLog');
    Route::get('csLog/{id}/log', 'LogController@csLog')->name('csLog');
    Route::get('purchaseOrderLog/{id}/log', 'LogController@purchaseOrderLog')->name('purchaseOrderLog');
    Route::get('materialReceiveLog/{id}/log', 'LogController@materialReceiveLog')->name('materialReceiveLog');
    Route::get('supplierBillLog/{id}/log', 'LogController@supplierBillLog')->name('supplierBillLog');
    Route::get('storeissueLog/{id}/log', 'LogController@storeissueLog')->name('storeissueLog');
    Route::get('advanceadjustmentsLog/{id}/log', 'LogController@advanceadjustmentsLog')->name('advanceadjustmentsLog');
    Route::get('materialmovementLog/{id}/log', 'LogController@materialmovementLog')->name('materialmovementLog');
    Route::get('movementRequisitionLog/{id}/log', 'LogController@movementRequisitionLog')->name('movementRequisitionLog');
    Route::get('movementInLog/{id}/log', 'LogController@movementInLog')->name('movementInLog');
    Route::get('general-requisition-Log/{id}/log', 'LogController@generalRequisitionLog')->name('general-requisition-Log');
    Route::get('workPlanLog/{id}/log', 'LogController@workPlanLog')->name('workPlanLog');
    Route::get('materialPlanLog/{id}/log', 'LogController@materialPlanLog')->name('materialPlanLog');
    Route::get('workcsLog/{id}/log', 'LogController@workcsLog')->name('workcsLog');
    Route::get('workorderLog/{id}/log', 'LogController@workorderLog')->name('workorderLog');
    Route::get('constructionbillLog/{id}/log', 'LogController@constructionbillLog')->name('constructionbillLog');
    Route::get('tentativeBudgetLog/{year}/{id}/log', 'LogController@tentativeBudgetLog')->name('tentativeBudgetLog');
    Route::get('monthlyProgressReportLog/{id}/log', 'LogController@monthlyProgressReportLog')->name('monthlyProgressReportLog');
    Route::get('finalCostingLog/{id}/log', 'LogController@finalCostingLog')->name('finalCostingLog');
    Route::get('csdletterLog/{id}/log', 'LogController@csdletterLog')->name('csdletterLog');

});
