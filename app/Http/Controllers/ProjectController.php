<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Service\ProjectService;
use App\Models\Project;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProjectController extends Controller
{
    private ProjectService $projectService;
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    public function GetallProject()
    {

        $projects = $this->projectService->getAllProject();
        return ProjectResource::collection($projects);
    }

    public function AddProject(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();
        $project = $this->projectService->AddProject($validatedData);
        return response()->json([
            'peoject' => new ProjectResource($project['project']),
            'message' => $project['message']
        ], $project['status']);
   
    }


    public function updateProjectInBoard(UpdateProjectRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $project = Project::findOrFail($id);
            $project->update($validatedData);
            return response()->json([
                'message' => 'Project updated successfully',
                'updated_project' => new ProjectResource($project)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function GetProject($id)
    {
        $project = $this->projectService->getProjectById($id);
       return response()->json([
            'message' => $project['message'],
            'meeting' => $project['success']
                ? new ProjectResource($project['project'])
                : null
        ], $project['status']);
    }

    public function DeleteProject($id)
    {

        try {
            $project = Project::findOrFail($id);
            $project->delete();
            return response()->json([
                'message' => 'Project deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
