<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'board_dee_id' => 'required|exists:board_dees,id',
            'project_no' => 'required|string|max:40|unique:projects',
            'project_name' => 'required|string|max:40|unique:projects',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'real_start_date' => 'date|nullable',
            'real_end_date' => 'date|nullable',
        ];
    }

    public function messages()
    {
        return [
            'board_dee_id.required' => 'Board dee id is required',
            'board_dee_id.exists' => 'Board dee id does not exist',
            'project_no.required' => 'Project number is required',
            'project_no.unique' => 'Project number must be unique',
            'project_name.required' => 'Project name is required',
            'project_name.unique' => 'Project name must be unique',
            'project_name.string' => 'Project name must be a string',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'real_start_date.date' => 'Real start date must be a valid date',
            'real_end_date.date' => 'Real end date must be a valid date',

        ];
    }
}
