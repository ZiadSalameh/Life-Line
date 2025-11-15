<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectProposalRequest extends FormRequest
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
           'office_id' => 'required|exists:offices,id',
           'request_no' => 'required',
           'requset_date' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'office_id.required' => 'The office ID is required.',
            'office_id.exists' => 'The office ID does not exist.',
            'request_no.required' => 'The request number is required.',
        ];
    }
}
