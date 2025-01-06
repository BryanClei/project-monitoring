<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "system_id" => $this->system_id,
            "user_id" => $this->user_id,
            "module" => $this->module,
            "description" => $this->description,
            "raise_date" => $this->raise_date,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "remarks" => $this->remarks,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
