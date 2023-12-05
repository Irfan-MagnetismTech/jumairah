<?php

namespace App\Http\Requests\Boq\Eme;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckParentChildCombinedUniqueArray;
use App\Boq\Departments\Eme\BoqEmeLoadCalculationDetails;
class BoqEmeLoadcalculationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        
        $floor_id = $this->floor_id;
        $material_id = $this->material_id;
        $material_floor = [];
        foreach ($material_id as $key => $value) {
            $material_floor[] = $value . '_' . $floor_id[$key] ?? 0;
        }
        $this->merge([
            'material_floor' => $material_floor,
        ]);
        }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project_id = request()->project_id;
        $project_type = request()->project_type;
        $calculation_type = request()->calculation_type;
        $skip_id = request()->id;
        return [
            //
            'project_type'      => "required|unique:boq_eme_load_calculations,project_type,$skip_id,id,project_id,$project_id,calculation_type,$calculation_type",
            'calculation_type'  => "required|unique:boq_eme_load_calculations,calculation_type,$skip_id,id,project_id,$project_id,project_type,$project_type",
            'material_floor.*'  => ['required', 'distinct'],
            'material_id.*'     => ['required'],
            'project_id'        => ['required'],
            'material_name'     => 'required|array',
            'material_name.*'   => 'required',
            'unit'              => 'required|array',
            'unit.*'            => 'required',
            'load'              => 'required|array',
            'load.*'            => 'required',
            'qty'               => 'required|array',
            'qty.*'             => 'required',
            'demand_percent'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'project_type.unique'        => 'The Project Type for this calculation type already been taken',
            'project_type.required'      => 'You must specify a project type',
            'calculation_type.unique'    => 'The Calculation Type for this Project type already been taken',
            'calculation_type.required'  => 'You must specify a calculation type',
            'project_id.required'       => 'You Must search a Project',
            'material_id.*.required'     => 'You Must search a material',
            'material_id.required'     => 'You Must search a material',
            'material_name.required'     => 'You Must search a material',
            'material_name.*.required'   => 'You Must search a material',
            'qty.required'               => 'Quantity is required',
            'qty.*.required'             => 'Quantity is required',
            'material_floor.*.distinct'  => 'A floor can not have same material more than one',
            'demand_percent'             => 'Demand is required',
        ];
    }
}
