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

        return view('welcome', compact('testimonials', 'collections'));
    }

    /**
     * New Arrivals page.
     */
    public function newArrivals()
    {
        $products = Product::where('is_new_arrival', true)
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->get();

        return view('frontend.new_arrivals', compact('products'));
    }

    /**
     * Categories page.
     */
    public function categories()
    {
        $tshirtsCategory = \App\Models\Category::where('name', 'T-SHIRTS')->with(['products' => function($query) {
            $query->where('is_active', true);
        }])->first();

        $pinsCategory = \App\Models\Category::where('name', 'PIN BUTTONS')->with(['products' => function($query) {
            $query->where('is_active', true);
        }])->first();

        $tshirts = $tshirtsCategory ? $tshirtsCategory->products : collect([]);
        $pins = $pinsCategory ? $pinsCategory->products : collect([]);

        return view('frontend.categories', compact('tshirts', 'pins'));
    }
}
