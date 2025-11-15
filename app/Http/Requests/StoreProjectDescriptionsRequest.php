<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectDescriptionsRequest extends FormRequest
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
            'projectproposal_id' => 'required|exists:project_proposals,id',
            'project_proposal_name' => 'required',
            'duration_project_proposal' => 'nullable',
            'target_area' => 'nullable',
            'target_group' => 'nullable',
            'no_of_direct_benif' => 'nullable',
            'estimate_cost' => 'nullable',
            'partners' => 'nullable',
            'over_all_project_goal' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'projectproposal_id.required' => 'The project proposal ID is required.',
            'project_proposal_id.exists' => 'The project proposal ID does not exist.',
            'project_proposal_name.required' => 'The project proposal name is required.',
        ];
    }
}
