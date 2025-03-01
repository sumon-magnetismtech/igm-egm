<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EgmMloDeliveryOrderRequest extends FormRequest
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
        $id = Request::instance()->id;
        return [
            'mlo_money_receipt_id' => "required|unique:egm_mlo_deliveryorders,mlo_money_receipt_id,$id,id",
            'DO_Date' => 'required|date_format:d/m/Y',
            'BE_No' => 'required',
            'BE_Date' => 'required|date_format:d/m/Y',
        ];
    }

    public function messages()
    {
        return [
            'mlo_money_receipt_id.required' => 'Money Receipt ID is required',
            'DO_Date.required' => 'DO Date is required',
            'BE_No.required' => 'BE No is required',
            'BE_Date.required' => 'BE Date is required',
            'mlo_money_receipt_id.unique' => 'The B/L has already been taken.',
            'DO_Date.date' => 'The DO Date is not a valid date.',
            'BE_Date.date' => 'The BE Date is not a valid date.',
        ];
    }
}
