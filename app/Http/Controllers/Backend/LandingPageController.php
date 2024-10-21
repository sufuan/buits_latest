<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminPromotionalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{

    public function frontend()
    {
        // $setting = Setting::firstOrCreate([]);
        return view('backend.pages.settings.frontend');
    }
    public function promotionalSection()
    {
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
    
}
