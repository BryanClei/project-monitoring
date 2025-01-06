<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "username" => $this->username,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "token" => $this->token,
            "role" => new RoleResource($this->role),
            "system" => $this->systems,
        ];
    }
}
