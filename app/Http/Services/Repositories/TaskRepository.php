<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Interfaces\ITaskInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskRepository implements ITaskInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $tasks = Task::query()->take(10)->get();
        return $tasks->sortByDesc('unit_work');
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function byId(int $id): ?Task
    {
        return Task::query()->find($id)->first();
    }

    /**
     * @param Task $model
     * @return bool
     */
    public function store(Task $model): bool
    {
        $model_exists = Task::where('title', $model->title)->first();
        if (!$model_exists) {
            return $model->save();
        } else {
            return false;
        }
    }

    /**
     * @param TaskRequest $request
     * @param int $id
     * @return bool
     */
    public function update(TaskRequest $request, int $id): bool
    {
        return Task::query()->find($id)->update($request->all());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Task::destroy($id);
    }
}
