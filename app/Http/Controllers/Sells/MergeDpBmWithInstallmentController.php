<?php

namespace App\Http\Controllers\Sells;

use App\Http\Controllers\Controller;
use App\Sells\Sell;
use Illuminate\Http\Request;

class MergeDpBmWithInstallmentController extends Controller
{
    public function MergeDpBmWithInstallment()
    {
        $sales = Sell::get();

        foreach ($sales as $key => $sale) {
            $installments[] = [
                'sequence' => '1',
                'installment_no' => 'BM',
                'sell_id' => $sale->id,
                'installment_date' => $sale->booking_money_date,
                'installment_amount' => $sale->booking_money,
                'installment_composite' => 'S'.$sale->id.'-BM',
                'created_at' => $sale->created_at,
                'updated_at' => $sale->updated_at,
            ];
            $installments[] = [
                'sequence' => '2',
                'installment_no' => 'DP',
                'sell_id' => $sale->id,
                'installment_date' => $sale->downpayment_date,
                'installment_amount' => $sale->downpayment,
                'installment_composite' => 'S'.$sale->id.'-DP',
                'created_at' => $sale->created_at,
                'updated_at' => $sale->updated_at,
            ];

            $sale->installmentList()->createMany($installments);
            dd($installments, $sale); 
        }
    }


    
}
