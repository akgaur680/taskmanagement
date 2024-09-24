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
        $task = Task::whereDate('deadline','<',$today)->whereNotIn('status_id', [3,4])->get();
       foreach($task as $tasks){
      
        $tasks->Update(['status_id'=>5]);
        $subtasks = SubTask::where('task_id',$tasks['id'])->whereNotIn('status_id', [3,4])->get();
        foreach($subtasks as $subtask){
            $subtask->update(['status_id'=>5]);
        }
       
       }
       $subtask = SubTask::whereDate('deadline','<',$today)->whereNotIn('status_id', [3,4])->get();
       foreach($subtask as $subtasks )
       $subtasks->update(['status_id'=>5]);

      
    }
    
}
