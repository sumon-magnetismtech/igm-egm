<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffdockRequest extends FormRequest
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
        $id = request('id');
        return [
            'code' => "required|max:30|unique:offdocks,code,$id",
            'name' => "required|max:255",
            'location' => 'max:255',
            'phone' =>'max:255'
        ];
    }
}
