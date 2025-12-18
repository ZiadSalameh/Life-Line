<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Service\ProjectService;


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
            'project' => new ProjectResource($project['project']),
            'message' => $project['message']
        ], $project['status']);
    }


    public function updateProjectInBoard(UpdateProjectRequest $request, $id)
    {
        $validatedData = $request->validated();
        $project = $this->projectService->UpdateProject($validatedData, $id);
        return response()->json([
            'message' => $project['message'],
            'meeting' => $project['success']
                ? new ProjectResource($project['project'])
                : null
        ], $project['status']);
    }




    public function GetProject($id)
    {
        $project = $this->projectService->getProjectById($id);
        return response()->json([
            'message' => $project['message'],
            'project' => $project['success']
                ? new ProjectResource($project['project'])
                : null
        ], $project['status']);
    }

    public function DeleteProject($id)
    {
        $project = $this->projectService->deleteProject($id);
        return response()->json([
            'message' => $project['message'],
            'project' => $project['success']
                ? new ProjectResource($project['project'])
                : null
        ], $project['status']);
    }
}
