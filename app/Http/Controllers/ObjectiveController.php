<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreObjectiveRequest;
use App\Http\Requests\UpdateObjectiveRequest;
use App\Http\Resources\ObjectiveResource;
use App\Models\Objective;
use Exception;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function GetAllObjectives()
    {
        $objectives = Objective::with('projectproposal')->get();
        return ObjectiveResource::collection($objectives);
    }

    public function GetObjective($id)
    {
        try {
            $objective = Objective::findOrFail($id);
            return new ObjectiveResource($objective);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Objective not found',
                'error' => $e->getMessage()
            ], 404);
        };
    }

    public function AddObjective(StoreObjectiveRequest $request)
    {
        $validateData = $request->validated();
        $existData = Objective::where('name', $validateData['name'])->where('projectproposal_id', $validateData['projectproposal_id'])->first();
        if ($existData) {
            return response()->json([
                'message' => 'Objective  already exists for this project proposal',
                'error' => ' Objective already exists for this project proposal'
            ], 409);
        }
        $objective = Objective::create($validateData);
        return response()->json([
            'message' => 'objective add successfully',
            'objective' => new ObjectiveResource($objective)
        ]);
    }

    public function UpdateObjective($id, UpdateObjectiveRequest $request)
    {
        try {
            $objective = Objective::findOrFail($id);
            $validateData = $request->validated();
            $objective->update($validateData);
            return response()->json([
                'message' => 'Objective updated successfully',
                'objective' => new ObjectiveResource($objective)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Objective not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function DeleteObjective($id)
    {
        try {
            $objective = Objective::findOrFail($id);
            $objective->delete();
            return response()->json([
                'message' => 'Objective deleted successfully',
                'objective' => new ObjectiveResource($objective)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Objective not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
