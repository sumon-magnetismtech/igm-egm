<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class EgmMasterBlRequest extends FormRequest
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
            'cofficecode' => 'required',
            'cofficename' => 'required',
            'mblno' => 'required|unique:egm_master_bls,mblno,'.$id,
            'blnaturecode' => 'required',
            'blnaturetype' => 'required',
            'bltypecode' => 'required',
            'bltypename' => 'required',
            'fvessel' => 'required',
            'voyage' => 'required',
            'principal' => 'required',
            'departure' => 'required|date_format:d/m/Y',
            'arrival' => 'required|date_format:d/m/Y',
            'berthing' => 'nullable|date_format:d/m/Y',
            'pocode' => 'required',
            'poname' => 'required',
            'pucode' => 'required',
            'puname' => 'required',
            'carrier' => 'required',
            'carrieraddress' => 'required',
        ];
    }
    public function messages()
    {
        return
            [
                'mblno.unique' => 'The Master B/L No has already been taken.',
                'departure.date_format' => 'The Departure Date does not match the format d/m/Y.',
                'arrival.date_format' => 'The Arrival Date does not match the format d/m/Y.',
                'berthing.date_format' => 'The Berthing Date does not match the format d/m/Y.',
            ];
    }
}
