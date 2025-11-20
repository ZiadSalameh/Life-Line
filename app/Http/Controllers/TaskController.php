<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function GetAllTasks()
    {
        $tasks = Task::with('project')->get();
        return TaskResource::collection($tasks);
    }

    public function AddTask(StoreTaskRequest $request)
    {
        $validateData = $request->validated();
        $existdate = Task::where('task_name', $validateData['task_name'])
            ->where('project_id', $validateData['project_id'])->exists();
        if ($existdate) {
            return response()->json([
                'message' => 'Task exist alreday for this project ',
                'tasks' => $existdate
            ], 409);
        }
        $task = Task::create($validateData);
        return response()->json([
            'message' => 'Task added successfully',
            'tasks' => new TaskResource($task)
        ], 201);
    }


    public function UpdateTask(UpdateTaskRequest $request, $id)
    {
        try {
            $validateData = $request->validated();
            $task = Task::findOrFail($id);
            $existdate = Task::where('task_name', $validateData['task_name'])
                ->where('project_id', $validateData['project_id'])->exists();
            if ($existdate) {
                return response()->json([
                    'message' => 'Task exist alreday for this project ',
                    'tasks' => $existdate
                ], 409);
            }
            $task->update($validateData);
            return response()->json([
                'message' => 'Task updated successfully',
                'tasks' => new TaskResource($task)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function GetTask($id)
    {
        try {
            $task = Task::with('project')->findOrFail($id);
            return response()->json([
                'message' => 'Task found',
                'tasks' => new TaskResource($task)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function DeleteTask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([
                'message' => 'Task deleted successfully',
                'tasks' => new TaskResource($task)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Task not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function GetAllTasksProject($id)
    {
        try {
            $project = Project::with('tasks')->findOrFail($id);
            if ($project->tasks->isEmpty()) {
                return response()->json([
                    'message' => 'No Tasks  found for this project'
                ], 404);
            }

            return response()->json([
                'message' => 'Tasks retrieved successfully',
                'tasks' => TaskResource::collection($project->tasks)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
