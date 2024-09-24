<?php

namespace App\Http\Controllers;

use App\Models\Recurring_Subtask;
use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubTaskController extends Controller
{
    public function store(Request $request, $taskid){
        try{

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
            $taskid = Task::findOrFail($taskid);
            // $date = new \DateTime($request->date);
            // $day = $date->format('l');
            // $subtask['day'] = $day;
            $subtask['user_id'] = Auth::user()['id'];
            $subtask['task_id'] = $taskid->id;
            SubTask::create($subtask);

            // if($request->task_type_id == 2){
            //     Recurring_Subtask::create([
            //         'subtask_id'=> $subtask->id,
            //         'days'=>$request->days,
            //     ]);
            // }
            return response()->json([
                'status'=> true,
                'message'=> 'Subtask Added Successfully',
                'subtask'=> $subtask,
            ], 200);
        }
        
        catch (\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'status'=> false,
                'message'=> 'Validation Errors',
                'errors'=> $e->errors()
            ], 422);
        }
    }

    public function edit($taskid, $subtask_id){
        $subtask = SubTask::where('task_id', $taskid)->findOrFail($subtask_id);
        return response()->json([
            'status'=> true,
            'message'=> 'Subtask Ready to Edit',
            'subtask'=> $subtask,
        ], 200);
    }

    public function update(Request $request, $taskid, $subtask_id){
        try{

            $request->validate([
                'title' => 'required',
                'description' => 'required',
                // 'task_type_id' => 'required|in:1,2', 
                'deadline' => 'nullable|required_if:task_type_id,1|date',
                'days' => 'nullable|required_if:task_type_id,2',
                'status_id'=> 'required|in:1,2,3,4,5',
            
                // Each day inside the days array must be one of the valid values
                // 'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ]);
            
            $subtask = $request->all();
            $taskid = Task::findOrFail($taskid);
            // $date = new \DateTime($request->date);
            // $day = $date->format('l');
            // $subtask['day'] = $day;
            $subtask['task_id'] = $taskid->id;
            $subtask['task_type_id'] = $request->task_type_id;
           $subtask_id = SubTask::findOrFail($subtask_id);
           $subtask_id->update($subtask);

            // if($request->task_type_id == 2){
            //     Recurring_Subtask::create([
            //         'subtask_id'=> $subtask->id,
            //         'days'=>$request->days,
            //     ]);
            // }
            return response()->json([
                'status'=> true,
                'message'=> 'Subtask Updated Successfully',
                'subtask'=> $subtask,
            ], 200);
        }
        
        catch (\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'status'=> false,
                'message'=> 'Validation Errors',
                'errors'=> $e->errors()
            ], 422);
        }
    }

    public function delete($taskid, $subtask_id){
        $subtask_id = SubTask::findOrFail($subtask_id);
        $subtask_id->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Following Subtask Deleted Successfully ',
            'subtask'=>$subtask_id,
        ]);
        
    }
}
