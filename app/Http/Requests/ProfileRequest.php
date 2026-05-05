<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $userId = auth()->id();
        return [
            'first_name' => 'string|sometimes',
            'last_name' => 'string|sometimes',
            'email' => ['sometimes', Rule::unique('users', 'email')->ignore($userId)],
            'phone_number' => [Rule::unique('users', 'phone_number')->ignore($userId), 'sometimes'],
            'address' => 'string|sometimes',
            'password' => 'required_with:new_password|sometimes',
            'new_password' => 'required_with:password|confirmed|min:8' //: add required_with here too
        ];
    }
}
