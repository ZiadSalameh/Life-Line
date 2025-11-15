<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectDescriptionResource;
use App\Models\ProjectDescription;
use Exception;
use Illuminate\Http\Request;

class ProjectDescriptionController extends Controller
{
    public function GetAllProjectDescriptions()
    {
       $projectDescriptions = ProjectDescription::all();
       return ProjectDescriptionResource::collection($projectDescriptions);
    }

    public function GetProjectDescription($id)
    {
        try {
            $projectDescription = ProjectDescription::findOrFail($id);
            return new ProjectDescriptionResource($projectDescription);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Project description not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function AddProjectDescription(StoreProjectRequest $request)
    {
        $validateData = $request->validated();
        $existData = ProjectDescription::where('projectproposal_id', $validateData['projectproposal_id'])
        ->where('project_proposal_name', $validateData['project_proposal_name'])
        ->first();
        if ($existData) {
            return response()->json([
                'message' => 'Project description already exists',
                'error' => 'Project description already exists'
            ], 409);
        }
        $ProjectDescription = ProjectDescription::Create($validateData);
        return response()->json([
            'message' => 'Project description added successfully',
            'ProjectDescription' => new ProjectDescriptionResource($ProjectDescription)
        ], 201);
    }

    public function UpdateProjectDescription($id, UpdateProjectRequest $request)
    {
        $validateData = $request->validated();
        $existData = ProjectDescription::where('projectproposal_id', $validateData['projectproposal_id'])
        ->where('project_proposal_name', $validateData['project_proposal_name'])
        ->first();
        if ($existData) {
            return response()->json([
                'message' => 'Project description already exists',
                'error' => 'Project description already exists'
            ], 409);
        }
        $ProjectDescription = ProjectDescription::findOrFail($id);
        $ProjectDescription->update($validateData);
        return response()->json([
            'message' => 'Project description updated successfully',
            'ProjectDescription' => new ProjectDescriptionResource($ProjectDescription)
        ], 200);
    }

    public function DeleteProjectDescription($id)
    {
       
        try{
            $ProjectDescription = ProjectDescription::findOrFail($id);
            $ProjectDescription->delete();
            return response()->json([
                'message' => 'Project description deleted successfully',
                'ProjectDescription' => new ProjectDescriptionResource($ProjectDescription)
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'message' => 'Project description not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
