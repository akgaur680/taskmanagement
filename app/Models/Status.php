<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status'
    ];

    public function subtask(){
        return $this->hasMany(SubTask::class);
    }
    public function task(){
        return $this->hasMany(Task::class);
    }

}
