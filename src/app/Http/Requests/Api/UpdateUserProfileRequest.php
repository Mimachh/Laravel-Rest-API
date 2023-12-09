<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
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
        $userId = $this->user()->id;

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'name' => 'required|string',
            'last_name' => 'required|string',
            
            // Ajoutez d'autres règles de validation selon vos besoins
        ];
    }
}
