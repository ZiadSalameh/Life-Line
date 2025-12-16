<?php

namespace App\Http\Service;

use App\Models\Project;

class ProjectService extends BaseService
{
    public function getAllProject()
    {
        $projects = Project::with('boardDee')->get();
        return $projects;
    }

    public function getProjectById($id)
    {
        $project = Project::with('boardDee')->find($id);
        if (!$project) {
            return $this->error('Project not found', 404, [
                'project' => $project
            ]);
        }
        return $this->success([
            'project' => $project
        ], 'Project retrieved successfully', 200);
    }

    public function AddProject(array $data): array
    {
        $project = Project::create([
            'project_no' => $data['project_no'],
            'project_name' => $data['project_name'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'real_start_date' => $data['real_start_date'] ?? null,
            'real_end_date' => $data['real_end_date'] ?? null,
            'board_dee_id' => $data['board_dee_id']

        ]);
        return $this->success([
            'project' => $project
        ], 'Project created successfully', 201);
    }

    public function UpdateProject(array $data, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->error('Project not found', 404, [
                'project' => $project
            ]);
        }

        $project->update($data);
        return $this->success([
            'project' => $project
        ], 'Project updated successfully', 200);
    }

    public function deleteProject($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->error('Project not found', 404, [
                'project' => $project
            ]);
        }

        $project->delete();
        return $this->success([
            'project' => $project
        ], 'Project deleted successfully', 200);
    }
}
