<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminPromotionalBanner;
use App\Models\FrontendSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{


    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }



 




    public function frontend()
    {

        if (is_null($this->user) || !$this->user->can('settings.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view settings !');
        }


        // Retrieve the first or default FrontendSetting record
        $frontendSettings = FrontendSetting::first();

        // Pass the settings to the frontend view
        return view('backend.pages.settings.frontend', compact('frontendSettings'));
    }



    
    public function updateFrontendSettings(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('settings.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view settings !');
        }


        // dd($request->all());
        $request->validate([
            'business_name' => 'nullable|string|max:255',  // Use business_name here
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'about_us_description' => 'nullable|string',
        ]);

        $frontendSettings = FrontendSetting::firstOrCreate();

        // Handle file upload for logo
        if ($request->hasFile('logo')) {
            if ($frontendSettings->logo) {
                \Storage::delete($frontendSettings->logo);
            }
            $frontendSettings->logo = $request->file('logo')->store('logos');
        }

        // Update other settings
        $frontendSettings->business_name = $request->business_name;
        $frontendSettings->phone = $request->phone;
        $frontendSettings->email = $request->email;
        $frontendSettings->address = $request->address;
        $frontendSettings->footer_text = $request->footer_text;
        $frontendSettings->facebook = $request->facebook;
        $frontendSettings->instagram = $request->instagram;
        $frontendSettings->twitter = $request->twitter;
        $frontendSettings->about_us_description = $request->about_us_description;


        // Save the updated settings
        $frontendSettings->save();

        return redirect()->back()->with('success', 'Frontend settings updated successfully.');
    }







    public function promotionalSection()
    {

        if (is_null($this->user) || !$this->user->can('settings.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view settings !');
        }

        
        $banners = AdminPromotionalBanner::all();
        return view('backend.pages.settings.partials.promotional-section', compact('banners'));
    }

    public function storePromotionalBanner(Request $request)
    {
        $request->validate([
            'title.*' => 'required|max:20',
            'sub_title.*' => 'required|max:80',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = new AdminPromotionalBanner();
        $banner->title = $request->title[0]; // Assuming default language is the first
        $banner->sub_title = $request->sub_title[0];

        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('promotional_banner', 'public');
        }

        $banner->save();

        return redirect()->route('promotional-section')->with('success', 'Banner added successfully!');
    }

    public function editPromotionalBanner($id)
    {
        $banner = AdminPromotionalBanner::findOrFail($id);
        return view('backend.pages.settings.partials.edit-promotional-banner', compact('banner'));
    }


    public function updatePromotionalBanner(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:20',
            'sub_title' => 'required|max:80',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = AdminPromotionalBanner::findOrFail($id);
        $banner->title = $request->title;
        $banner->sub_title = $request->sub_title;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('promotional_banner', 'public');
        }

        $banner->save();

        return redirect()->route('promotional-section')->with('success', 'Banner updated successfully!');
    }



    public function deletePromotionalBanner($id)
    {
        $banner = AdminPromotionalBanner::findOrFail($id);

        // Delete the image from storage
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('promotional-section')->with('success', 'Banner deleted successfully!');
    }



    public function togglePromotionalStatus($id, $status)
    {
        $banner = AdminPromotionalBanner::findOrFail($id);
        $banner->status = $status;
        $banner->save();

        // Redirect back to the promotional section with a success message
        return redirect()->route('promotional-section')->with('success', 'Banner status updated successfully!');
    }



    public function featureList()
    {
        // Here you would retrieve data for the feature list
        return view('backend.pages.settings.partials.feature-list'); // Make sure you have a corresponding Blade view
    }

    // Method for Testimonials page
    public function testimonials()
    {
        // Here you would retrieve data for testimonials
        return view('backend.pages.settings.partials.testimonials'); // Make sure you have a corresponding Blade view
    }

    // Method for Contact Us page
    public function contactUs()
    {
        // Here you would handle data for the contact us page
        return view('backend.pages.settings.partials.contact-us'); // Make sure you have a corresponding Blade view
    }


    public function aboutUs()
    {

        
       
        
        $frontendSettings = FrontendSetting::first(); // Retrieve the first entry in FrontendSetting
        return view('backend.pages.settings.partials.about_us_admin', compact('frontendSettings'));
    }
}
