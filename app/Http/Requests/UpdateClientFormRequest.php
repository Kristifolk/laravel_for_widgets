<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientFormRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
//            'email' => 'nullable|email|max:255|unique:clients,email',//TOdo не проходит валидацию
            'city' => 'nullable|string|max:255',
//            'phone' => 'nullable|string|max:255',//TOdo не проходит валидацию
//            'phone' => 'nullable|integer|max:255',
//            'phone' => 'nullable|max:255',
        ];
    }
}
