<?php

namespace App\Http\Controllers;

use App\Models\Recurring_Subtask;
use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebSubtaskController extends Controller
{
    public function store(Request $request, $taskid)
    {
        try {

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'task_type_id' => 'required|in:1,2', // 1 = One-Time, 2 = Recurring

                // For One-Time Task, deadline is required, otherwise it can be nullable
                'deadline' => 'nullable|required_if:task_type_id,1|date',

                // For Recurring Task, days is required as an array
                'days' => 'nullable|required_if:task_type_id,2',

                // Each day inside the days array must be one of the valid values
                // 'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ]);

            $subtask = $request->all();
            $task = Task::findOrFail($taskid);
            $subtask['user_id'] = Auth::user()['id'];
            $subtask['task_id'] = $task->id;
            $task_deadline = $task->deadline;
            if ($request->has('deadline') && $request->deadline > $task->deadline) {
                return redirect()->back()->with('errors', 'Subtask deadline must be equal to or less than the task deadline.');
                // return redirect()->back()->withErrors(['deadline' => 'Subtask deadline must be equal to or less than the task deadline.'])->withInput();
            }

            if ($request->task_type_id == 2) {
                $subtask['days'] = implode(',', $request->days); // Convert days array to comma-separated string
            } else {
                $subtask['days'] = null; // No days for One-Time tasks
            }

            // dd($subtask);
            SubTask::create($subtask);
            return redirect()->back()->with('success', 'Subtask Added Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit($taskid, $subtask_id)
    {
        $subtask = SubTask::where('task_id', $taskid)->findOrFail($subtask_id);
        return response()->json([
            'status' => true,
            'message' => 'Subtask Ready to Edit',
            'subtask' => $subtask,
        ], 200);
    }

    public function update(Request $request, $taskid, $subtask_id)
{
    try {
        // Validate the request
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'deadline' => 'nullable|required_if:task_type_id,1|date',
            'days' => 'nullable|required_if:task_type_id,2|array', // Ensure days is an array if provided
            'status_id' => 'required|in:1,2,3,4,5',
        ]);

        // Get all request data
        $subtaskData = $request->all();
        $task = Task::findOrFail($taskid);
        if ($request->has('deadline') && $request->deadline > $task->deadline) {
            return redirect()->back()->withErrors(['deadline' => 'Subtask deadline must be equal to or less than the task deadline.'])->withInput();
        }
        // Convert days array to a comma-separated string if task type is 2 (Recurring)
        if ($request->task_type_id == 2) {
            // Ensure days is an array before using implode
            $subtaskData['days'] = is_array($request->days) ? implode(',', $request->days) : null;
        } else {
            $subtaskData['days'] = null; // No days for One-Time tasks
        }

        // Find and update the subtask
        $subtask = SubTask::findOrFail($subtask_id);
        $subtask->update($subtaskData);

        return redirect()->back()->with('success', 'Subtask Updated Successfully');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}


    public function delete($task_id, $subtask_id)
    {
        $subtask_id = SubTask::findOrFail($subtask_id);
        $subtask_id->delete();
        return redirect()->back()->with('success', 'Subtask Deleted Successfully');

    }
}
