<?php

namespace App\Http\Requests\User;

use App\Models\UserSystem;
use Illuminate\Foundation\Http\FormRequest;

class TagSystemRequest extends FormRequest
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
            "users" => ["required", "array", "min:1"],
            "users.*.user_id" => ["required", "exists:users,id", "distinct"],
            "systems" => ["required", "array", "min:1"],
            "systems.*.system_id" => [
                "required",
                "integer",
                "exists:projects,id",
                "distinct",
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            "users.*.user_id" => "user id",
            "systems.*.system_id" => "system id",
        ];
    }

    public function messages(): array
    {
        return [
            "exists" => "The :attribute does not exist.",
            "systems.*.system_id.exists" =>
                "The selected system id is invalid.",
            "distinct" => "The :attribute has duplicate value",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $users = $this->input("users");
            $systems = $this->input("systems");

            $uniqueCombinations = [];

            foreach ($users as $userKey => $userInfo) {
                foreach ($systems as $systemKey => $systemInfo) {
                    $userId = $userInfo["user_id"];
                    $systemId = $systemInfo["system_id"];

                    $combinationKey = $userId . "_" . $systemId;

                    $existingTag = UserSystem::where("user_id", $userId)
                        ->where("system_id", $systemId)
                        ->exists();

                    if ($existingTag) {
                        $validator
                            ->errors()
                            ->add(
                                "users.{$userKey}.user_id",
                                "User ID {$userId} is already tagged to System ID {$systemId}."
                            );
                    }

                    if (isset($uniqueCombinations[$combinationKey])) {
                        $validator
                            ->errors()
                            ->add(
                                "users.{$userKey}.user_id",
                                "Duplicate entry for User ID {$userId} and System ID {$systemId}."
                            );
                    }

                    $uniqueCombinations[$combinationKey] = true;
                }
            }
        });
    }
}
