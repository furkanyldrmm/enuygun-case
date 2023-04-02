<?php

namespace App\Http\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;

class ProviderRepository implements ProviderInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Provider::all();
    }

    /**
     * @param int $id
     * @return Provider|null
     */
    public function byId(int $id): ?Provider
    {
        return Provider::query()->find($id)->first();
    }

    /**
     * @param Provider $model
     * @return bool
     */
    public function store(Provider $model): bool
    {
        return $model->save();
    }

    /**
     * @param ProviderRequest $request
     * @param int $id
     * @return bool
     */
    public function update(ProviderRequest $request, int $id): bool
    {
        return Blog::query()->find($id)->update($request->all());
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Blog::destroy($id);
    }
}
