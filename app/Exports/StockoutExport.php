<?php

namespace App\Exports;

use App\Stockout;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockoutExport implements FromCollection, WithHeadings
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
        $stockouts=Stockout:: where('reason','like',"%$this->reason%")
            ->when($fromDate && $toDate, function($q)use($fromDate,$toDate){
                $q->whereBetween('date', [$fromDate,$toDate]);
            })->latest()->get();
        foreach ($stockouts as $key=>$stockout){
            $stockoutArray[$key]= [
                'Stock Out ID'=> $stockout->id,
                'Date'=>$stockout->date,
                'Reason'=> $stockout->reason,
                'Location'=> $stockout->warehouse->name,
                'Issued To'=> $stockout->issued_to,
                'Issued Name'=> $stockout->issued_to_id,
            ];
        }
        return collect($stockoutArray);
    }
    public function headings(): array
    {
        return [
            'Stock Out ID',
            'Date',
            'Reason',
            'Location',
            'Issued To',
            'Issued Name',
        ];
    }
}
