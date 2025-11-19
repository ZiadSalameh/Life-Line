<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMeetingRequest extends FormRequest
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
            // 'meeting_no' => 'required|string|unique:meetings,meeting_no',
            'meeting_no' => ['required', Rule::unique('meetings')->where('id', $this->input('id'))],
            'description' => 'nullable|string',
            'DateTime' => 'nullable|date'   
        ];
    }
    
    public function messages()
    {
        return [
            'meeting_no.required' => 'Meeting number is required',
            'meeting_no.unique' => 'Meeting number must be unique',
            'description.string' => 'Description must be a string',
            'DateTime.date' => 'Date must be a date',
        ];
    }
    
}
