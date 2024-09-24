<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // Show the volunteer setting page
    public function volunteer()
    {
        $setting = Setting::firstOrCreate([]);
        return view('backend.pages.settings.volunteerSetting', compact('setting'));
    }

    // Handle the AJAX toggle
    public function toggleVolunteerStatus(Request $request)
    {
        $setting = Setting::first();
        $setting->volunteer_application_enabled = $request->input('volunteer_application_enabled');
        $setting->save();

        return response()->json(['success' => true]);
    }


    public function frontend()
    {
        $setting = Setting::firstOrCreate([]);
        return view('backend.pages.settings.frontend');
    }

    // // Handle the AJAX toggle
    // public function toggleVolunteerStatus(Request $request)
    // {
    //     $setting = Setting::first();
    //     $setting->volunteer_application_enabled = $request->input('volunteer_application_enabled');
    //     $setting->save();

    //     return response()->json(['success' => true]);
    // }
}
