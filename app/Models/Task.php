<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'day',
        'status_id',
        'user_id',
        'assigned_by',
    ];

    public function subtask(){
        return $this->hasMany(SubTask::class, 'task_id');
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
