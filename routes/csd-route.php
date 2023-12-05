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


Route::group(['middleware' => 'auth', 'prefix' => 'csd', 'as' => 'csd.'], function ()
{
    Route::post('projectAutoSuggest', 'Procurement\ProcurementAutoSuggestController@projectAutoSuggest')->name('projectAutoSuggest');
    Route::post('csdMaterialAutoSuggest', 'Procurement\ProcurementAutoSuggestController@csdMaterialAutoSuggest')->name('csdMaterialAutoSuggest');
    Route::post('csdMaterialAutoSuggestWithRate', 'Procurement\ProcurementAutoSuggestController@csdMaterialAutoSuggestWithRate')->name('csdMaterialAutoSuggestWithRate');
    Route::post('LoadclientName', 'Procurement\ProcurementAutoSuggestController@LoadclientName')->name('LoadclientName');
    Route::get('project-List', 'CSD\FinalCostingController@projectList')->name('project-List');
    Route::get('apartment-List/{project_id}', 'CSD\FinalCostingController@apartmentList')->name('apartment-List');
    Route::get('apartment-final-costing-details/{costing_id}', 'CSD\FinalCostingController@apartmentCostingDetails')->name('apartment-final-costing-details');
    Route::get('csd-final-costing-pdf/{costing_id}', 'CSD\FinalCostingController@pdf')->name('csd-final-costing-pdf');
    Route::get('csd-approval/{costing_id}', 'CSD\FinalCostingController@csdApproval')->name('csd-approval');
    Route::get('audit-approval/{costing_id}', 'CSD\FinalCostingController@auditApproval')->name('audit-approval');
    Route::get('ceo-approval/{costing_id}', 'CSD\FinalCostingController@ceoApproval')->name('ceo-approval');
    Route::get('csd_approval/{costing_id}/{status}', 'CSD\FinalCostingController@csd_Approved')->name('csd_approval');

    Route::get('getAddressByClient/{sell_id}', 'Procurement\ProcurementAutoSuggestController@getAddressByClient')->name('getAddressByClient');
    Route::get('csd-letter-pdf/{id}', 'CSD\CsdLetterController@pdf')->name('csd-letter-pdf');
    Route::get('send-mail/{id}', 'CSD\CsdLetterController@sendMail')->name('send-mail');
    Route::get('mail-records', 'CSD\CsdLetterController@mailRecords')->name('mail-records');

    
        Route::resources([
        'materials'                   => 'CSD\CsdMaterialController',            
        'material_rate'               => 'CSD\CsdMaterialRateController',            
        'costing'                     => 'CSD\FinalCostingController',       
        'letter'                      => 'CSD\CsdLetterController'          
    ]);
});