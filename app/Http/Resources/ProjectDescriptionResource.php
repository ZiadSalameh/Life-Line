<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectDescriptionResource extends JsonResource
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
            'project_proposal_name' => $this->project_proposal_name,
            'duration_project_proposal' => $this->duration_project_proposal,
            'target_area' => $this->target_area,
            'target_group' => $this->target_group,
            'no_of_direct_benif' => $this->no_of_direct_benif,
            'estimate_cost' => $this->estimate_cost,
            'partners' => $this->partners,
            'over_all_project_goal' => $this->over_all_project_goal,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
            // 'project_proposal' => new ProjectProposalResource($this->project_proposal),
            'project_proposal' => $this->whenLoaded('project_proposal', function () {
                return [
                    'id' => $this->project_proposal->id,
                    'request_no' => $this->project_proposal->request_no,
                    'office_id' => $this->project_proposal->office_id,
                ];
            })
        ];
    }
}
