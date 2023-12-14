<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Boq\Departments\Civil\BoqCivilJsonController;
use App\Http\Controllers\Boq\Departments\Electrical\Configurations\BoqEmeItemController;

/*
|--------------------------------------------------------------------------
| BOQ Web Routes
|--------------------------------------------------------------------------
|
| All the BOQ related web routes are defined here.
|
 */

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('mytest', function (){
        return 'sdfs';
    });

//    Route::get('/', \Boq\Departments\Sanitary\BoqSanitaryHomeController::class)->name('home');
});
