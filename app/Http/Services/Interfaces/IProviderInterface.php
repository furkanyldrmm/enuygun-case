<?php

use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Collection;

interface IProviderInterface
{
    /**
     * @return Collection
     */
    public function getTask(): Collection;

    /**
     * @param int $id
     * @return Provider|null
     */
    public function byId(int $id): ?Provider;

    /**
     * @param Provider $model
     * @return bool
     */
    public function store(Provider $model): bool;

    /**
     * @param ProviderRequest $request
     * @param int $id
     * @return bool
     */
    public function update(ProviderRequest $request, int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
