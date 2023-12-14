<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequisitionRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
        $id = request()->id;
		return [
			'mtrf_no'              => "required|unique:movement_requisitions,mtrf_no,$id",
			'date'                 => 'required',
			'delivery_date'        => 'required',
			'from_costcenter_name' => 'required',
			'project_name'         => 'required',
			'material_name'        => 'required|array',
			'material_name.*'      => 'required',
			'quantity'             => 'required|array',
			'quantity.*'           => 'required',
		];
	}
}
