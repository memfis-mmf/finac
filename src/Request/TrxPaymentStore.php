<?php

namespace Directoryxx\Finac\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TrxPaymentStore extends FormRequest
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
			'closed' => 'required',
			'transaction_number' => 'required',
			'transaction_date' => 'required',
			'x_type' => 'required',
			'id_supplier' => 'required',
			'currency' => 'required',
			'exchange_rate' => 'required',
			'discount_percent' => 'required',
			'discount_value' => 'required',
			'ppn_percent' => 'required',
			'ppn_value' => 'required',
			'grandtotal_foreign' => 'required',
			'grandtotal' => 'required',
			'account_code' => 'required',
			'description' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(
			response()->json(['errors' => $validator->errors()])
		);
    }
}
