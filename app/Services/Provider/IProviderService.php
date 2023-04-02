<?php
namespace App\Services\Provider;
use App\Models\Task;

interface IProviderService
{
    public function getTasks();

    public function jsonToTask($item): ?Task;

    public function storeTask(Task $model);

}
