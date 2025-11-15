<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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

            'task_name'=>'required|string|max:40',
            'description'=>'string|nullable',
            'responsible'=>'string|nullable',
            'duration'=>'string|nullable',
            'start_date'=>'date|nullable',
            'end_date'=>'date|nullable',
            'real_start_date'=>'date|nullable',
            'real_end_date'=>'date|nullable',
            'project_id'=>'required|exists:projects,id',

        ];
    }

    public function messages()
    {
        return
        [
        'task_name.required' =>' task name required',
        'task_name.string' =>' task name must be string',
        'task_name.max' =>'task name must contain just 40 char',
        'project_id.required' =>' project id required',
        'project_id.exists' =>' project id not found',

        ];
    }
}
