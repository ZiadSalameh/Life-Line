<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\BoardDee;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function GetallProject()
    {

        $projects = Project::with('boardDee')->get();
        return ProjectResource::collection($projects);
    }

    public function AddProject(StoreProjectRequest $request)
    {
        $validatedData = $request->validated();
        $existdata = Project::where('project_no', $validatedData['project_no'])->exists();
        if ($existdata) {
            return response()->json([
                'message' => 'Project already exists'
            ], 422);
        }
        $project = Project::create($validatedData);
        return response()->json([
            'message' => 'Project created successfully',
            'new_project' => $project
        ], 201);
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
        try {
            $project = Project::with('boardDee')->findOrFail($id);
            return response()->json([
                'message' => 'Project found',
                'project' => new ProjectResource($project)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found',
                'error' => $e->getMessage()
            ], 404);
        }
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
