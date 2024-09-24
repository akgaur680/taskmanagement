<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = 'subtask';
    protected $primaryKey ='id';
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'task_type_id',
        'deadline',
        'days',
        'status_id',
        'user_id',
    ];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function task_type(){
        return $this->belongsTo(Task_Type::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
