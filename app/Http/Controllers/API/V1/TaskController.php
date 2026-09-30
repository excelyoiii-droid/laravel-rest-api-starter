<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Task::all();
        // return TaskResource::collection(Task::all());
        return Task::all()->toResourceCollection();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretaskRequest $request)
    {
        $task = Task::create($request->validated());
        return $task->toResource();
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        // return $task;
        // return new TaskResource($task);
        return $task->toResource();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetaskRequest $request, task $task)
    {
        $task->update($request->validated());
        return $task->toResource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task)
    {
        $task->delete();
        // return response()->noContent();
        return response()->json([
        'message' => 'Task berhasil di hapus']);
    }
}
