<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectProposalResource extends JsonResource
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
            'office_id' => $this->office_id,
            'request_no' => $this->request_no,
            'requset_date' => $this->requset_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'office' => new OfficeResource($this->office),
        ];
    }
}
