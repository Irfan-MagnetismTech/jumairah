<?php

use App\Http\Controllers\Procurement\MovementRequisitionController;
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

    Route::group(['middleware'=>'auth'], function(){
    Route::get('getHeadTypes/{head_type_id}', 'Accounts\AccountsJsonController@getHeadTypes');
    Route::get('loadLoanSourceNames/{loanable_type}', 'Accounts\AccountsJsonController@loadLoanSourceNames');
    Route::post('bankAutoSuggest', 'Accounts\AccountsJsonController@bankAutoSuggest')->name('bankAutoSuggest');
    Route::post('sundryCreditorAutoSuggest', 'Accounts\AccountsJsonController@sundryCreditorAutoSuggest')->name('sundryCreditorAutoSuggest');
    Route::post('costCenterAutoSuggest', 'Accounts\AccountsJsonController@costCenterAutoSuggest')->name('costCenterAutoSuggest');
    Route::post('linesAutoSuggest', 'Accounts\AccountsJsonController@linesAutoSuggest')->name('linesAutoSuggest');
    Route::get('loadBillAmount/{bill_no}', 'Accounts\AccountsJsonController@loadBillAmount')->name('loadBillAmount');
    Route::get('unpaidBill/{account_id}/{project_id}', 'Accounts\AccountsJsonController@unpaidBill')->name('unpaidBill');
    Route::get('unpaidBill/{account_id}', 'Accounts\AccountsJsonController@unpaidBillbySupplier')->name('unpaidBillbySupplier');
    Route::get('bank-reconciliations-pdf', 'Accounts\BankReconciliationController@bankReconciliationsPdf')->name('bank-reconciliations-pdf');
    Route::get('loadAssetInfo/{asset_id}', 'Accounts\AccountsJsonController@loadAssetInfo')->name('loadAssetInfo');
    Route::get('bank-loan-statement', 'Accounts\AisReportController@bankLoanStatement')->name('bank-loan-statement');
    Route::get('get-salary-allocation-cost/{month}', 'Accounts\AccountsJsonController@getSalaryAllocationCost')->name('get-salary-allocation-cost');
    Route::get('get-allocation-cost/{month}', 'Accounts\AccountsJsonController@getAllocationCost')->name('get-allocation-cost');
    Route::get('get-allocation-salary/{month}', 'Accounts\AccountsJsonController@getAllocationSalary')->name('get-allocation-salary');
    Route::get('allocation-loan-interest/{frommonth}/{tomonth}', 'Accounts\AccountsJsonController@getLoanInterest')->name('allocation-loan-interest');
    Route::get('allocation-approval/{allocation}', 'Accounts\AllocationController@allocationApproval')->name('allocation-approval');
    Route::get('salary-approval/{id}', 'Accounts\SalaryController@salaryApproval')->name('salary-approval');
    Route::get('salary-allocation-approval/{salaryAllocate}', 'Accounts\SalaryAllocateController@allocationApproval');
    Route::get('financial-allocations-approval/{financial_allocation}/{status}', 'Accounts\FinancialAllocationController@financialAllocationApproval');
    Route::get('loan-info/{id}', 'Accounts\AccountsJsonController@getLoanInfo')->name('loan-info');
    Route::get('parent-account/{balance_line_id}', 'Accounts\AccountsJsonController@loadAccountParent')->name('parent-account');
    Route::get('account-list', 'AccountController@accountList')->name('account-list');
    Route::get('get-depreciation-assets/{month}', 'Accounts\AccountsJsonController@getDepreciationAssets')->name('get-depreciation-assets');

    Route::post('get-mrr-no', 'Accounts\AccountsJsonController@getMRRInfo')->name('get-mrr-no');
    Route::get('get-project-available-stock/{costcenter}/{material}', 'Accounts\AccountsJsonController@getProjectAvailableMaterial')->name('get-project-available-stock');
    Route::get('movement-requisitions/approved/{movementRequisitions}/{status}', 'Procurement\MovementRequisitionController@movmentRequisitionApproval');
    Route::post('mtrfAutoSuggust', 'Accounts\AccountsJsonController@mtrfAutoSuggust')->name('mtrfAutoSuggust');
    Route::get('getMovementRequiestionInfo/{movementRequisitions}', 'Accounts\AccountsJsonController@getMovementRequiestionInfo')->name('getMovementRequiestionInfo');
    Route::get('getMTRFInfobyMaterial/{movementRequisitions}/{material_id}', 'Accounts\AccountsJsonController@getMTRFInfobyMaterial')->name('getMTRFInfobyMaterial');
    Route::get('getMTOInfobyMaterial/{movementRequisitions}/{material_id}/{mto}', 'Accounts\AccountsJsonController@getMTOInfobyMaterial')->name('getMTOInfobyMaterial');
    Route::get('materialmovment/approved/{materialmovement}/{status}', 'Procurement\MaterialmovementController@movmentOutApproval');
    Route::get('movementIns/approved/{movementIn}/{status}', 'Procurement\MovementInController@movmentInApproval');
    Route::get('loadMTRFProjectWise/{from_project}/{to_project}', 'Accounts\AccountsJsonController@loadMTRFProjectWise');
    Route::post('mtoAutoSuggust', 'Accounts\AccountsJsonController@mtoAutoSuggust')->name('mtoAutoSuggust');
    Route::get('loadMTRFmtoWise/{mto_no}', 'Accounts\AccountsJsonController@loadMTRFmtoWise');

    Route::prefix('accounts')->group(function () {
        Route::resources([
            'vouchers' => 'Accounts\VoucherController',
            'account-opening-balances' => 'Accounts\AccountsOpeningBalanceController',
            'interCompanies' => 'Accounts\InterCompanyController',
            'loans' => 'Accounts\LoanController',
            'bankAccounts' => 'Accounts\BankAccountController',
            'cashAccounts' => 'Accounts\CashAccountController',
            'vehicles' => 'Accounts\VehicleController',
            'bank-reconciliations' => 'Accounts\BankReconciliationController',
            'loan-receipts' => 'Accounts\LoanReceiptController',
            'fixed-assets' => 'Accounts\FixedAssetController',
            'depreciations' => 'Accounts\DepreciationController',
            'salaries' => 'Accounts\SalaryController',
            'salary-heads' => 'Accounts\SalaryHeadController',
            'allocations' => 'Accounts\AllocationController',
            'salary-allocates' => 'Accounts\SalaryAllocateController',
            'financial-allocations' => 'Accounts\FinancialAllocationController',
            'cash-flow-line-assignments' => 'Accounts\SalaryAllocateController',

        ]);
    });

    Route::resource('balance-and-income-lines', BalanceAndIncomeLineController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('cash-flow-lines', CashFlowLineController::class);
    Route::resource('admin-yearly-budgets', 'Accounts\AdminYearlyBudgetController');
    Route::match(['get', 'post'],'admin-yearly-budgets-report', 'Accounts\AdminYearlyBudgetController@adminYearlyBudgetReport')->name('admin-yearly-budgets-report');
    Route::match(['get', 'post'],'admin-monthly-budgets-report', 'Accounts\AdminMonthlyBudgetController@adminMonthlyBudgetReport')->name('admin-monthly-budgets-report');
    Route::resource('admin-monthly-budgets', 'Accounts\AdminMonthlyBudgetController');


    Route::resource('movement-requisitions', 'Procurement\MovementRequisitionController');
    Route::resource('movement-ins', 'Procurement\MovementInController');

    Route::get('accountsRefCode/{account_id}', 'AccountController@accountsRefCode');
    Route::get('accounts-ref-generator/{balanceIncomeLineId}', 'AccountController@AccountsRefGenerator');

    //AIS Reports
    Route::get('day-book', "Accounts\AisReportController@daybook")->name('day-book');
    Route::get('ledgers', "Accounts\AisReportController@ledger")->name('ledgers');
    Route::get('trial-balance', "Accounts\AisReportController@trialBalance")->name('trial-balance');
    Route::get('balancesheet', "Accounts\AisReportController@balanceSheet")->name('balancesheet');
    Route::get('income-statement', "Accounts\AisReportController@incomeStatement")->name('income-statement');
    Route::get('cost-center-summary', "Accounts\AisReportController@costCenterSummary")->name('cost-center-summary');
    Route::get('cost-center-breakup', "Accounts\AisReportController@costCenterBreakup")->name('cost-center-breakup');
    Route::get('fixed-asset-statment', 'Accounts\AisReportController@fixedAssetStatment')->name('fixed-asset-statment');

    Route::get('projects-wip', "Accounts\AisReportController@projectsWip")->name('projects-wip');
    Route::get('balance-income-line-report', "Accounts\AisReportController@balanceIncomeLineReport")->name('balance-income-line-report');
    Route::get('pending-bills', "Accounts\AisReportController@PendingBills")->name('pending-bills');
    Route::get('cash-flow-statement', "Accounts\AisReportController@cashFlowStatement")->name('cash-flow-statement');
    Route::get('receipt-payment-statement', "Accounts\AisReportController@receiptPaymentStatement")->name('receipt-payment-statement');

    //MIS report
    Route::get('mis-correction', "Accounts\MisReportController@misCorrection")->name('mis-correction');
    Route::get('mis-summary', "Accounts\MisReportController@misSummary")->name('mis-summary');
    Route::get('mis-hr-report', "Accounts\MisReportController@misHrReport")->name('mis-hr-report');
    Route::get('budget-cash-flow', "Accounts\MisReportController@budgetCashFlow")->name('budget-cash-flow');
    Route::get('budget-comparison-statement', "Accounts\MisReportController@budgetComparisonStatement")->name('budget-comparison-statement');

});
