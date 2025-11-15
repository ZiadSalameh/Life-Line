<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'name' => $this->first_name . " " . $this->last_name,
            'email' => $this->email,
            'bitrthdate' => $this->bitrthdate,
            'ScinceGrade' => $this->ScinceGrade,
            'Created_at' => $this->created_at->format('Y-M-d'),
            'office' => $this->whenLoaded('office', function () {
                return [
                    'office_id' => $this->office_user->office_id,
                    'office_name' => $this->office_user->office->name  
                ];
            })

        ];
    }
}
