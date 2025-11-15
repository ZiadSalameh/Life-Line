<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Activity_methodologiesResource extends JsonResource
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
            'activity_methodology_name' => $this->activity_methodology_name,
            'proposed_implementation_period' => $this->proposed_implementation_period,
            'logistical_requirements' => $this->logistical_requirements,
            'outputs' => $this->outputs,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'project_proposal' => $this->whenLoaded('projectProposal', function(){
                return [
                    'id' => $this->projectProposal->id,
                    'name' => $this->projectProposal->request_no,
                ];
            })
        ];
    }
}
