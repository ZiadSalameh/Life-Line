<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'objective_id' => $this->objective_id,
            'activity_name' => $this->activity_name,
            'expected_outcome' => $this->expected_outcome,
            'brief_project' => $this->brief_project,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'objective' => new ObjectiveResource($this->objective),
            'objective'=> $this->whenLoaded('objective', function () {
                return [
                    'id' => $this->objective->id,
                    'objective_name' => $this->objective->name,
                ];
            })
        ];
    }
}
