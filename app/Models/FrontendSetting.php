<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontendSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'logo',
        'phone',
        'email',
        'address',
        'footer_text',
        'facebook',
        'instagram',
        'twitter',
        'about_us_description',

    ];
}
