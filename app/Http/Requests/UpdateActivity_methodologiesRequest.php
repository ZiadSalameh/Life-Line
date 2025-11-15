<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivity_methodologiesRequest extends FormRequest
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
            'projectproposal_id' => 'required|exists:project_proposals,id',
            'activity_methodology_name' => 'sometimes',
            'proposed_implementation_period' => 'nullable',
            'logistical_requirements' => 'nullable',
            'outputs' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'projectproposal_id.required' => 'The project proposal ID is required.',
            'projectproposal_id.exists' => 'The project proposal ID does not exist.',
        ];
    }
}
