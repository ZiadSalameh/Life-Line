<?php

namespace App\Http\Service;

use App\Models\Project;
use App\Models\Task;

class TaskService extends BaseService
{
    public function getAllTasks()
    {
        $tasks = Task::with('project')->get();
        return $tasks;
    }

    public function getTaskById($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->error('Task not found', 404, [
                'task' => $task
            ]);
        }
        return $this->success([
            'task' => $task
        ], 'Task retrieved successfully', 200);
    }

    public function addTask(array $data)
    {
        $task = Task::create($data);
        return $this->success([
            'task' => $task,
        ], 'task created successfully', 201);
    }

    public function updateTask(array $data, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->error('Task not found', 404, [
                'task' => $task
            ]);
        }
        $task->update($data);
        return $this->success([
            'task' => $task
        ], 'Task updated successfully', 200);
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->error('Task not found', 404, [
                'task' => $task
            ]);
        }
        $task->delete();
        return $this->success([
            'task' => $task
        ], 'Task deleted successfully', 200);
    }

    public function getAllTasksByProject($id)
    {
        $project = Project::with('tasks')->find($id);
        if (!$project) {
            return $this->error('Project not found', 404, [
                'project' => $project
            ]);
        }
        if ($project->tasks->isEmpty()) {
            return $this->error('No Tasks found for this project', 404, [
                'project' => $project
            ]);
        }
        return $this->success([
            'tasks' => $project->tasks
        ], 'Tasks retrieved successfully', 200);
    }
}
