<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Collection;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Homepage / Dashboard frontend.
     */
    public function index()
    {
        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->get();

        $collections = Collection::active()
            ->orderBy('sort_order')
            ->get();

        $heroSlides = \App\Models\HeroSlide::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('welcome', compact('testimonials', 'collections', 'heroSlides'));
    }

    /**
     * New Arrivals page.
     */
    
    public function newArrivals()
    {
        $products = Product::where('is_new_arrival', true)
            ->where('is_active', true)
            ->with('category')
            ->orderByRaw('sort_order = 0, sort_order')
            ->latest()
            ->get();

        $banner = \App\Models\Banner::firstOrCreate(
            ['page_name' => 'new_arrivals'],
            [
                'image_path' => 'img/Wallpaper.jpeg',
                'title' => 'FRESH DROPS',
                'subtitle' => 'Discover the latest additions to our collection.',
                'text_color' => '#FFFFFF'
            ]
        );

        return view('frontend.new_arrivals', compact('products', 'banner'));
    }

    /**
     * Categories page.
     */
    public function categories()
    {
        $tshirtsCategory = \App\Models\Category::where('name', 'T-SHIRTS')->with(['products' => function($query) {
            $query->where('is_active', true);
        }])->first();

        $pinsCategory = \App\Models\Category::where('name', 'PIN BUTTON')->with(['products' => function($query) {
            $query->where('is_active', true);
        }])->first();

        $tshirts = $tshirtsCategory ? $tshirtsCategory->products : collect([]);
        $pins = $pinsCategory ? $pinsCategory->products : collect([]);

        return view('frontend.categories', compact('tshirts', 'pins'));
    }
}
