@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <div class="success-animation">
                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>
                    <h2 class="mb-3">Thank You for Your Order!</h2>
                    <p class="text-muted mb-4">Your order has been placed successfully. We'll start processing it right away.</p>
                    <div class="order-info mb-4">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="order-info-item">
                                    <span class="text-muted">Order Number:</span>
                                    <strong>{{ $order->id }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="order-info-item">
                                    <span class="text-muted">Order Date:</span>
                                    <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="order-info-item">
                                    <span class="text-muted">Order Total:</span>
                                    <strong>${{ number_format($total, 2) }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="order-info-item">
                                    <span class="text-muted">Payment Method:</span>
                                    <strong>
                                        @if($order->payment_method == 'cod')
                                            Cash on Delivery
                                        @elseif($order->payment_method == 'bank_transfer')
                                            Bank Transfer
                                        @elseif($order->payment_method == 'easypaisa')
                                            EasyPaisa
                                        @elseif($order->payment_method == 'jazzcash')
                                            JazzCash
                                        @else
                                            {{ $order->payment_method }}
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->payment_method != 'cod')
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            @if($order->payment_method == 'bank_transfer')
                                Your bank transfer is being verified. We'll process your order once the payment is confirmed.
                            @elseif($order->payment_method == 'easypaisa')
                                Your EasyPaisa payment is being verified. We'll process your order once the payment is confirmed.
                            @elseif($order->payment_method == 'jazzcash')
                                Your JazzCash payment is being verified. We'll process your order once the payment is confirmed.
                            @endif
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('orders.history') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>View Order History
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Order Details</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Product</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image_url)
                                                    <div class="me-3" style="width: 60px; height: 60px;">
                                                        <img src="{{ asset($item->product->image_url) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="img-fluid rounded"
                                                             style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product Not Available' }}</h6>
                                                    @if($item->product && $item->product->category)
                                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                                        <td class="text-end pe-4 align-middle">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end pe-4"><strong>Subtotal:</strong></td>
                                    <td class="text-end pe-4"><strong>${{ number_format($total, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end pe-4"><strong>Shipping:</strong></td>
                                    <td class="text-end pe-4"><strong>Free</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end pe-4"><strong>Total:</strong></td>
                                    <td class="text-end pe-4"><strong>${{ number_format($total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .success-animation {
        margin: 0 auto;
        width: 80px;
        height: 80px;
    }
    
    .checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #28a745;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #28a745;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #28a745;
        fill: none;
        animation: stroke .6s cubic-bezier(0.650, 0.000, 0.450, 1.000) forwards;
    }
    
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke .3s cubic-bezier(0.650, 0.000, 0.450, 1.000) .8s forwards;
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #28a74533;
        }
    }
    
    .order-info-item {
        display: flex;
        flex-direction: column;
        text-align: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        height: 100%;
    }
</style>
@endsection