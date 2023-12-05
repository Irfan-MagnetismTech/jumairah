<?php

namespace Database\Seeders;

use App\Config\BudgetHead;
use Illuminate\Database\Seeder;

class BudgetHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budgetHeads = [
             'Office Repair & Maintenance',
             'Cleanning Materials (Head office)',
             'Covid-19 Safety',
             'AC Repair & Maintenance',
             'Head Office Electricity, common electricity, wasa bill, Fuel & service charge',
             'Crockeries & Utensils',
             'Office Entertainment',
             'Rent & Maintenance',
             'Garda Shield Security Service in H/O',
             'Tour & Travilling',
             'Conveyance (Mgt)',
             'Head Office Petty Cash',
             'Recruitment advertisement/HR Promotion/ Job Fair',
             'Training & Workshops',
             'Reward & Recognition',
             'Staff',
             'Employee Refreshment events',
             'Chittagong Club Membership Fees',
             'Office Stationary',
             'Printing items',
             'Green pad papaers',
             'Vehicle Fuel',
             'Vehicle Maintenance',
             'Vehicle Parking Expense',
             'Vehicle Documents Renewal with BRTA',
             'Employee Marriage Gift',
             'MG-16 seater purchase',
             'Existing-Management (RFPL) salary',
             'Annual Increment',
             'Recruitment',
             'Existing -Contractual & Casual salary',
             'Recruitment',
             'Festival Bonus',
             'Performance Bonus',
             'Final Settlement',
             'Long Term Service Benefit',
             'Providend Fund (Employeers Contribution)',
             'Fuel Allowance',
             'Chauffer Allowance',
             'Car Maintenance Allowance',
             'Company Subsidy (Lunch)',
             'Mobile Bill',
             'Dividend',
             'Space Purchase',
             'Architect Fee',
             'Divisional Exp',
             'Management Fee',
             'Refund aganist Cancelled Apartment',
             'Guarda Shield',
             'TDS',
             'Bank Payment',
             'Site Exp',
             'Other',
             'Reallocation Allowance',
             'Land Tax',
             'Space Purchase',
             'After CDA plan approval',
             'Signing Money',
             'Registration',
             'Legal Opinion & Survey'
        ];
        foreach($budgetHeads as $budgetHead){
            BudgetHead::create(['name' => $budgetHead]);
        }
    }
}
