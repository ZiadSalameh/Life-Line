<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Service\TaskService;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskService $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function GetAllTasks()
    {
        $tasks = $this->taskService->getAllTasks();
        return TaskResource::collection($tasks);
    }

    public function AddTask(StoreTaskRequest $request)
    {
        $validateData = $request->validated();
        $task = $this->taskService->addTask($validateData);
        return response()->json([
            'task' => new TaskResource($task['task']),
            'message' => $task['message']
        ], $task['status']);
    }


    public function UpdateTask(UpdateTaskRequest $request, $id)
    {
        $validateData = $request->validated();
        $task = $this->taskService->updateTask($validateData, $id);
        return response()->json([
            'task' => new TaskResource($task['task']),
            'message' => $task['message']
        ], $task['status']);
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
        $project = $this->taskService->getAllTasksByProject($id);

        if (!$project['success']) {
            return response()->json([
                'message' => $project['message']
            ], $project['status']);
        }

        return response()->json([
            'message' => $project['message'],
            'tasks' => TaskResource::collection($project['tasks'])
        ], $project['status']);
    }
}
