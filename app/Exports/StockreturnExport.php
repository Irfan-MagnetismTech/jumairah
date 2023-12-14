<?php

namespace App\Exports;

use App\Stockreturn;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockreturnExport implements FromCollection,WithHeadings
{
    protected $fdate,$tdate,$reason;

    function __construct( $fdate,$tdate,$reason){
        $this->fdate = $fdate;
        $this->tdate = $tdate;
        $this->reason = $reason;
    }
    use Exportable;
    public function collection()
    {
        $fromDate = $this->fdate;
        $toDate = $this->tdate;
        $reasons = $this->reason;
        $stockreturns=Stockreturn::whereHas('stockout',function ($q) use($reasons){
            $q->where('reason','like',"%$this->reason%");
        })
            ->when($fromDate && $toDate, function($q)use($fromDate,$toDate){
                $q->whereBetween('date', [$fromDate,$toDate]);
            })
            ->latest()->get();
        //dd($stockreturns);
        foreach ($stockreturns as $key=>$stockreturn){
            $stockreturnArray[$key]= [
                'Stock Return ID'=> $stockreturn->id,
                'Date'=>$stockreturn->date,
//                'Quantity'=> $stockreturn->quantity,


            ];
        }
        return collect($stockreturnArray);
    }
    public function headings(): array
    {
        return [
            'Stock Out ID',
            'Date',
//            'Quantity',
            
        ];
    }
}
