<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class EgmFeederVesselRequest extends FormRequest
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
        $departureDate = \Illuminate\Support\Facades\Request::instance()->departureDate;
        $checkData = date('yy-m-d', strtotime($departureDate));

        $id = \Illuminate\Support\Facades\Request::instance()->id;
        return [
            'feederVessel' => 'required|unique:egm_feederinformations,feederVessel,' . $id . ',id,departureDate,' . $checkData,
            'departureDate' => 'required|date_format:d/m/Y',
            'arrivalDate' => 'nullable|date_format:d/m/Y',
            'berthingDate' => 'nullable|date_format:d/m/Y',
            'voyageNumber' => 'required',
            'COCode' => 'required',
            'COName' => 'required',
            'careerName' => 'required',
            'careerAddress' => 'required',
            'mtCode' => 'required',
            'mtType' => 'required',
            'transportNationality' => 'required|size:2',
            'depot' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'feederVessel.required' => 'Feeder Vessel Name is required.',
            'departureDate.required' => 'Departure Date is required',
            'departureDate.date_format' => 'Departure Date does not match the format d/m/Y.',
            'arrivalDate.date_format' => 'Arrival Date does not match the format d/m/Y.',
            'berthingDate.date_format' => 'Berthing Date does not match the format d/m/Y.',
            'voyageNumber.required' => 'Voyage Number is required',
            'COCode.required' => 'CO Code is required',
            'COName.required' => 'Name is required',
            'rotationNo.required' => 'Rotation Number is required',
            'careerName.required' => 'Career Name is required',
            'careerAddress.required' => 'Career Address required',
            'mtCode.required' => 'MT Code is required',
            'mtType.required' => 'MT Type is required',
            'transportNationality.required' => 'Transport Nationality is required',
            'transportNationality.size' => 'Transport nationality must be 2 characters.',
            'depot.required' => 'Depot is required',
        ];
    }
}
