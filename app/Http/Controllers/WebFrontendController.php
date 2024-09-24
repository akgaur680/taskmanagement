<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebFrontendController extends Controller
{
    public function homepage()
    {
        $today = strtolower(date('l'));
        if (Auth::user()['role'] == 'user') {
            $recurringsubtasks = SubTask::where('user_id', Auth::user()['id']) // Filter by user_id in SubTask
                ->whereNotIn('status_id', array(3, 4))
                ->where('task_type_id', 2) // Recurring tasks
                ->whereRaw('FIND_IN_SET(?, days)', [$today])
                // ->whereJsonContains('days', $today) // Check if today's day is in 'days' column
                ->with('task', 'status') // Eager load the parent task
                ->orderBy('status_id', 'desc')
                ->get();

            $one_timesubtasks = SubTask::where('user_id', Auth::user()['id'])
                ->whereNotIn('status_id', array(3, 4))
                ->where('task_type_id', 1)
                ->orderBy('deadline', 'desc')
                ->orderBy('status_id', 'asc')
                ->with('task', 'status')
                ->get();
        } elseif (Auth::user()['role'] == 'admin') {

            $recurringsubtasks = SubTask:: // Filter by user_id in SubTask
                where('task_type_id', 2) // Recurring tasks
                ->orderBy('status_id', 'asc')
                ->whereRaw('FIND_IN_SET(?, days)', [$today])
                // ->whereJsonContains('days', $today) // Check if today's day is in 'days' column
                ->with('task', 'status') // Eager load the parent task
                ->get();

            $one_timesubtasks = SubTask::where('task_type_id', 1)
                // ->orderBy('deadline', 'asc')
                ->orderBy('status_id', 'asc')
                ->with('task', 'status')
                ->get();
        }
        return view('web.dashboard', compact('recurringsubtasks', 'one_timesubtasks'));

        // return view('dashboard', compact('recurringsubtasks', 'one_timesubtasks'));
    }

    public function task_list()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()['role'] == 'user') {
            $task = Task::where('user_id', Auth::user()['id'])
                ->whereNotIn('status_id', array(3, 4))
                ->orderBy('status_id', 'asc')
                ->get();
        } elseif (Auth::user()['role'] == 'admin') {
            $task = Task::orderBy('status_id', 'asc')->get();
        }
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