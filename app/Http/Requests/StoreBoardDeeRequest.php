<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBoardDeeRequest extends FormRequest
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
            'board_no' => 'required|integer|unique:board_dees,board_no',
            'meeting_id' => 'required|exists:meetings,id',
            'description' => 'nullable|string',
            'voted' => 'nullable|boolean',
            'boar_dee_date' => 'nullable|date',
            'meeting_id' => 'required|integer|exists:meetings,id'
        ];
    }

    public function messages()
    {
        return [
            'board_no.required' => 'The board number is required.',
            'board_no.unique' => 'The board number must be unique.',
            'meeting_id.required' => 'The meeting ID is required.',
            'meeting_id.exists' => 'The meeting ID does not exist.',
        ];
    }
}
