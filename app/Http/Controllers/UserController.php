<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {
            Log::info('Starting profile update');
            
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:255',
            ]);

            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            Log::info('Profile updated successfully', ['user_id' => $user->id]);
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update profile');
        }
    }

    public function orderHistory()
    {
        try {
            Log::info('Fetching order history');
            
            $orders = Order::where('user_id', Auth::id())
                ->with(['orderDetails.product'])
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Order history retrieved', ['count' => $orders->count()]);
            return view('users.order-history', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Order history error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch order history');
        }
    }
}