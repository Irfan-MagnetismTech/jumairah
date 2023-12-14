<?php

namespace Database\Seeders;

use App\SellCollectionHead;
use Illuminate\Database\Seeder;

class SellCollectionHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentTypes = ['Booking Money','Down Payment','Installment','Delay Charge','Registration Charge','Modification Cost','Service Charge','Size Increased Cost'];

        foreach($paymentTypes as $paymentType){
            SellCollectionHead::create(['name' => $paymentType]);
        }

    }
}
