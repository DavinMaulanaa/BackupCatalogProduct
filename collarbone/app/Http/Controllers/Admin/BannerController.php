<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Update the banner for a specific page.
     */
    public function update(Request $request, $page_name)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'text_color' => 'nullable|string|max:20', // e.g. #FFFFFF or text-white
            'image_url_type' => 'nullable|in:file,url',
            'image_url' => 'nullable|url',
        ]);

        $banner = Banner::where('page_name', $page_name)->firstOrFail();

        // Handle Image Upload or URL
        if ($request->hasFile('image_path')) {
            // Delete old image if it exists in storage (not if it's a seed or url)
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            
            $path = $request->file('image_path')->store('banners', 'public');
            $banner->image_path = $path;
        } elseif ($request->input('image_url_type') === 'url' && $request->filled('image_url')) {
             $banner->image_path = $request->image_url;
        }

        $banner->title = $request->input('title');
        $banner->subtitle = $request->input('subtitle');
        $banner->text_color = $request->input('text_color');
        $banner->save();

        return redirect()->back()->with('success', 'Banner updated successfully!');
    }
}
