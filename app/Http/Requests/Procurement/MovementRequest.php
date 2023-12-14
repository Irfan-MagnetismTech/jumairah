<?php

namespace App\Http\Requests\Procurement;

use Illuminate\Foundation\Http\FormRequest;

class MovementRequest extends FormRequest {
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
			'mto_no'               => "required|unique:materialmovements,mto_no,$id",
			'transfer_date'        => 'required',
			'from_costcenter_name' => 'required',
			'project_name'         => 'required',
			'gate_pass'            => 'required|array',
			'gate_pass.*'          => 'required',
			'material_name'        => 'required|array',
			'material_name.*'      => 'required',
		];
	}
}
