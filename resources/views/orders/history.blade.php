@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-history me-2"></i>Order History</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                            </div>
                            <h5 class="mb-3">No orders yet</h5>
                            <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Browse Products
                            </a>
                        </div>
                    @else
                        <div class="order-history-container">
                            @foreach($orders as $order)
                                <div class="order-card mb-4 border rounded shadow-sm">
                                    <div class="card-header bg-white py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-0">Order #{{ $order->id }}</h5>
                                                <p class="text-muted mb-0 small">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'processing' ? 'primary' : ($order->status === 'delivered' ? 'info' : 'secondary')) }} rounded-pill px-3 py-2">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Delivery Address</h6>
                                                    <p class="mb-0">{{ $order->delivery_address }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">Order Summary</h6>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Total Items:</span>
                                                        <span>{{ $order->items->sum('quantity') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Total Amount:</span>
                                                        <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-outline-primary mt-3" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#order_{{ $order->id }}">
                                            <i class="fas fa-list-ul me-2"></i>View Order Details
                                        </button>

                                        <div class="collapse mt-3" id="order_{{ $order->id }}">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th class="text-center">Quantity</th>
                                                            <th class="text-center">Price</th>
                                                            <th class="text-center">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($order->items as $item)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        @if($item->product && $item->product->image_url)
                                                                            <div class="me-3" style="width: 50px; height: 50px;">
                                                                                <img src="{{ asset($item->product->image_url) }}" 
                                                                                    alt="{{ $item->product->name }}"
                                                                                    class="img-fluid rounded" 
                                                                                    style="max-height: 50px; max-width: 50px; object-fit: contain;">
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product not available' }}</h6>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">{{ $item->quantity }}</td>
                                                                <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                                                <td class="text-center">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                            <td class="text-center"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($order->status === 'delivered')
                                                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-shopping-bag me-2"></i>Buy Again
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-download me-2"></i>Download Invoice
                                                </a>
                                            @elseif($order->status === 'processing')
                                                <span class="text-muted">Your order is being processed</span>
                                                <a href="#" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times me-2"></i>Cancel Order
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-history-container {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .order-history-container::-webkit-scrollbar {
        width: 6px;
    }

    .order-history-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .order-history-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .order-history-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .table-responsive {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar {
        width: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection