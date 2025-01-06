<?php

namespace App\Http\Requests\Project;

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
                $this->route()->project
                    ? "unique:projects,name," . $this->route()->project
                    : "unique:projects,name",
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "name" => "project name",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "The :attribute is required.",
            "unique" => "The :attribute is already taken.",
        ];
    }
}
