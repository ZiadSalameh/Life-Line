<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardDeeResource extends JsonResource
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
            'board_no' => $this->board_no,
            'boar_dee_date' => $this->boar_dee_date,
            'description' => $this->description,
            'voted' => $this->voted,
            'created_at' => $this->created_at->format('Y-m-d'),
            'meeting' => $this->whenLoaded('meeting', function () {
                return [
                    'id' => $this->meeting->id,
                    'meeting_no' => $this->meeting->meeting_no,
                ];
            })
        ];
    }
}
