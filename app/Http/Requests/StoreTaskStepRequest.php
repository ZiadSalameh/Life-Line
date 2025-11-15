<?php

namespace App\Http\Requests;

use App\Models\TaskStep;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskStepRequest extends FormRequest
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
            // 'task_id' => 'required|exists:tasks,id',
            // 'step' => 'required',
            'task_id' => 'required|exists:tasks,id',
            'step' => [
                'required',
                Rule::unique('task_steps')->where('task_id', $this->input('task_id')),
            ],
            'duration' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'real_start_date' => 'nullable|date',
            'real_end_date' => 'nullable|date',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'real_start_date' => 'nullable|date',
            'real_end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'step.unique' => 'This step already exists for this task.',
            'task_id.required' => 'Task ID is required',
            'task_id.exists' => 'Task ID does not exist',
            'step.default' => 'Step must be step_1, step_2, or step_3',
            'duration.string' => 'Duration must be a string',
            'duration.max' => 'Duration must not exceed 255 characters',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'real_start_date.date' => 'Real start date must be a valid date',
            'real_end_date.date' => 'Real end date must be a valid date',
            'description.string' => 'Description must be a string',
        ];
    }
}
