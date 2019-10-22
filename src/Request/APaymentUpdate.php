<?php

namespace Directoryxx\Finac\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class APaymentUpdate extends FormRequest
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
			'id_branch' => 'required',
			'approve' => 'required',
			'transactionnumber' => 'required',
			'transactiondate' => 'required',
			'id_supplier' => 'required',
			'accountcode' => 'required',
			'refno' => 'required',
			'currency' => 'required',
			'exchangerate' => 'required',
			'totaltransaction' => 'required',
			'description' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(
			response()->json(['errors' => $validator->errors()])
		);
    }
}
