<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'task_name' => [
                'sometimes',
                'string',
                'max:40',
                Rule::unique('tasks', 'task_name')
                    ->where('project_id', $this->project_id)
                    ->ignore($this->route('id')),
            ],
            'description' => 'string|nullable',
            'responsible' => 'string|nullable',
            'duration' => 'string|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'real_start_date' => 'date|nullable',
            'real_end_date' => 'date|nullable',
            'project_id' => 'required|exists:projects,id',
        ];
    }

    public function messages()
    {
        return [

            'project_id.required' => 'The project ID is required.',
            'project_id.exists' => 'The project ID does not exist.',
            'task_name.string' => 'The task name must be a string.',
            'task_name.max' => 'The task name must be at most 40 characters.',
            'task_name.unique' => 'The task name must be unique.',

        ];
    }
}
