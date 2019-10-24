<?php

namespace Directoryxx\Finac\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssetUpdate extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'active' => 'required',
            'code' => 'required',
            'name' => 'required',
            'group' => 'required',
            'manufacturername' => 'required',
            'brandname' => 'required',
            'modeltype' => 'required',
            'productiondate' => 'required',
            'serialno' => 'required',
            'warrantystart' => 'required',
            'warrantyend' => 'required',
            'ownership' => 'required',
            'location' => 'required',
            'pic' => 'required',
            'grnno' => 'required',
            'pono' => 'required',
            'povalue' => 'required',
            'salvagevalue' => 'required',
            'supplier' => 'required',
            'fixedtype' => 'required',
            'usefullife' => 'required',
            'depreciationstart' => 'required',
            'depreciationend' => 'required',
            'coaacumulated' => 'required',
            'coaexpense' => 'required',
            'usestatus' => 'required',
            'description' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()]));
    }
}
