<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



    // Show the volunteer setting page
    public function volunteer()
    {

        if (is_null($this->user) || !$this->user->can('settings.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view settings !');
        }

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


        
        if (is_null($this->user) || !$this->user->can('settings.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view settings !');
        }
        
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
