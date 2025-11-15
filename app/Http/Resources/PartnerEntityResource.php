<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerEntityResource extends JsonResource
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
            'name' => $this->name,
            'qualification_field_work' => $this->qualification_field_work,
            'role_responsibility' => $this->role_responsibility,
            // 'projectproposal_id' => $this->projectproposal_id,
            'projectproposal' => $this->whenLoaded('projectproposal', function () {
                return [
                    'id' => $this->projectproposal->id,
                    'request_no' => $this->projectproposal->request_no,

                ];
            }),
        ];
    }
}
