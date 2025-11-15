<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function GetAllActivities()
    {
        $activities = Activity::with('objective')->get();
        return ActivityResource::collection($activities);
    }

    public function GetActivity($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            return new ActivityResource($activity);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Activity not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function AddActivity(StoreActivityRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $existActivity = Activity::where('activity_name', $validatedData['activity_name'])
                ->where('objective_id', $validatedData['objective_id'])
                ->first();
            if ($existActivity) {
                return response()->json([
                    'message' => 'Activity already exists',
                    'error' => 'Activity already exists'
                ], 400);
            }
            $activity = Activity::create($validatedData);
            return new ActivityResource($activity);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to add activity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdateActivity($id, UpdateActivityRequest $request)
    {
        try {

            $activity = Activity::findOrFail($id);
            $validatedData = $request->validated();
            $existActivity = Activity::where('activity_name', $validatedData['activity_name'])
            ->where('objective_id', $validatedData['objective_id'])
            ->where('id', '!=', $id)
            ->exists();
            if ($existActivity) {
                return response()->json([
                    'message' => 'Activity already exists',
                    'error' => 'Activity already exists'
                ], 400);
            }
            $activity->update($validatedData);
            return new ActivityResource($activity);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update activity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function DeleteActivity($id)
    {
        try {
            $activity = Activity::findOrFail($id);
            $activity->delete();
            return response()->json([
                'message' => 'Activity deleted successfully',
                'error' => 'Activity deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete activity because not exist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
