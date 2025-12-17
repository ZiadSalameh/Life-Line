<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStepRequest;
use App\Http\Requests\UpdateTaskStepRequest;
use App\Http\Resources\TaskStepResource;
use App\Http\Service\TaskStepService;
use App\Models\TaskStep;

class TaskStepController extends Controller
{
    private TaskStepService $taskStepService;
    public function __construct(TaskStepService $taskStepService)
    {
        $this->taskStepService = $taskStepService;
    }
    public function GetAllTaskSteps()
    {
        $tasks = $this->taskStepService->getAllTaskSteps();
        return TaskStepResource::collection($tasks);
    }

    public function AddTaskStep(StoreTaskStepRequest $request)
    {
        $validatedData = $request->validated();
        $taskStep = $this->taskStepService->addTaskStep($validatedData);
        return response()->json([
            'message' => $taskStep['message'],
            'tasksteps' => $taskStep['tasksteps']
        ], $taskStep['status']);
    }

    public function UpdateTaskStep(UpdateTaskStepRequest $request, $id)
    {
        $validatedData = $request->validated();
        $taskStep = $this->taskStepService->updateTaskStep($validatedData, $id);
        return response()->json([
            'message' => $taskStep['message'],
            'taskStep' => $taskStep['taskStep']
        ], $taskStep['status']);
    }

    public function GetTaskStep($id)
    {
        $taskStep = $this->taskStepService->getTaskStepById($id);
        return response()->json([
            'message' => $taskStep['message'],
            'taskStep' => $taskStep['taskStep']
        ], $taskStep['status']);
    }

    public function DeleteTaskStep($id)
    {
        $taskStep = $this->taskStepService->deleteTaskStep($id);
        return response()->json([
            'message' => $taskStep['message'],
            'taskStep' => $taskStep['taskStep']
        ], $taskStep['status']);
    }



    public function GetAllTasksStepProject($id)
    {
        $taskStep = $this->taskStepService->getAllTaskStepsByTask($id);

        if (!$taskStep['success']) {
            return response()->json([
                'message' => $taskStep['message']
            ], $taskStep['status']);
        }
        return response()->json([
            'message' => $taskStep['message'],
            'task' => $taskStep['task']
        ], $taskStep['status']);
    }
}
