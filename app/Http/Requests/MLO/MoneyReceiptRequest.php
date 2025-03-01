<?php

namespace App\Http\Requests\MLO;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class MoneyReceiptRequest extends FormRequest
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
        $fromDate = Request::instance()->fromDate;

        return [
            'client_id' => "required",
            'payMode' => 'required',
            'issueDate' =>'required|date_format:d/m/Y',
            'uptoDate' =>'required|date_format:d/m/Y',
            'bolRef' => 'required|unique:egm_mlo_money_receipts,bolRef,'.$id.',id,fromDate,'.Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d'),
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => "Client Name need to select from list.",
            'payMode.required' => 'Payment Type is required.',
            'issueDate.required' =>'Issue Date is required.' ,
            'bolRef.required' => 'bol Reference is required.',
            'issueDate.date_format' => 'The BE Date does not match the format d/m/Y.',
            'uptoDate.date_format' => 'The Upto Date does not match the format d/m/Y.',
            'bolRef.unique' => "The B/L Reference has already been taken alongwith the given From Date."
        ];
    }
}
