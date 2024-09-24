<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebTaskController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            if(!Auth::check()){
                return redirect()->route('login');
            }
            $request->validate([
                 'deadline'=>'required|date',
                 'title'=> 'required',
                 'description'=> 'required',
             ]);
             $date = new \DateTime($request->date);
             $day = $date->format('l');
     
             $task = $request->all();
             $task['day'] = $day;
             $task['user_id'] = Auth::user()['id'];
     
             Task::create($task);
     
             return redirect()->back()->with('success', 'Task Added Successfully');
         }
         catch (\Illuminate\Validation\ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput();

         }
     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id){
        $task = Task::where('user_id', Auth::user()['id'])->findOrFail($id);
        return response()->json([
            'status'=> true,
            'message'=> $id.' Ready to Edit',
            'task'=> $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $request->validate([
                 'deadline'=>'required|date',
                 'title'=> 'required',
                 'description'=> 'required',
                 'status_id'=> 'required',
             ]);
             $date = new \DateTime($request->date);
             $day = $date->format('l');
     
             $task = $request->all();
             $task['day'] = $day;
             $task['user_id'] = Auth::user()['id'];
     
             $id = Task::findOrFail($id);
             $id->update($task);
     
             return redirect()->back()->with('success', 'Task Updated Successfully');
         }
         catch (\Illuminate\Validation\ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput();
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task Deleted Successfully');

        
        
    }

}
