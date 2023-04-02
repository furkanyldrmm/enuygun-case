<?php

namespace App\Services\Provider;

use App\Http\Controllers\TaskController;
use App\Http\Services\Interfaces\ITaskInterface;
use App\Http\Services\Repositories\TaskRepository;
use App\Models\Task;
use GuzzleHttp\Client;

class SecondProviderService implements IProviderService
{


    public function getTasks()
    {
        $client = new Client();
        $response = $client->get(config('constants.providers.second_provider'));
        $response = json_decode($response->getBody(), true);
        foreach ($response as $item) {
            $task = $this->jsonToTask($item);
            $this->storeTask($task);
        }

    }


    public function jsonToTask($item): ?Task
    {
        $task = new Task();
        $task->title = $item['id'];
        $task->time = $item['sure'];
        $task->difficulty = $item['zorluk'];

        return $task;
    }

    public function storeTask(Task $task)
    {
        $task_controller = new TaskRepository();
        $task_controller->store($task);
    }
}
