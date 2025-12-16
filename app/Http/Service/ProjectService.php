<?php

namespace App\Http\Service;

use App\Models\Project;

class ProjectService
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
            return [
                'success' => false,
                'message' => 'Project not found',
                'status' => 404,
                'project' => null
            ];
        }
        return [
            'success' => true,
            'message' => 'Project retrieved successfully',
            'status' => 200,
            'project' => $project
        ];
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
        return [
            'success' => true,
            'message' => 'Project created successfully',
            'status' => 201,
            'project' => $project
        ];
    }

    public function UpdateProject(array $data, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return [
                'success' => false,
                'message' => 'Project not found',
                'status' => 404,
                'project' => null
            ];
        }

        $project->update($data);
        return [
            'success' => true,
            'message' => 'Project updated successfully',
            'status' => 200,
            'project' => $project
        ];
    }

    public function deleteProject($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return [
                'success' => false,
                'message' => 'Project not found',
                'status' => 404,
                'project' => null
            ];
        }

        $project->delete();
        return [
            'success' => true,
            'message' => 'Project deleted successfully',
            'status' => 200,
            'project' => $project
        ];
    }
}
