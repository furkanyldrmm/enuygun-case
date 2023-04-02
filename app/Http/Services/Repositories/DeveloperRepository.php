<?php

namespace App\Http\Services\Repositories;

use App\Http\Services\Interfaces\IDeveloperInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;


class DeveloperRepository implements IDeveloperInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Developer::query()->orderByDesc('difficulty')->get();
    }

    /**
     * @param int $id
     * @return Developer|null
     */
    public function byId(int $id): ?Developer
    {
        return Developer::query()->find($id)->first();
    }

    /**
     * @param Developer $model
     * @return bool
     */
    public function store(Developer $model): bool
    {
        return $model->save();
    }

    /**
     * @param DeveloperRequest $request
     * @param int $id
     * @return bool
     */
    public function update(DeveloperRequest $request, int $id): bool
    {
        return Developer::query()->find($id)->update($request->all());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Developer::destroy($id);
    }
}
