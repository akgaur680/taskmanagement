<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = 'report';
    protected $primaryKey = 'id';
    protected $fillable =[
        'user_id',
        'date',
        'checkIn',
        'checkOut',
        'project',
        'taskDetails',
        'remarks',
    ];
}
