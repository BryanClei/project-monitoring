<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "fullname" => ["required", "string"],
            "group_id" => ["required", "exists:teams,id,deleted_at,NULL"],
            "username" => ["required", "unique:users,username"],
            "password" => "required",
            "confirm_password" => ["required", "same:password"],
            "systems" => ["array", "nullable"],
            "systems.*.system_id" => [
                "nullable",
                "exists:projects,id",
                "not_in:''",
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "fullname" => "Full name",
            "group_id" => "Group ID",
            "username" => "Username",
            "password" => "Password",
            "confirm_password" => "Confirm Password",
            "systems.*.system_id" => "System ID",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "The :attribute is required.",
            "unique" => "The :attribute is already taken.",
            "exists" => "The :attribute does not exist.",
            "same" => "The :attribute must match the password.",
        ];
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         if ($this->password !== $this->confirm_password) {
    //             return $validator
    //                 ->errors()
    //                 ->add(
    //                     "password",
    //                     "Password and confirm password do not match."
    //                 );
    //         }
    //     });
    // }
}
