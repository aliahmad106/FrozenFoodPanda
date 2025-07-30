<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        try {
            $cartItems = CartItem::where('user_id', Auth::id())
                ->with('product')  // Eager load the product relationship
                ->get();
    
            $total = $cartItems->sum(function($item) {
                return $item->product ? $item->quantity * $item->price : 0;
            });
    
            return view('cart.index', compact('cartItems', 'total'));
        } catch (\Exception $e) {
            Log::error('Cart view error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to load cart at this time');
        }
    }
    
    public function updateQuantity(Request $request, $cartItemId)
    {
        try {
            $cartItem = CartItem::where('id', $cartItemId)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            $request->validate([
                'quantity' => 'required|integer|min:1|max:10'
            ]);
    
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
    
            // Calculate the new subtotal for this item
            $subtotal = $cartItem->price * $cartItem->quantity;
            
            // Calculate the new cart total
            $total = CartItem::where('user_id', Auth::id())
                ->get()
                ->sum(function($item) {
                    return $item->price * $item->quantity;
                });
    
            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total,
                'message' => 'Cart updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart'
            ], 500);
        }
    }
    
    public function removeFromCart($cartItemId)
    {
        try {
            // Find and delete the cart item
            $deleted = CartItem::where('id', $cartItemId)
                ->where('user_id', Auth::id())
                ->delete();
    
            if (!$deleted) {
                throw new \Exception('Item not found or already removed');
            }
    
            // Get updated cart count
            $newCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            
            // Calculate the new cart total
            $total = CartItem::where('user_id', Auth::id())
                ->get()
                ->sum(function($item) {
                    return $item->price * $item->quantity;
                });
    
            return response()->json([
                'success' => true,
                'count' => $newCount,
                'total' => $total,
                'message' => 'Item removed successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item'
            ], 500);
        }
    }    

    public function addToCart(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['success' => false], 401);
            }
    
            $product = Product::findOrFail($request->product_id); // This will now look for product_id
    
            $cartItem = CartItem::where('product_id', $request->product_id)
                ->where('user_id', Auth::id())
                ->first();
    
            if ($cartItem) {
                $cartItem->quantity += $request->quantity ?? 1;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create([
                    'product_id' => $request->product_id,
                    'user_id' => Auth::id(),
                    'quantity' => $request->quantity ?? 1,
                    'price' => $product->price
                ]);
            }
    
            $count = CartItem::where('user_id', Auth::id())->sum('quantity');
    
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getCartCount()
    {
        try {
            
            if (!Auth::check()) {
                return response()->json(['count' => 0]);
            }
    
            $userId = Auth::id();
    
            $count = CartItem::where('user_id', $userId)->sum('quantity');
    
            return response()->json(['count' => (int)$count]);
            
        } catch (\Exception $e) {
            \Log::error('Cart count error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }    
}