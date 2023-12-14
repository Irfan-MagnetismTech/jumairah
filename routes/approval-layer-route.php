<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function ()
{

    Route::get('designationNameAutoSuggest', 'Procurement\SupplyChainJsonController@designationNameAutoSuggest')->name('designationNameAutoSuggest');

    Route::resources([
        'approval-layer' => 'Approval\ApprovalLayerController',
    ]);

});
