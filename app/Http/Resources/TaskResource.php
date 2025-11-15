<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'task_name' => $this->task_name,
            'duration' => $this->duration,
            'responsible' => $this->responsible,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'real_start_date' => $this->real_start_date,
            'real_end_date' => $this->real_end_date,
            'project' => $this->whenLoaded('project', function () {
                return [
                    'id' => $this->project->id,
                    'project_no' => $this->project->project_no,
                    'project_name' => $this->project->project_name,
                ];
            }),
        ];
    }
}
