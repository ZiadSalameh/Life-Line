<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreElementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'element_name' => 'required|string|unique:elements,element_name',
            'description' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'element_name.required' => 'The element name is required.',
            'element_name.unique' => 'The element name must be unique.',
        ];
    }
}
