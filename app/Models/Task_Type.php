<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_Type extends Model
{
    use HasFactory;
    protected $table = 'task_type';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function subtask(){
        return $this->hasMany(SubTask::class);
    }
}
