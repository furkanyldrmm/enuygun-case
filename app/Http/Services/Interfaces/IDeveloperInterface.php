<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use Illuminate\Database\Eloquent\Collection;

interface IDeveloperInterface
{
/**
* @return Collection
*/
public function index(): Collection;

/**
* @param int $id
* @return Developer|null
*/
public function byId(int $id): ?Developer;

/**
* @param Developer $model
* @return bool
*/
public function store(Developer $model): bool;

/**
* @param DeveloperRequest $request
* @param int $id
* @return bool
*/
public function update(DeveloperRequest $request, int $id): bool;

/**
* @param int $id
* @return bool
*/
public function delete(int $id): bool;
}
