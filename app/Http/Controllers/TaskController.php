<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    private $requestValidations = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string|in:pending,in_progress,completed',
        "due_date" => 'required|date'
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
        $validator = Validator::make($request->all(), $this->requestValidations);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create($validator->validated());

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->requestValidations);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::findOrFail($id);
        $task->update($validator->validated());

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
