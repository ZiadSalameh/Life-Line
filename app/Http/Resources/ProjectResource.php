<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'project_no' => $this->project_no,
            'project_name' => $this->project_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'real_start_date' => $this->real_start_date,
            'real_end_date' => $this->real_end_date,
            'created_at' => $this->created_at,
            'board_dee' => $this->whenLoaded('boardDee', function () {
                return [
                    'id' => $this->boardDee->id,
                    'board_no' => $this->boardDee->board_no,
                ];
            })
        ];
    }
}
