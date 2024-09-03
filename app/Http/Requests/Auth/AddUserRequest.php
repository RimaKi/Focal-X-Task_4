<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'exists:roles,name']
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'name' => $this->first_name . ' ' . $this->last_name,
            'password' => ucwords(strtolower($this->first_name) . '123123123*')
        ]);
    }
}
