<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            \Log::info('Starting order status update process', [
                'order_id' => $order->id,
                'new_status' => $request->status
            ]);
    
            $request->validate([
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
                'admin_notes' => 'nullable|string',
            ]);
    
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->admin_notes = $request->admin_notes;
            $order->status_updated_at = now();
            
            // Update payment status if provided
            if ($request->has('payment_status')) {
                $order->payment_status = $request->payment_status;
            }
            
            // Automatically mark COD orders as paid when delivered
            if ($order->payment_method == 'cod' && $request->status == 'delivered') {
                $order->payment_status = 'paid';
                \Log::info('COD order marked as paid automatically', [
                    'order_id' => $order->id
                ]);
            }
            
            $order->save();
    
            \Log::info('Attempting to send email', [
                'to_email' => $order->user->email,
                'order_id' => $order->id
            ]);
    
            try {
                Mail::send('emails.order-status-update', [
                    'order' => $order
                ], function($message) use ($order) {
                    \Log::info('Configuring email message', [
                        'recipient' => $order->user->email,
                        'from' => env('MAIL_FROM_ADDRESS')
                    ]);
    
                    $message->to($order->user->email)
                           ->subject('Order Status Update - Frozen Food Panda')
                           ->from(env('MAIL_FROM_ADDRESS'), 'Frozen Food Panda');
                });
    
                \Log::info('Email sent successfully');
            } catch (\Exception $emailError) {
                \Log::error('Email sending failed', [
                    'error' => $emailError->getMessage(),
                    'trace' => $emailError->getTraceAsString()
                ]);
            }
    
            return redirect()->back()->with('success', 'Order status updated successfully');
    
        } catch (\Exception $e) {
            \Log::error('Order status update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
    
    public function processRefund(Request $request, Order $order)
    {
        try {
            \Log::info('Starting refund process', [
                'order_id' => $order->id,
                'refund_amount' => $request->refund_amount
            ]);
    
            $request->validate([
                'refund_amount' => 'required|numeric|min:0|max:' . $order->total,
                'refund_reason' => 'required|string',
            ]);
    
            $order->status = 'refunded';
            $order->payment_status = 'refunded';
            $order->admin_notes = $request->refund_reason;
            $order->status_updated_at = now();
            $order->save();
    
            \Log::info('Attempting to send refund email', [
                'to_email' => $order->user->email,
                'order_id' => $order->id
            ]);
    
            try {
                Mail::send('emails.refund-processed', [
                    'order' => $order,
                    'amount' => $request->refund_amount,
                    'reason' => $request->refund_reason
                ], function($message) use ($order) {
                    \Log::info('Configuring refund email message', [
                        'recipient' => $order->user->email,
                        'from' => env('MAIL_FROM_ADDRESS')
                    ]);
    
                    $message->to($order->user->email)
                           ->subject('Refund Processed for Order #' . $order->id . ' - Frozen Food Panda')
                           ->from(env('MAIL_FROM_ADDRESS'), 'Frozen Food Panda');
                });
    
                \Log::info('Refund email sent successfully');
            } catch (\Exception $emailError) {
                \Log::error('Refund email sending failed', [
                    'error' => $emailError->getMessage(),
                    'trace' => $emailError->getTraceAsString()
                ]);
            }
    
            return redirect()->back()->with('success', 'Refund processed successfully');
    
        } catch (\Exception $e) {
            \Log::error('Refund processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to process refund: ' . $e->getMessage());
        }
    }  
}