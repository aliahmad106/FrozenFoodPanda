<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order; 
use App\Models\OrderItem;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
            ->with('product')  // Eager load the product relationship
            ->get();

        // Validate if all products exist before proceeding
        $invalidItems = $cartItems->filter(function($item) {
            return !$item->product;
        });

        if ($invalidItems->count() > 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Some products in your cart are no longer available');
        }

        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $validationRules = [
            'delivery_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,easypaisa,jazzcash',
        ];

        // Add receipt validation for non-COD payment methods
        if ($request->payment_method !== 'cod') {
            $validationRules['payment_receipt'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        $request->validate($validationRules);

        DB::beginTransaction();
        try {
            // Get cart items
            $cartItems = CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty');
            }

            // Calculate total
            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });

            // Handle payment receipt upload
            $receiptPath = null;
            if ($request->hasFile('payment_receipt')) {
                $receiptFile = $request->file('payment_receipt');
                $fileName = time() . '_' . Auth::id() . '.' . $receiptFile->getClientOriginalExtension();
                $receiptPath = $receiptFile->storeAs('payment_receipts', $fileName, 'public');
            }

            // Create order with appropriate status values
            // Note: Using lowercase values to match the enum constraints in the database
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total, 
                'status' => $request->payment_method === 'cod' ? 'pending' : 'processing',
                'delivery_address' => $request->delivery_address,
                'phone_number' => $request->phone_number,
                'payment_method' => $request->payment_method,
                'payment_receipt' => $receiptPath,
                'payment_status' => 'pending' // Using a valid enum value from the migration
            ]);

            // Create order items from cart items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);
            }

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.confirmation', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order placement error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'There was an error processing your order. Please try again: ' . $e->getMessage());
        }
    }
    
    public function confirmation($orderId)
    {
        $order = Order::with(['items.product'])->findOrFail($orderId);
        
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }
    
        return view('checkout.confirmation', [
            'order' => $order,
            'total' => $order->total
        ]);
    }
}