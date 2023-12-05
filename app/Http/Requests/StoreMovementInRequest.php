<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementInRequest extends FormRequest {
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
			'mti_no'         => "required|unique:movement_ins,mti_no,$id",
			'mto_no'         => 'required',
			'receive_date'   => 'required',
			'mti_quantity'   => 'required|array',
			'mti_quantity.*' => 'required',
		];
	}
}
