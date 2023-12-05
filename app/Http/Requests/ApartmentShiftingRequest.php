<?php

namespace App\Http\Requests;

use App\Sells\Sell;
use Illuminate\Foundation\Http\FormRequest;

class ApartmentShiftingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $skip_id = request()->id;
        $sale = Sell::where('id',request()->sale_id)->first();
        $old_apartment_id = $sale->apartment_id;
        return [
            'sale_id' => 'unique:apartment_shiftings','sale_id',"$skip_id",'id','old_apartment_id',"$old_apartment_id",
        ];
    }
}
