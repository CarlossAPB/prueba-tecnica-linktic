<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    private $requestValidations = [
        "SAVE" => [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,completed',
            "due_date" => 'nullable|date'
        ]
    ];

    public function index()
    {
        return Task::all();
    }

    public function byStatus($status)
    {
        return Task::where("status", $status)->get();
    }

    public function byDueDateRange($dateStart, $dateEnd)
    {
        return Task::whereBetween(DB::raw("DATE(due_date)"), [$dateStart, $dateEnd])->get();
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate($this->requestValidations);

        $task = Task::create($request->all());

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->requestValidations);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
