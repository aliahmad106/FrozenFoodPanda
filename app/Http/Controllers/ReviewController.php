<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller; 

class ReviewController extends Controller
{

    public function index()
    {
        $pendingReviews = Review::where('status', 'pending')
            ->with(['product', 'user'])
            ->latest()
            ->paginate(10);

        $approvedReviews = Review::where('status', 'approved')
            ->with(['product', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    public function moderate(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'moderation_notes' => 'nullable|string|max:500'
        ]);

        $review->update([
            'status' => $request->status,
            'moderation_notes' => $request->moderation_notes,
            'moderated_at' => now(),
            'moderated_by' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Review has been ' . $request->status);
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000'
        ]);

        $review = Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It will be visible after moderation.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review has been deleted.');
    }
}