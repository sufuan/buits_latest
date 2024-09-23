<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'post_status', 'user_id', 'phone', 'usertype', 'session', 'department',
        'gender', 'image', 'skills', 'transaction_id', 'custom_form'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
