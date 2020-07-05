<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateListing extends FormRequest
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
        return [
            'name' => 'required|string',
            'description' => 'required|string|min:5',
            'url' => 'string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string',
            'images.*' => 'required|image',
            'categories' => 'required'
        ];
    }
}
