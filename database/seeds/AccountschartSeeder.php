<?php

namespace Database\Seeders;

use App\Accounts\Accountschart;
use Illuminate\Database\Seeder;

class AccountschartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountscharts = [
            ['Asset', 'Cash'],
            ['Asset', 'Accounts Receivable'],
            ['Asset', 'Prepaid Expenses'],
            ['Asset', 'Inventory'],
            ['Asset', 'Fixed Assets'],
            ['Asset', 'Accumulated Depreciation'],
            ['Asset', 'Other Assets'],

            ['Liability', 'Accounts Payable'],
            ['Liability', 'Accrued Liabilities'],
            ['Liability', 'Taxes Payable'],
            ['Liability', 'Payroll Payable'],
            ['Liability', 'Notes Payable'],

            ['Equity', 'Common Stock'],
            ['Equity', 'Retained Earnings'],
            ['Equity', 'Additional Paid in Capital'],

            ['Revenue', 'Revenue'],
            ['Revenue', 'Sales returns and Allowances'],

            ['Expense', 'Cost of Goods Sold'],
            ['Expense', 'Advertising Expense'],
            ['Expense', 'Bank Fees'],
            ['Expense', 'Depreciation Expense'],
            ['Expense', 'Payroll Tax Expense'],
            ['Expense', 'Rent Expense'],
            ['Expense', 'Supplies Expense'],
            ['Expense', 'Utilities Expense'],
            ['Expense', 'Wages Expense'],
            ['Other', 'Other Expense'],
        ];

        foreach($accountscharts as $key => $accountschart){
//            dd($accountschart);

            Accountschart::create(
            [
                'account_type' => $accountschart[0],
                'name' => $accountschart[1],
            ]);
        }


    }
}
