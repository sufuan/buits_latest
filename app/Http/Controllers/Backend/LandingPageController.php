<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function frontend()
    {
        // $setting = Setting::firstOrCreate([]);
        return view('backend.pages.settings.frontend');
    }

    // public function fixedData()
    // {
    //     return view('admin.settings.fixed-data');
    // }

    public function promotionalSection()
    {
        return view('backend.pages.settings.partials.promotional-section');
    }

    public function featureList()
    {
        return view('backend.pages.settings.partials.feature-list');
    }

    public function testimonials()
    {
        return view('backend.pages.settings.partials.testimonials');
    }

    public function contactUs()
    {
        return view('backend.pages.settings.partials.contact-us');
    }
}
