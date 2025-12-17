<?php

namespace App\Http\Service;

use App\Models\Task;
use App\Models\TaskStep;

class TaskStepService extends BaseService
{
    public function getAllTaskSteps()
    {
        $taskSteps = TaskStep::all();
        return $taskSteps;
    }

    public function getTaskStepById($id)
    {
        $taskStep = TaskStep::with('task')->find($id);
        if (!$taskStep) {
            return $this->error('TaskStep not found', 404, [
                'taskStep' => $taskStep
            ]);
        }
        return $this->success([
            'taskStep' => $taskStep
        ], 'TaskStep retrieved successfully', 200);
    }

    public function addTaskStep(array $data)
    {
        $taskStep = TaskStep::create($data);
        return $this->success([
            'task' => $taskStep,
        ], 'task created successfully', 201);
    }

    public function updateTaskStep(array $data, $id)
    {
        $taskStep = TaskStep::find($id);

        if (!$taskStep) {
            return $this->error('TaskStep not found', 404, [
                'taskStep' => $taskStep
            ]);
        }
        $taskStep->update($data);
        return $this->success([
            'taskStep' => $taskStep
        ], 'TaskStep updated successfully', 200);
    }

    public function deleteTaskStep($id)
    {
        $taskStep = TaskStep::find($id);

        if (!$taskStep) {
            return $this->error('TaskStep not found', 404, [
                'taskStep' => $taskStep
            ]);
        }
        $taskStep->delete();
        return $this->success([
            'taskStep' => $taskStep
        ], 'TaskStep deleted successfully', 200);
    }

    public function getAllTaskStepsByTask($id)
    {
        $task = Task::with('tasksteps')->find($id);
        if (!$task) {
            return $this->error('task not found', 404, [
                'task' => $task
            ]);
        }

        if ($task->tasksteps->isEmpty()) {
            return $this->error('No Task steps found for this task', 404, [
                'task' => $task
            ]);
        }
        return $this->success([
            'task' => $task
        ], 'Task steps retrieved successfully', 200);
    }
}
