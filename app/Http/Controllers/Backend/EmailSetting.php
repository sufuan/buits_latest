<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailSetting extends Controller
{
    public function index()
    {
        return view('backend.pages.settings.email-setting.index'); // Ensure this path is correct
    }
}
