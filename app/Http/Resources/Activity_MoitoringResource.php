<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Activity_MoitoringResource extends JsonResource
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
            'projectproposal_id' => $this->projectproposal_id,
            'name' => $this->name,
            'monitors_name' => $this->monitors_name,
            'date_tracking' => $this->date_tracking,
            'monitors_note' => $this->monitors_note,
            'monitroing_mechanism' => $this->monitroing_mechanism,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'project_proposal' => $this->whenLoaded('projectProposal', function () {
                return [
                    'id' => $this->projectProposal->id,
                    'name' => $this->projectProposal->request_no,
                ];
            })
        ];
    }
}
