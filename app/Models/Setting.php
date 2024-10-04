<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['volunteer_application_enabled'];

    // Set default values
    protected $attributes = [
        'volunteer_application_enabled' => false,
    ];
}