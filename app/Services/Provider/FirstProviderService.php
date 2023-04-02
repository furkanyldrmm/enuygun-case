<?php

namespace App\Services\Provider;

use App\Http\Services\Repositories\TaskRepository;
use App\Models\Task;
use GuzzleHttp\Client;

class FirstProviderService implements IProviderService
{


    public function getTasks()
    {
        $client = new Client();
        $response = $client->get(config('constants.providers.first_provider'));
        $response = json_decode($response->getBody(), true);
        foreach ($response as $item) {
            $task = $this->jsonToTask($item);
            $this->storeTask($task);
        }
    }

    public function jsonToTask($item): ?Task
    {
        $key=array_keys($item)[0];
        $task = new Task();
        $task->title = $key;
        $task->time = $item[$key]['estimated_duration'];
        $task->difficulty = $item[$key]['level'];

        return $task;
    }

    public function storeTask(Task $task)
    {
        $task_controller = new TaskRepository();
        $task_controller->store($task);
    }
}
