<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class VatregRequest extends FormRequest
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
            'BIN' => 'required|unique:vatregs,BIN,'.$id,
            'NAME' => 'required',
            'ADD1' => 'required',
//            'EMAIL' => 'email',
        ];
    }

    public function messages()
    {
        return [
            'BIN.required' => "The BIN is required",
            'BIN.unique' => "The BIN has already been taken.",
            'NAME.required' => 'The Name is required',
            'ADD1.required' => 'The Address is required',
//            'EMAIL.email' => 'The Email must be a valid email address.',
        ];

    }
}
