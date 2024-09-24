<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    
    public function homepage(){
        $today = strtolower(date('l'));
        if(Auth::user()['role']=='user'){
            $recurringsubtasks = SubTask::
                where('user_id', Auth::user()['id']) // Filter by user_id in SubTask
                ->where('task_type_id', 2) // Recurring tasks
                ->whereRaw('FIND_IN_SET(?, days)', [$today]) 
                // ->whereJsonContains('days', $today) // Check if today's day is in 'days' column
                ->with('task', 'status') // Eager load the parent task
                ->get();
    
            $one_timesubtasks = SubTask::
                where('user_id', Auth::user()['id'])
                ->where('task_type_id', 1)
                ->orderBy('deadline', 'asc')
                ->orderBy('status_id', 'asc')
                ->with('task', 'status')
                ->get();

        }
        elseif(Auth::user()['role']=='admin'){
            
        $recurringsubtasks = SubTask:: // Filter by user_id in SubTask
        where('task_type_id', 2) // Recurring tasks
        ->whereRaw('FIND_IN_SET(?, days)', [$today]) 
        // ->whereJsonContains('days', $today) // Check if today's day is in 'days' column
        ->with('task', 'status') // Eager load the parent task
        ->get();

    $one_timesubtasks = SubTask::
        where('task_type_id', 1)
        ->orderBy('deadline', 'asc')
        ->orderBy('status_id', 'asc')
        ->with('task', 'status')
        ->get();
        }
        return response()->json([
            'status'=> true,
            'message'=> 'HomePage View',
            'recurringsubtasks'=> $recurringsubtasks,
            'one_timesubtasks'=> $one_timesubtasks,
        ], 200);

        // return view('dashboard', compact('recurringsubtasks', 'one_timesubtasks'));
    }
    
    public function task_list(){
        if(!Auth::check()){
            return response()->json([
                'status'=> false,
                'message'=> 'Login Required to Proceed',
            ], 401);
        }
        if(Auth::user()['role']=='user'){
            $task = Task::where('user_id', Auth::user()['id'])->get();
        }
        elseif(Auth::user()['role']=='admin'){
            $task = Task::all();

        }
        if($task->isEmpty()){
            return response()->json([
                'status'=>false,
                'message'=> 'No Task Added Yet',
            ]);
        }
        else{

            return response()->json([
                'status'=>true,
                'message'=>'Epic List Page View',
                'task'=> $task,
            ]);
        }
    }

    public function task_view($task_id){
        $task = Task::with('status')->findOrFail($task_id);
        $subtasks = SubTask::with('status')->where('task_id', $task_id)->get();
        
        return response()->json([
            'status'=> true,
            'message'=> 'Parent Task View Page',
            'task'=> $task,
            'subtasks'=> $subtasks
        ], 200);
        // dd($task);

        // return view('epic_view', compact('task', 'subtasks'));

    }

    public function subtask_view($task_id, $subtask_id)
    {
        $subtask = SubTask::with('status', 'task')->where('task_id', $task_id)->findOrFail($subtask_id);
        return response()->json([
            'status'=> true,
            'message'=> 'Subtask View Page',
            'subtask'=> $subtask
        ]);
    }

    public function subtasks(){
        if(Auth::user()['role']=='user'){
            $tasks = Task::with(['subtask.status', 'subtask.task_type'])->where('user_id', Auth::user()['id'])->get();
        }
        elseif(Auth::user()['role']=='admin'){
            $tasks = Task::with(['subtask.status', 'subtask.task_type'])->get();
        }
        return response()->json([
            'status'=> true,
            'message'=> 'All Subtasks',
            'tasks'=> $tasks
        ]);
        // return view('subtask_view', compact('tasks'));
    }


}
