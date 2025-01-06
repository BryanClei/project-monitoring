<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "name" => [
                "required",
                "string",
                $this->route()->role
                    ? "unique:role,name," . $this->route()->role
                    : "unique:role,name",
            ],
            "access_permission" => "array",
            "access_permission.*" => "string",
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => "role name",
            "access_permission.*" => "access permission",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "The :attribute is required.",
            "unique" => "The :attribute already exists.",
            "string" => "The :attribute must be a string.",
        ];
    }
}
