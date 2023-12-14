<?php

namespace App\Exports;

use App\LeadGeneration;
use Maatwebsite\Excel\Concerns\FromCollection;

class WeekWiseLeadGenerationExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LeadGeneration::all();
    }
}
