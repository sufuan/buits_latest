<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'image',
        'logo',
        'icon',
        'button',
        'button_url',
        'footer_text',
        'copyright_text',
         
        'about_us',
        'contact_us',
        'facebook',
        'instagram',
        'twitter',
        'status'
    ];
}
