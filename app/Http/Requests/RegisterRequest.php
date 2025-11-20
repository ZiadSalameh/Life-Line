<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'role' => 'enum:admin,user|nullable',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|confirmed|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            // 'role.required' => 'The role field is required.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'role.in' => 'The role must be admin or user.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
