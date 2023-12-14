<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MaterialReceiveRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $id = request()->id;
        if(request()->mrr_type == 'withOutIou'){
            return [
                'po_no'=>"required",
                'cost_center_id'=>"required",
                'mrr_no'=> "required|unique:material_receives,mrr_no,$id",
                'date'=>"required|date|date_format:d-m-Y",
                'material_id'=>"required|array",
                'quantity'=>"required|array",
                'challan_no'=>"required|array",
            ];
        }else{
            return [
                'with_iou_cost_center_id'=>"required",
                'mrr_no'=> "required|unique:material_receives,mrr_no,$id",
                'date'=>"required|date|date_format:d-m-Y",
                'with_iou_material_id'=>"required|array",
                'with_iou_material_id.*'=>"required",
                'with_iou_material_qty'=>"required|array",
                'with_iou_material_qty.*'=>"required",
                'purpose'=>"required|array",
                'purpose.*'=>"required",
                'rate' => "required|array",
                'rate.*' => "required",
            ];
        }
        
    }
}
