<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
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
            'meeting_no'=>'sometimes|string|unique:meetings,meeting_no',
            'description' => 'nullable|string',
            'DateTime'=>'nullable|date'
        ];
    }
    public function messages(){
        return [
            'meeting_no.unique' => 'The meeting number must be unique.',
            'description.string' => 'Description must be a string',
            'DateTime.date' => 'Date must be a date',
        ];
    }
}
