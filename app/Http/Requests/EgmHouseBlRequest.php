<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EgmHouseBlRequest extends FormRequest
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
            'igm' => 'required',
            'mblno' => 'required',
            'vesselname' => 'required',
            'voyage' => 'required',
            'nature' => 'required',
            'punloading' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'cofficecode' => 'required',
            'line' => 'required',
            'bolreference' => 'required|max:17|unique:egm_house_bls,bolreference,'.$id,
            'exportername' => 'required',
            'exporteraddress' => 'required',
            'consigneebin' => 'required',
            'consigneename' => 'required',
            'consigneeaddress' => 'required',
            'notifybin' => 'required',
            'notifyname' => 'required',
            'notifyaddress' => 'required',
            'shippingmark' => 'required',
            'packageno' => 'required|numeric',
            'packagecode' => 'required',
            'packagetype' => 'required',
            'description' => 'required',
            'grosswt' => 'required',
            'measurement' => 'required',
            'containernumber' => 'required',
        ];
    }
}
