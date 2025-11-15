<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardDeeRequest extends FormRequest
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
            'boar_dee_date' => 'nullable|date',
            'board_no' => 'sometimes|integer|unique:board_dees,board_no', // must add unique
            'description' => 'nullable|string',
            'voted' => 'nullable|string',
            'meeting_id' => 'sometimes|integer|exists:meetings,id'
        ];
    }

    public function messages()
    {
        return [
            'board_no.unique' => 'The board number must be unique.',
            'meeting_id.required' => 'The meeting ID is required.',
            'meeting_id.exists' => 'The meeting ID does not exist.',
        ];
    }
}
