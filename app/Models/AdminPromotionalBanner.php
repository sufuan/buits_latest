<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPromotionalBanner extends Model
{
    use HasFactory;

    // Attributes that are mass assignable
    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'status',
    ];

    // Add custom methods or relationships if needed.
}
