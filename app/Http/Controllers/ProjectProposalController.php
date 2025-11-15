<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectProposalRequest;
use App\Http\Requests\UpdateProjectProposalRequest;
use App\Http\Resources\ProjectProposalResource;
use App\Models\ProjectProposal;
use Exception;


class ProjectProposalController extends Controller
{
    public function GetAllProjectProposals()
    {
        $projectProposals = ProjectProposal::with('office')->get();
        return ProjectProposalResource::collection($projectProposals);
    }

    public function GetProjectProposal($id)
    {
        try {
            $projectProposal = ProjectProposal::with('office')->findOrFail($id);
            return new ProjectProposalResource($projectProposal);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Project proposal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function AddProjectProposal(StoreProjectProposalRequest $request)
    {
        $validateData = $request->validated();
        $existData = ProjectProposal::where('request_no', $validateData['request_no'])->first();
        if ($existData) {
            return response()->json([
                'message' => 'Project proposal already exists',
                'error' => 'Project proposal already exists'
            ], 409);
        }
        $ProjectProposal = ProjectProposal::Create($validateData);
        return response()->json([
            'message' => 'Office added successfully',
            'ProjectProposal' => new ProjectProposalResource($ProjectProposal)
        ], 201);
    }

    public function UpdateProjectProposal($id, UpdateProjectProposalRequest $request)
    {
        try {
            $projectProposal = ProjectProposal::with('office')->findOrFail($id);
            $validateData = $request->validated();
            $projectProposal->update($validateData);
            return response()->json([
                'message' => 'Project proposal updated successfully',
                'projectProposal' => new ProjectProposalResource($projectProposal)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Project proposal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function DeleteProjectProposal($id)
    {
        try {
            $projectProposal = ProjectProposal::with('office')->findOrFail($id);
            $projectProposal->delete();
            return response()->json([
                'message' => 'Project proposal deleted successfully',
                'projectProposal' => new ProjectProposalResource($projectProposal)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Project proposal not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
