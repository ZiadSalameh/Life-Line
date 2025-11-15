<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivity_methodologiesRequest;
use App\Http\Requests\UpdateActivity_methodologiesRequest;
use App\Http\Resources\Activity_methodologiesResource;
use App\Models\ActivityMethodology;
use Exception;
use Illuminate\Http\Request;

class ActivityMethodologyController extends Controller
{
    public function GetAllActivityMethodologies()
    {
        $activityMethodologies = ActivityMethodology::with('projectProposal')->get();
        return Activity_methodologiesResource::collection($activityMethodologies);
    }

    public function GetActivityMethodology($id)
    {
        $activityMethodology = ActivityMethodology::with('projectProposal')->findOrFail($id);
        return new Activity_methodologiesResource($activityMethodology);
    }

    public function AddActivityMethodology(StoreActivity_methodologiesRequest $request)
    {
        $validatedData = $request->validated();
        $existData = ActivityMethodology::where('projectproposal_id', $validatedData['projectproposal_id'])->where('activity_methodology_name', $validatedData['activity_methodology_name'])->exists();
        if ($existData) {
            return response()->json([
                'message' => 'Activity methodology already exists',
                // 'ActivityMethodology' => new Activity_methodologiesResource($existData)
            ], 400);
        }
        $activityMethodology = ActivityMethodology::create($validatedData);
        return response()->json([
            'message' => 'Activity methodology added successfully',
            'ActivityMethodology' => new Activity_methodologiesResource($activityMethodology)
        ], 201);
    }

    public function UpdateActivityMethodology($id, UpdateActivity_methodologiesRequest $request)
    {
        $validatedData = $request->validated();
        $activityMethodology = ActivityMethodology::findOrFail($id);
        $existData = ActivityMethodology::where('projectproposal_id', $validatedData['projectproposal_id'])->where('activity_methodology_name', $validatedData['activity_methodology_name'])->exists();
        if ($existData) {
            return response()->json([
                'message' => 'Activity methodology already exists',
            ], 400);
        }
        $activityMethodology->update($validatedData);
        return response()->json([
            'message' => 'Activity methodology updated successfully',
            'ActivityMethodology' => new Activity_methodologiesResource($activityMethodology)
        ], 200);
    }

    public function DeleteActivityMethodology($id)
    {
        try {
            $activityMethodology = ActivityMethodology::findOrFail($id);
            $activityMethodology->delete();
            return response()->json([
                'message' => 'Activity methodology deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Activity methodology not found',
            ], 404);
        }
    }
}
