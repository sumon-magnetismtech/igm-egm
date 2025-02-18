<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class DeliveryOrderRequest extends FormRequest
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
        $moneyReceipt = Request::instance()->moneyrecept_id;
        return [
            'moneyrecept_id' => 'required|unique:deliveryorders,moneyrecept_id,'.$moneyReceipt,
            'BE_Date' => 'date_format:d/m/Y',
            'issue_date' => 'date_format:d/m/Y',
            'upto_date' => 'nullable|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return
        [
            'moneyrecept_id.unique' => 'The House B/L Number has already been taken.',
            'BE_Date.date_format' => 'The BE Date does not match the format d/m/Y.',
            'issue_date.date_format' => 'The Issue Date does not match the format d/m/Y.',
            'upto_date.date_format' => 'The Upto Date does not match the format d/m/Y.',
        ];
    }

}
