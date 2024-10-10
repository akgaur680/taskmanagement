<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription';
    protected $primaryKey = 'id';
    protected $fillable =[
        'name',
        'stripe_price_id',
        'trial_days',
        'amount',
        'type',
        'enabled',
        'created_at',
        'updated_at',
    ];
}
