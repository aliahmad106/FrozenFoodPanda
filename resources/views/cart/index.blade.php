@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="cart-container">
        @if($cartItems->isEmpty())
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                </div>
                <h3>Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Cart Items ({{ $cartItems->sum('quantity') }})</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr id="cart-item-{{ $item->id }}">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3" style="width: 60px; height: 60px;">
                                                            @if($item->product && $item->product->image_url)
                                                                <img src="{{ asset($item->product->image_url) }}" 
                                                                     alt="{{ $item->product->name }}" 
                                                                     class="img-fluid rounded"
                                                                     style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                                            @else
                                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                    <i class="fas fa-box text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product not available' }}</h6>
                                                            @if($item->product)
                                                                <small class="text-muted">{{ $item->product->category->name }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                                <td class="text-center">
                                                    <div class="quantity-control mx-auto" style="width: 100px;">
                                                        <button type="button" class="quantity-btn" data-action="decrease" data-cart-item-id="{{ $item->id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="cart-quantity-input" value="{{ $item->quantity }}" 
                                                               min="1" max="10" data-cart-item-id="{{ $item->id }}">
                                                        <button type="button" class="quantity-btn" data-action="increase" data-cart-item-id="{{ $item->id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <span id="subtotal-{{ $item->id }}">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <button class="btn btn-sm btn-outline-danger remove-from-cart-btn" data-cart-item-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span id="cart-total">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong id="final-total">${{ number_format($total, 2) }}</strong>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update final total when cart total changes
        const cartTotalElement = document.getElementById('cart-total');
        const finalTotalElement = document.getElementById('final-total');
        
        if (cartTotalElement && finalTotalElement) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'characterData' || mutation.type === 'childList') {
                        finalTotalElement.textContent = cartTotalElement.textContent;
                    }
                });
            });
            
            observer.observe(cartTotalElement, { 
                characterData: true, 
                childList: true,
                subtree: true
            });
        }
    });
</script>
@endpush
@endsection