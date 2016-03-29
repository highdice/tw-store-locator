<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BranchRequest extends FormRequest
{
    public function rules() {
    	 return [
            'code' => 'required|max:250|unique:branch',
            'branch_code' => 'required|max:250|unique:branch',
            'trade_name' => 'required|min:6',
            'name' => 'required',
            'size' => 'required',
            'date_opened' => 'required|date',
            'address' => 'required',
            'zip_code' => 'integer',
            'region' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ];
    }
}
