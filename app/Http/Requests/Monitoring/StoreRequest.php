<?php

namespace App\Http\Requests\Monitoring;

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
            "system_id" => [
                "required",
                "exists:projects,id",
                $this->route()->monitoring
                    ? "unique:monitoring,system_id," .
                        $this->route()->monitoring
                    : "unique:monitoring,system_id",
            ],
            "user_id" => ["required", "exists:users,id"],
            "module" => "required",
            "description" => ["required", "string"],
            "raise_date" => "required",
            "start_date" => "nullable",
            "end_date" => "nullable",
            "remarks" => ["nullable", "string"],
            "status" => ["required", "in:Pending,Developing,Done,For Checking"],
        ];
    }

    public function attributes(): array
    {
        return [
            "system_id" => "system id'",
            "user_id" => "user id'",
            "module" => "module",
            "description" => "description",
            "raise_date" => "raise date",
            "start_date" => "start date",
            "end_date" => "end date",
            "remarks" => "remarks",
            "status" => "status",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "The :attributes is required.",
            "exists" => "The :attributes does not exist.",
            "unique" => "The :attributes is already taken.",
        ];
    }
}
