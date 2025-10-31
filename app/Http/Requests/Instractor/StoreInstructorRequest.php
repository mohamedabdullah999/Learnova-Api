<?php

namespace App\Http\Requests\Instractor;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstructorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'bio' => 'nullable|string',
            'expertise' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
        ];
    }
}
