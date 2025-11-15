<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
            'objective_id' => 'required|exists:objectives,id',
            'activity_name' => 'required',
            'expected_outcome' => 'nullable',
            'brief_project' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'objective_id.required' => 'The objective ID is required.',
            'objective_id.exists' => 'The objective ID does not exist.',
            'activity_name.required' => 'The activity name is required.',
        ];
    }
}
