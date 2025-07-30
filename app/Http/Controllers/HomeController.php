<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get categories for the featured categories section
        $categories = Category::all();
        
        // Get featured products - only active products
        $featuredProducts = Product::where('is_active', true)
            ->where(function($query) {
                $query->where('featured', true)
                      ->orWhere('is_popular', true);
            })
            ->latest()
            ->take(8)
            ->get();
        
        // If we don't have enough featured products, get the latest active products
        if ($featuredProducts->count() < 8) {
            $additionalProducts = Product::where('is_active', true)
                ->whereNotIn('product_id', $featuredProducts->pluck('product_id')->toArray())
                ->latest()
                ->take(8 - $featuredProducts->count())
                ->get();
            
            $featuredProducts = $featuredProducts->concat($additionalProducts);
        }
        
        return view('home', compact('categories', 'featuredProducts'));
    }
}