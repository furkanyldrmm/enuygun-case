<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface ITaskInterface
{
/**
* @return Collection
*/
public function index(): Collection;

/**
* @param int $id
* @return Task|null
*/
public function byId(int $id): ?Task;

/**
* @param Task $model
* @return bool
*/
public function store(Task $model): bool;

/**
* @param TaskRequest $request
* @param int $id
* @return bool
*/
public function update(TaskRequest $request, int $id): bool;

/**
* @param int $id
* @return bool
*/
public function delete(int $id): bool;
}
