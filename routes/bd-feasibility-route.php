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


Route::middleware('auth')->prefix('feasibility')->as('feasibility.')->group(function ()
{
    // Location routes
    Route::prefix('location/{location}')->as('location.')->group(function ()
    {
        Route::get('', [\App\Http\Controllers\BD\BdFeasibilityLocationController::class, 'dashboard'])->name('dashboard');
        Route::resource('/site-expense', \BD\BdFeasibilitySiteExpenseController::class);
        Route::resource('/far', \BD\BdFeasibilityFarController::class);
        Route::resource('/permission-fees-ors', \BD\BdFeasibilityPermissionFeesOrsController::class);
        Route::resource('/sub-and-generator', \BD\BdFeasibilitySubAndGeneratorController::class);
    });

}); 