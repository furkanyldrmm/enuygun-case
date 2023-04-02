<?php

namespace App\Http\Services\Interfaces;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

interface IPlanInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection;


}
