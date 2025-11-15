<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStepResource extends JsonResource
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
            'step' => $this->step,
            'duration' => $this->duration,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'real_start_date' => $this->real_start_date,
            'real_end_date' => $this->real_end_date,
            'task' =>$this->whenLoaded('task',function(){
                return [
                    'id' => $this->task->id,
                    'task_name' => $this->task->task_name,
                ];
            }),
        ];
    }
}
