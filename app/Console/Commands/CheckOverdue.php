<?php

namespace App\Console\Commands;

use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Console\Command;

class CheckOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It Checks the date & changes status to OverDue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = strtolower(date('Y-m-d'));
        $task = Task::whereDate('deadline','<',$today)->get();
       foreach($task as $tasks){
      
        $tasks->Update(['status_id'=>5]);
       
       }
       $subtask = SubTask::whereDate('deadline','<',$today)->get();
       foreach($subtask as $subtasks )
       $subtasks->update(['status_id'=>5]);

    //    if($task['status_id']==5){
    //     $subtask = SubTask::where('task_id',$task['id'])->get();
    //     $subtask->update(['status_id'=>5]);
    // }
    }
    
}
