<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebFrontendController extends Controller
{
    public function homepage(Request $request)
    {
        $today = strtolower(date('l'));
        $userId = Auth::user()->id;
        $userRole = Auth::user()->role;
    
        // Queries for both task types
        $recurringsubtasksQuery = SubTask::where('task_type_id', 2)
            ->whereRaw('FIND_IN_SET(?, days)', [$today])
            ->with('task', 'status');
    
        $one_timesubtasksQuery = SubTask::where('task_type_id', 1)
            ->with('task', 'status');
    
        if ($userRole == 'user') {
            $recurringsubtasksQuery->where('user_id', $userId)->whereNotIn('status_id', [3, 4]);
            $one_timesubtasksQuery->where('user_id', $userId)->whereNotIn('status_id', [3, 4]);
        }
    
        // Apply filters separately
        if ($request->has('recurring_status')) {
            $recurringStatus = $request->input('recurring_status');
            if ($recurringStatus) {
                $recurringsubtasksQuery->where('status_id', $recurringStatus);
            }
        }
    
        if ($request->has('onetime_status')) {
            $onetimeStatus = $request->input('onetime_status');
            if ($onetimeStatus) {
                $one_timesubtasksQuery->where('status_id', $onetimeStatus);
            }
        }
    
        // Execute the queries
        $recurringsubtasks = $recurringsubtasksQuery->orderBy('status_id', 'asc')->get();
        $one_timesubtasks = $one_timesubtasksQuery->orderBy('deadline', 'desc')->orderBy('status_id', 'asc')->get();
    
        return view('web.dashboard', compact('recurringsubtasks', 'one_timesubtasks'));
    }
    

    public function task_list(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $taskquery = Task::query();
        if (Auth::user()['role'] == 'user') {
            $taskquery->where('user_id', Auth::user()['id'])
                ->whereNotIn('status_id', array(3, 4));
        } elseif (Auth::user()['role'] == 'admin') {
            $taskquery->orderBy('status_id', 'asc')->get();
        }

        if($request->has('task_status')){
            $taskstatus = $request->input('task_status');
            if($taskstatus){
                $taskquery->where('status_id', $taskstatus);
            }
        }
        $taskquery->orderBy('deadline', 'asc');
        $task = $taskquery->get();
        
        return view('web/task_list', compact('task'));
    }

    public function task_view($task_id)
    {
        if (Auth::user()['role'] == 'admin') {
            $task = Task::with('status')->findOrFail($task_id);
            $subtasks = SubTask::with('status')->where('task_id', $task_id)
                ->orderBy('status_id', 'asc')->get();
            // dd($task);
        } elseif (Auth::user()['role'] == 'user') {
            $task = Task::with('status')
                ->findOrFail($task_id);
            $subtasks = SubTask::with('status')->where('task_id', $task_id)
                ->orderBy('status_id', 'asc')
                ->whereNotIn('status_id', array(3, 4))->get();
            // dd($task);
        }

        return view('web/task_view', compact('task', 'subtasks'));
    }

    public function subtask_view($task_id, $subtask_id)
    {
        if (Auth::user()['role'] == 'admin') {
            $subtask = SubTask::with('status', 'task')
                ->where('task_id', $task_id)->findOrFail($subtask_id);
        } elseif (Auth::user()['role'] == 'user') {
            $subtask = SubTask::with('status', 'task')
                ->where('task_id', $task_id)->findOrFail($subtask_id);
        }
        return view('web/subtask_view', compact('subtask'));
    }

    public function subtasks()
    {
        if (Auth::user()['role'] == 'user') {
            $task = Task::with(['subtask.status', 'subtask.task_type'])
                ->orderBy('status_id', 'asc')
                ->whereNotIn('status_id', array(3, 4))
                ->where('user_id', Auth::user()['id'])->get();
        } elseif (Auth::user()['role'] == 'admin') {
            $task = Task::with(['subtask.status', 'subtask.task_type'])
                ->orderBy('status_id', 'asc')
                ->get();
        }
        return view('web/subtasks', compact('task'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');  
        $keywords = explode(' ', $keyword);     
        $taskResults = collect();              
        $subTaskResults = collect();           
    
        foreach ($keywords as $keyword) {
            $taskResults = $taskResults->merge(
                Task::where('title', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('deadline', 'like', "%$keyword%")
                    ->with('subtask')  // Eager load subtasks
                    ->orderBy('created_at', 'desc')->get()
            );
        
            $subTaskResults = $subTaskResults->merge(
                SubTask::where('title', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('deadline', 'like', "%operator: $keyword%")
                ->orWhere('days', 'like', "%$keyword%")
                ->orderBy('created_at', 'desc')->get()
            );
        }
        $keys = implode(' ', $keywords);
        $tasks = $taskResults;
        $subtasks = $subTaskResults;
        // $search = preg_replace("/($keyword)/i", "<b></b>", $taskResults);

        // dd($search);
    
        // Return the view with the search results
        // return view('web.search', [
        //     'tasks' => $taskResults,
        //     'subtasks' => $subTaskResults
        // ]);

        return view('web/search', compact('tasks', 'subtasks', 'keys'));
    }

    public function profile(){
        $user = User::findOrFail(Auth::user()['id']);
        $task = Task::where('user_id', Auth::user()['id'])->count();
        $completedtask = Task::where('user_id', Auth::user()['id'])->Where('status_id', '3')->count();
        $pendingtask = Task::where('user_id', Auth::user()['id'])->Where('status_id', '1')->count();
        $inprogresstask = Task::where('user_id', Auth::user()['id'])->Where('status_id', '2')->count();
        return view('web.profile', compact('user', 'task', 'completedtask', 'pendingtask', 'inprogresstask'));
    }
    
}