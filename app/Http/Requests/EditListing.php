<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditListing extends FormRequest
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
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string|min:5',
            'url' => 'sometimes|string',
            'phone' => 'sometimes|required|string',
            'email' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'images.*' => 'sommetimes|image|nullable',
            'categories' => 'sometimes|required',
            'published' => 'sometimes|required|boolean'
        ];
    }
}
