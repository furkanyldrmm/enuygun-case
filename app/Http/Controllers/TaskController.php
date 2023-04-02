<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Services\Interfaces\ITaskInterface;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    /**
     * @var ITaskInterface
     */
    private ITaskInterface $task;

    /**
     * Create a new interface instance.
     * TaskController constructor.
     *
     * @param ITaskInterface $task
     */
    public function __construct(ITaskInterface $task)
    {
        $this->task = $task;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(TaskResource::collection($this->task->index()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new TaskResource($this->task->byId($id)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function store(Task $task): JsonResponse
    {

        $this->task->store($task);

        return response()->json()->setStatusCode(ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $this->task->update($request, $id);

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
        $this->task->delete($id);

        return response()->json()->setStatusCode(ResponseAlias::HTTP_OK);
    }
}
