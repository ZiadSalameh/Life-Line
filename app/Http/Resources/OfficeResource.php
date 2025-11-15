<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
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
            'projectproposals' => $this->whenLoaded('projectProposals'),
            'users'=> $this->whenLoaded('users',function(){
                return $this->users->map(function($user){
                    return [
                        'id'=>$user->id,
                        'name'=>$user->first_name.' '.$user->last_name,
                        'email'=>$user->email,    
                    ];

                });
            })
        ];
    }
}
