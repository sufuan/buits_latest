<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\FrontendSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmailSettingController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



    public function index()
    {
        if (is_null($this->user) || !$this->user->can('emails.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view emails !');
        }

        return view('backend.pages.settings.email-setting.index');
    }


    
    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('emails.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create emails !');
        }


        $request->validate([
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'copyright_text' => 'nullable|string',
            'button' => 'nullable|string',
            'button_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
        ]);
    
        $data = $request->only([
            'title', 'body', 'footer_text', 'copyright_text', 'button', 
            'button_url', 'about_us', 'contact_us',
        ]);
    
        // Retrieve social links from FrontendSetting
        $frontendSettings = FrontendSetting::first();
    
        // Add URLs based on request data, fallback to FrontendSetting if enabled but URL missing
        $data['facebook'] = $request->facebook_enabled ? ($request->facebook_url ?? $frontendSettings->facebook) : null;
        $data['instagram'] = $request->instagram_enabled ? ($request->instagram_url ?? $frontendSettings->instagram) : null;
        $data['twitter'] = $request->twitter_enabled ? ($request->twitter_url ?? $frontendSettings->twitter) : null;
    
        // Handle image uploads
        foreach (['image', 'logo', 'icon'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $data[$imageField] = $request->file($imageField)->store('email_templates', 'public');
            }
        }
    
        // Retrieve the first existing template, if it exists, and update it; otherwise, create a new one
        $template = EmailTemplate::first();
    
        if ($template) {
            $template->update($data);
        } else {
            $template = EmailTemplate::create($data);
        }
    
        return redirect()->back()->with('success', 'Email Template saved successfully!');
    }
    
}
