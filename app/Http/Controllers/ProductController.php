<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])
            ->where('is_active', true);

        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $query = match ($request->sort_by) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'latest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('name')
        };

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'reviews.user'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function addReview(Request $request, $id)
    {
        \Log::info('Review submission started', [
            'product_id' => $id,
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);
    
        try {
            $request->validate([
                'rating' => 'required|integer|between:1,5',
                'comment' => 'required|string|max:1000'
            ]);
    
            \Log::info('Validation passed');
    
            // Verify that the user has purchased the product
            $hasPurchased = Order::whereHas('items', function($query) use ($id) {
                $query->where('product_id', $id);
            })
            ->where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->exists();
    
            \Log::info('Purchase check result', ['hasPurchased' => $hasPurchased]);
    
            if (!$hasPurchased) {
                \Log::warning('Review rejected - Product not purchased');
                return redirect()->back()->with('error', 'You can only review products you have purchased.');
            }
    
            $review = Review::create([
                'product_id' => $id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'pending'
            ]);
    
            \Log::info('Review created successfully', ['review_id' => $review->id]);
    
            return redirect()->back()->with('success', 'Thank you for your review! It will be visible after moderation.');
    
        } catch (\Exception $e) {
            \Log::error('Error in review submission', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Something went wrong while submitting your review.');
        }
    }    
}