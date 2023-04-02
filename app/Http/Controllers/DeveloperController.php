<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeveloperRequest;
use App\Http\Resources\DeveloperResource;
use App\Http\Resources\TaskResource;
use App\Http\Services\Interfaces\IDeveloperInterface;
use App\Models\Developer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeveloperController extends Controller
{
    /**
     * @var IDeveloperInterface
     */
    private IDeveloperInterface $developer;

    /**
     * Create a new interface instance.
     * TaskController constructor.
     *
     * @param IDeveloperInterface $developer
     */
    public function __construct(IDeveloperInterface $developer)
    {
        $this->developer = $developer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(DeveloperResource::collection($this->developer->index()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new TaskResource($this->developer->byId($id)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeveloperRequest $request
     * @return JsonResponse
     */
    public function store(DeveloperRequest $request): JsonResponse
    {
        $item = new Developer();
        $item->fill($request->all());
        $this->developer->store($item);

        return response()->json()->setStatusCode(ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeveloperRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(DeveloperRequest $request, int $id): JsonResponse
    {
        $this->developer->update($request, $id);

        return response()->json()->setStatusCode(ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->developer->delete($id);

        return response()->json()->setStatusCode(ResponseAlias::HTTP_OK);
    }
}
