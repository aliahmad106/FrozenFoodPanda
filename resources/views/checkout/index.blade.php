@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Shopping Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (!$cartItems || $cartItems->isEmpty())
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                        </div>
                        <h3 class="mb-3">Your cart is empty</h3>
                        <p class="text-muted mb-4">Please add items to your cart before proceeding to checkout.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Summary</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Product</th>
                                        <th scope="col" class="text-center">Price</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product)
                                                        @if($item->product->image_url)
                                                            <div class="me-3" style="width: 60px; height: 60px;">
                                                                <img src="{{ asset($item->product->image_url) }}"
                                                                     alt="{{ $item->product->name }}"
                                                                     class="img-fluid rounded"
                                                                     style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        </div>
                                                    @else
                                                        <span>Product Not Available</span>
                                                    @endif
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

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Delivery Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.place-order') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Hidden fields for cart items -->
                            <input type="hidden" name="total_amount" value="{{ $total }}">
                            @foreach($cartItems as $index => $item)
                                <input type="hidden" name="cart_items[{{$index}}][cart_item_id]" value="{{ $item->id }}">
                                <input type="hidden" name="cart_items[{{$index}}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="cart_items[{{$index}}][quantity]" value="{{ $item->quantity }}">
                                <input type="hidden" name="cart_items[{{$index}}][price]" value="{{ $item->price }}">
                            @endforeach

                            <div class="mb-4">
                                <label for="delivery_address" class="form-label">Delivery Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea name="delivery_address" id="delivery_address" class="form-control @error('delivery_address') is-invalid @enderror" rows="3" placeholder="Enter your full delivery address" required>{{ old('delivery_address', Auth::user()->default_address ?? '') }}</textarea>
                                </div>
                                @error('delivery_address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Please provide your complete address including street, building number, city, and postal code.</small>
                            </div>

                            <div class="mb-4">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', Auth::user()->contact_info ?? '') }}" placeholder="Enter your phone number" required>
                                </div>
                                @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">We'll contact you on this number for delivery updates.</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Payment Method</label>
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method" id="cod" value="cod" checked>
                                            <label class="form-check-label" for="cod">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                                                    <div>
                                                        <span class="fw-bold">Cash on Delivery</span>
                                                        <p class="mb-0 small text-muted">Pay when you receive your order</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                            <label class="form-check-label" for="bank_transfer">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-university text-primary me-2"></i>
                                                    <div>
                                                        <span class="fw-bold">Bank Transfer</span>
                                                        <p class="mb-0 small text-muted">Transfer to our bank account</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method" id="easypaisa" value="easypaisa">
                                            <label class="form-check-label" for="easypaisa">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-mobile-alt text-success me-2"></i>
                                                    <div>
                                                        <span class="fw-bold">EasyPaisa</span>
                                                        <p class="mb-0 small text-muted">Pay via EasyPaisa mobile wallet</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="form-check">
                                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method" id="jazzcash" value="jazzcash">
                                            <label class="form-check-label" for="jazzcash">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-wallet text-danger me-2"></i>
                                                    <div>
                                                        <span class="fw-bold">JazzCash</span>
                                                        <p class="mb-0 small text-muted">Pay via JazzCash mobile wallet</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Details Sections (Initially Hidden) -->
                            <div id="bank_transfer_details" class="payment-details mb-4" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Bank Transfer Details</h5>
                                        <p class="mb-1"><strong>Bank:</strong> National Bank</p>
                                        <p class="mb-1"><strong>Account Name:</strong> FrozenFoodPanda Ltd.</p>
                                        <p class="mb-1"><strong>Account Number:</strong> 1234-5678-9012-3456</p>
                                        <p class="mb-3"><strong>Reference:</strong> Your Name + Phone Number</p>
                                        
                                        <div class="mb-3">
                                            <label for="bank_transfer_receipt" class="form-label">Upload Payment Receipt</label>
                                            <input type="file" class="form-control" id="bank_transfer_receipt" name="payment_receipt" accept="image/*">
                                            <small class="form-text text-muted">Please upload a screenshot of your payment receipt</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="easypaisa_details" class="payment-details mb-4" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">EasyPaisa Payment Details</h5>
                                        <p class="mb-1"><strong>Account Title:</strong> FrozenFoodPanda</p>
                                        <p class="mb-1"><strong>Mobile Number:</strong> 0311-1234567</p>
                                        <p class="mb-3"><strong>Reference:</strong> Your Order Number will be provided after payment</p>
                                        
                                        <div class="mb-3">
                                            <label for="easypaisa_receipt" class="form-label">Upload Payment Screenshot</label>
                                            <input type="file" class="form-control" id="easypaisa_receipt" name="payment_receipt" accept="image/*">
                                            <small class="form-text text-muted">Please upload a screenshot of your payment confirmation</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="jazzcash_details" class="payment-details mb-4" style="display: none;">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">JazzCash Payment Details</h5>
                                        <p class="mb-1"><strong>Account Title:</strong> FrozenFoodPanda</p>
                                        <p class="mb-1"><strong>Mobile Number:</strong> 0300-1234567</p>
                                        <p class="mb-3"><strong>Reference:</strong> Your Order Number will be provided after payment</p>
                                        
                                        <div class="mb-3">
                                            <label for="jazzcash_receipt" class="form-label">Upload Payment Screenshot</label>
                                            <input type="file" class="form-control" id="jazzcash_receipt" name="payment_receipt" accept="image/*">
                                            <small class="form-text text-muted">Please upload a screenshot of your payment confirmation</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">Terms and Conditions</a> and <a href="{{ route('privacy') }}">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check-circle me-2"></i>Place Order
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Cart
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment method toggle
        const paymentRadios = document.querySelectorAll('.payment-method-radio');
        const paymentDetails = document.querySelectorAll('.payment-details');
        const receiptInputs = document.querySelectorAll('input[name="payment_receipt"]');
        
        // Function to toggle payment details
        function togglePaymentDetails() {
            // Hide all payment details sections first
            paymentDetails.forEach(section => {
                section.style.display = 'none';
            });
            
            // Disable all receipt inputs
            receiptInputs.forEach(input => {
                input.disabled = true;
                input.required = false;
            });
            
            // Show the selected payment method details
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const detailsSection = document.getElementById(`${selectedMethod}_details`);
            
            if (detailsSection) {
                detailsSection.style.display = 'block';
                
                // Enable the receipt input for the selected method
                const receiptInput = detailsSection.querySelector('input[type="file"]');
                if (receiptInput && selectedMethod !== 'cod') {
                    receiptInput.disabled = false;
                    receiptInput.required = true;
                }
            }
        }
        
        // Add event listeners to payment method radios
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', togglePaymentDetails);
        });
        
        // Initialize on page load
        togglePaymentDetails();
    });
</script>
@endpush
@endsection