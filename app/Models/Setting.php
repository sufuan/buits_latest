<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // The table name should match the 'settings' table created by the migration
    protected $table = 'settings';

    // You can also define the fillable attributes if needed
    protected $fillable = ['volunteer_application_enabled'];
}
