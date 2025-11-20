<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStepRequest;
use App\Http\Requests\UpdateTaskStepRequest;
use App\Http\Resources\TaskStepResource;
use App\Models\Task;
use App\Models\TaskStep;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStepController extends Controller
{
    public function GetAllTaskSteps()
    {
        $tasks = TaskStep::with('task')->get();
        return TaskStepResource::collection($tasks);
    }

    public function AddTaskStep(StoreTaskStepRequest $request)
    {
        $validatedData = $request->validated();
        $existTaskstep = TaskStep::where('step', $validatedData['step'])->where('task_id', $validatedData['task_id'])->exists();
        if ($existTaskstep) {
            return response()->json([
                'mesaage' => 'this step alreday exist for this Task',
                'tasksteps' => $existTaskstep
            ], 409);
        }
        $taskStep = TaskStep::create($validatedData);
        return response()->json([
            'message' => 'Task Step Added Successfully',
            'tasksteps' => new TaskStepResource($taskStep)
        ], 201);
    }

    public function UpdateTaskStep(UpdateTaskStepRequest $request, $id)
    {
        $validatedData = $request->validated();
        $taskStep = TaskStep::findOrFail($id);
        $taskStep->update($validatedData);
        return response()->json([
            'message' => 'Task Step Updated Successfully',
            'tasksteps' => new TaskStepResource($taskStep)
        ], 200);
    }

    public function GetTaskStep($id)
    {
        try {
            $taskStep = TaskStep::with('task')->findOrFail($id);
            return response()->json([
                'message' => 'Task Step Found',
                'tasksteps' => new TaskStepResource($taskStep)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task Step Not Found',
                'tasksteps' => $e
            ], 404);
        }
    }

    public function DeleteTaskStep($id)
    {
        try {
            $taskStep = TaskStep::findOrFail($id);
            $taskStep->delete();
            return response()->json([
                'message' => 'Task Step Deleted Successfully',
                'tasksteps' => new TaskStepResource($taskStep)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task Step Not Found',
                'tasksteps' => $e
            ], 404);
        }
    }


    public function GetAllTasksStepProject($id)
    {
        try {
            $task = Task::with('tasksteps')->findOrFail($id);
            if ($task->tasksteps->isEmpty()) {
                return response()->json([
                    'message' => 'No Task steps  found for this task'
                ], 404);
            }

            return response()->json([
                'message' => 'Task Steps retrieved successfully',
                'tasksteps' => TaskStepResource::collection($task->tasksteps)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
