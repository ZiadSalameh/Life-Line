<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
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
            'meeting_no' => $this->meeting_no,
            'description' => $this->description,
            'DateTime' => $this->DateTime,
            'user_id'=> $this->whenLoaded('users',function(){
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
