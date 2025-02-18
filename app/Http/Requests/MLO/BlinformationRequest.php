<?php

namespace App\Http\Requests\MLO;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class BlinformationRequest extends FormRequest
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
            'bolreference' => 'required|max:17|unique:mloblinformations,bolreference,'.$id,
            'feederinformations_id' => 'required',
            'line' => 'required',
            'pOrigin' => 'required',
            'pOriginName' => 'required',
            'PUloding' => 'required',
            'unloadingName' => 'required',
            'exportername' => 'required',
            'exporteraddress' => 'required',
            'consignee_id' => 'required',
            'notify_id' => 'required',
            'mlocode' => 'required',
            'mloname' => 'required',
            'blnaturecode' => 'required',
            'blnaturetype' => 'required',
            'bltypecode' => 'required',
            'bltypename' => 'required',
            'shippingmark' => 'required',
            'packageno' => 'required|numeric',
            'package_id' => 'required',
            'description' => 'required',
            'grosswt' => 'required',
            'measurement' => 'required',

            'containernumber' => 'required',
            'principal' => 'required',

        ];

    }

}
