<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivity_MoitoringRequest;
use App\Http\Requests\UpdateActivity_MoitoringRequest;
use App\Models\ActivityMonitoring;
use App\Http\Resources\Activity_MoitoringResource;
use Exception;
use Illuminate\Http\Request;

class ActivityMonitoringController extends Controller
{
    public function GetAllActivityMonitorings()
    {
        $activityMonitorings = ActivityMonitoring::with('projectProposal')->get();
        return Activity_MoitoringResource::collection($activityMonitorings);
    }

    public function GetActivityMonitoring($id)
    {
        try {
            $activityMonitoring = ActivityMonitoring::with('projectProposal')->findOrFail($id);
            return new Activity_MoitoringResource($activityMonitoring);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Activity Monitoring not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function AddActivityMonitoring(StoreActivity_MoitoringRequest $request)
    {
        $validatedata =  $request->validated();
        $existData = ActivityMonitoring::where('projectproposal_id', $validatedata['projectproposal_id'])->where('name', $validatedata['name'])->exists();
        if ($existData) {
            return response()->json([
                'message' => 'Activity Monitoring already exists',
                'error' => 'Activity Monitoring already exists'
            ], 400);
        }
        $activityMonitoring = ActivityMonitoring::create($validatedata);
        return response()->json([
            'message' => 'Activity Monitoring created successfully',
            'data' => new Activity_MoitoringResource($activityMonitoring)
        ], 201);
    }

    public function UpdateActivityMonitoring($id, UpdateActivity_MoitoringRequest $request)
    {
        $validatedata =  $request->validated();
        $activityMonitoring = ActivityMonitoring::findOrFail($id);
        $existData = ActivityMonitoring::where('projectproposal_id', $validatedata['projectproposal_id'])->where('name', $validatedata['name'])->exists();
        if ($existData) {
            return response()->json([
                'message' => 'Activity Monitoring already exists',
                'error' => 'Activity Monitoring already exists'
            ], 400);
        }
        $activityMonitoring->update($validatedata);
        return response()->json([
            'message' => 'Activity Monitoring updated successfully',
            'data' => new Activity_MoitoringResource($activityMonitoring)
        ], 200);
    }

    public function DeleteActivityMonitoring($id)
    {
        try {
            $activityMonitoring = ActivityMonitoring::findOrFail($id);
            $activityMonitoring->delete();
            return response()->json([
                'message' => 'Activity Monitoring deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Activity Monitoring not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
