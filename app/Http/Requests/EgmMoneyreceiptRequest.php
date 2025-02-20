<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EgmMoneyreceiptRequest extends FormRequest
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

//        $client_name = Request::instance()->client_name;
//        $id = Request::instance()->id;
        return[
//            'hblno' => 'unique:moneyreceipts,hblno,'.$id.',id,client_name,' . $client_name,
        ];
    }
}
