<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'pets' => 'nullable|array',
            'pets.*.name' => 'required_with:pets|string|max:255',
            'pets.*.type' => 'required_with:pets|string|max:255',
            'pets.*.breed' => 'nullable|string|max:255',
            'pets.*.color' => 'nullable|string|max:255',
            'pets.*.age' => 'nullable|integer',
        ];
    }
}
