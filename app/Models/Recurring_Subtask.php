<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurring_Subtask extends Model
{
    use HasFactory;
    protected $table = 'recurring_subtask';
    protected $primaryKey = 'id';
    protected $fillable =[
        'subtask_id',
        'days'
    ];

    public function subtask(){
        return $this->belongsTo(SubTask::class);
    }
}
