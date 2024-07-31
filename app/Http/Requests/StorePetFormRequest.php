<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetFormRequest extends FormRequest
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
            'alias' => 'required|string|max:50',
            'owner_id' => 'required',
            'breed_id' => 'required',
            'type_id' => 'required',
            'sex'=> 'required',
        ];
    }
}
