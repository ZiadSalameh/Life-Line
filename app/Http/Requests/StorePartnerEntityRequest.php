<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerEntityRequest extends FormRequest
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
            'name' => 'required',
            'qualification_field_work' => 'nullable',
            'role_responsibility' => 'nullable',
            'projectproposal_id' => 'required|exists:project_proposals,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'projectproposal_id.required' => 'The project proposal ID is required.',
            'projectproposal_id.exists' => 'The project proposal ID does not exist.',
        ];
    }
}
