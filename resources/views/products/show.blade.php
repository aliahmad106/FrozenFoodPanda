@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->category_id]) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="product-image-wrapper bg-white p-4 rounded shadow-sm">
                <img src="{{ $product->image_url }}" 
                     class="product-detail-image" 
                     alt="{{ $product->name }}">
            </div>
        </div>
        <div class="col-lg-6 product-info">
            <h1 class="mb-2">{{ $product->name }}</h1>
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-primary me-2">{{ $product->category->name }}</span>
                <div class="stars me-2">
                    @php
                        $avgRating = $product->reviews->avg('rating') ?? 0;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $avgRating ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                </div>
                <span class="text-muted">({{ $product->reviews->where('status', 'approved')->count() }} reviews)</span>
            </div>
            
            <h2 class="product-price mb-4">${{ number_format($product->price, 2) }}</h2>
            
            <div class="product-description mb-4">
                <h5>Description</h5>
                <p>{{ $product->description }}</p>
            </div>
            
            <div class="product-actions mb-4">
                <form class="d-flex align-items-center">
                    <div class="quantity-control me-3">
                        <button type="button" class="quantity-btn" data-action="decrease">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" class="cart-quantity-input" id="quantity-{{ $product->product_id }}" value="1" min="1" max="10">
                        <button type="button" class="quantity-btn" data-action="increase">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-primary add-to-cart-btn" 
                            data-product-id="{{ $product->product_id }}">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </form>
            </div>
            
            <div class="product-features mt-4">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon me-3 text-primary">
                                <i class="fas fa-snowflake fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Properly Frozen</h6>
                                <p class="mb-0 text-muted small">Temperature controlled</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon me-3 text-primary">
                                <i class="fas fa-truck-fast fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Fast Delivery</h6>
                                <p class="mb-0 text-muted small">Right to your doorstep</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon me-3 text-primary">
                                <i class="fas fa-medal fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Premium Quality</h6>
                                <p class="mb-0 text-muted small">Only the best products</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon me-3 text-primary">
                                <i class="fas fa-leaf fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Eco-Friendly</h6>
                                <p class="mb-0 text-muted small">Sustainable packaging</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h3 class="mb-0">Customer Reviews</h3>
                </div>
                <div class="card-body">
                    @if(auth()->check())
                        @php
                            $orderQuery = \App\Models\Order::whereHas('items', function($query) use ($product) {
                                $query->where('product_id', $product->product_id);
                            })
                            ->where('user_id', auth()->id())
                            ->where('status', 'delivered');

                            $hasPurchased = $orderQuery->exists();

                            $order = \App\Models\Order::with('items')
                                ->where('user_id', auth()->id())
                                ->where('status', 'delivered')
                                ->first();
                        @endphp

                        @if($hasPurchased)
                            <div class="review-form mb-4">
                                <h5 class="mb-3">Write a Review</h5>
                                <form action="{{ route('reviews.store', $product->product_id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">Your Rating</label>
                                        <div class="rating-stars mb-2">
                                            <div class="d-flex">
                                                @for($i = 5; $i >= 1; $i--)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                                        <label class="form-check-label" for="rating{{ $i }}">
                                                            {{ $i }} <i class="fas fa-star text-warning"></i>
                                                        </label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Your Review</label>
                                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Share your experience with this product..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Review
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i> You can write a review after purchasing and receiving this product.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i> Please <a href="{{ route('login') }}" class="alert-link">login</a> to write a review.
                        </div>
                    @endif

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

                    <div class="reviews mt-4">
                        <h5 class="mb-3">{{ $product->reviews->where('status', 'approved')->count() }} Reviews</h5>
                        
                        @if($product->reviews->where('status', 'approved')->count() > 0)
                            <div class="review-summary mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <div class="display-4 fw-bold">{{ number_format($avgRating, 1) }}</div>
                                        <div class="stars mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $avgRating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="text-muted">{{ $product->reviews->where('status', 'approved')->count() }} ratings</p>
                                    </div>
                                    <div class="col-md-9">
                                        @for($i = 5; $i >= 1; $i--)
                                            @php
                                                $count = $product->reviews->where('status', 'approved')->where('rating', $i)->count();
                                                $percentage = $product->reviews->where('status', 'approved')->count() > 0 
                                                    ? ($count / $product->reviews->where('status', 'approved')->count()) * 100 
                                                    : 0;
                                            @endphp
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-2" style="width: 60px;">{{ $i }} <i class="fas fa-star text-warning"></i></div>
                                                <div class="progress flex-grow-1" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="ms-2" style="width: 40px;">{{ $count }}</div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            @foreach($product->reviews->where('status', 'approved')->sortByDesc('created_at') as $review)
                                <div class="review-item mb-4">
                                    <div class="d-flex">
                                        <div class="user-avatar me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ $review->user->name }}</h6>
                                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <div class="stars mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize quantity input
        const quantityInput = document.getElementById('quantity-{{ $product->product_id }}');
        if (quantityInput) {
            quantityInput.value = 1; // Set default value
        }
        
        // Quantity buttons
        const quantityBtns = document.querySelectorAll('.quantity-btn');
        
        quantityBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                let currentValue = parseInt(quantityInput.value) || 1; // Default to 1 if NaN
                
                if (action === 'increase') {
                    if (currentValue < 10) {
                        currentValue += 1;
                        quantityInput.value = currentValue;
                    }
                } else if (action === 'decrease') {
                    if (currentValue > 1) {
                        currentValue -= 1;
                        quantityInput.value = currentValue;
                    }
                }
            });
        });
    });
</script>
@endpush

<style>
    .product-detail-image {
        width: 100%;
        max-height: 400px;
        object-fit: contain;
    }

    .product-image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 400px;
    }

    .product-price {
        font-size: 1.8rem;
        color: var(--secondary-color);
        font-weight: var(--font-weight-bold);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background-color: var(--light-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
    }

    .rating-stars .form-check-input:checked + .form-check-label {
        font-weight: bold;
    }
</style>
@endsection