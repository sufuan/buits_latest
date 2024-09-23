<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'start',
        'end',
        'status',
        'is_all_day',
        'description',
        'event_id',
        'countdown', // Add this line

    ];

    // You can add relationships, scopes, and other model methods here
}
