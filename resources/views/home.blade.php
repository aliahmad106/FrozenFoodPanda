@extends('layouts.app')

@section('title', 'Welcome to FrozenFoodPanda')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-md-7 hero-content">
                <div class="hero-badge mb-3">
                    <i class="fas fa-snowflake me-2"></i>Premium Quality
                </div>
                <h1 class="hero-title">Frozen Foods Delivered to Your Door</h1>
                <p class="hero-subtitle">Discover our selection of high-quality frozen foods that are convenient, delicious, and ready when you are.</p>
                <div class="hero-buttons">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Shop Now
                    </a>
                    <a href="#about-us" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Learn More
                    </a>
                </div>
            </div>
            <div class="col-md-5 d-none d-md-block">
                <div class="hero-image-container">
                    <img src="https://images.unsplash.com/photo-1615719413546-198b25453f85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=736&q=80" 
                         alt="Frozen Food Selection" 
                         class="hero-image">
                    <div class="hero-image-badge">
                        <span>Free Delivery</span>
                        <small>on orders over $50</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<div class="container featured-categories py-5">
    <h2 class="text-center mb-4">Browse Categories</h2>
    <div class="row">
        @foreach($categories->take(4) as $index => $category)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('products.index', ['category' => $category->category_id]) }}" class="text-decoration-none">
                    <div class="category-card">
                        @php
                            $categoryImages = [
                                'Frozen Meals' => 'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
                                'Homemade Dishes' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
                                'Desserts' => 'https://images.unsplash.com/photo-1488900128323-21503983a07e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80',
                                'Side Dishes' => 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
                                'default' => 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'
                            ];
                            
                            $categoryIcons = [
                                'Frozen Meals' => 'fas fa-utensils',
                                'Homemade Dishes' => 'fas fa-home',
                                'Desserts' => 'fas fa-ice-cream',
                                'Side Dishes' => 'fas fa-carrot',
                                'default' => 'fas fa-snowflake'
                            ];
                            
                            $image = $categoryImages[$category->name] ?? $categoryImages['default'];
                            $icon = $categoryIcons[$category->name] ?? $categoryIcons['default'];
                        @endphp
                        
                        <div class="category-image">
                            <img src="{{ $image }}" alt="{{ $category->name }}" class="img-fluid">
                        </div>
                        <div class="category-overlay">
                            <div class="category-icon">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <h5 class="category-title">{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<!-- Featured Products -->
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Featured Products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">View All</a>
    </div>
    
    <div class="row">
        @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card animate-on-scroll">
                    <div class="product-image-container">
                        <img src="{{ $product->image_url }}" 
                             class="product-image" 
                             alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                        <p class="product-price">${{ number_format($product->price, 2) }}</p>
                        <div class="product-actions">
                            <a href="{{ route('products.show', $product->product_id) }}" 
                               class="btn btn-primary">View Details</a>
                            <button class="btn btn-outline-primary add-to-cart-btn" 
                                    data-product-id="{{ $product->product_id }}">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- About Us Section -->
<div class="container-fluid py-5 bg-light" id="about-us">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="p-4 bg-white rounded-lg shadow-sm">
                    <img src="https://images.unsplash.com/photo-1553787499-6f9133860278?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80" 
                         alt="About FrozenFoodPanda" 
                         class="img-fluid rounded">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">About FrozenFoodPanda</h2>
                <p class="lead mb-4">We're passionate about bringing quality frozen foods to your doorstep.</p>
                <p>At FrozenFoodPanda, we believe that convenience shouldn't compromise quality. That's why we've partnered with the best suppliers to bring you premium frozen foods that are not only easy to prepare but also delicious and nutritious.</p>
                <p>Our mission is to make your life easier by delivering high-quality frozen foods directly to your home, saving you time and ensuring you always have delicious meal options on hand.</p>
                <div class="row mt-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary">
                                <i class="fas fa-truck-fast fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Fast Delivery</h5>
                                <p class="mb-0 text-muted">Right to your doorstep</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary">
                                <i class="fas fa-medal fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Premium Quality</h5>
                                <p class="mb-0 text-muted">Only the best products</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-primary">
                                <i class="fas fa-snowflake fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Properly Frozen</h5>
                                <p class="mb-0 text-muted">Temperature controlled</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <div class="me-3 text-primary">
                                <i class="fas fa-leaf fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Eco-Friendly</h5>
                                <p class="mb-0 text-muted">Sustainable packaging</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="container py-5">
    <h2 class="text-center mb-5">What Our Customers Say</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="card-text">"The quality of the frozen foods from FrozenFoodPanda is exceptional. Everything arrives perfectly frozen and tastes amazing when prepared. Highly recommend!"</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="user-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">Loyal Customer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="card-text">"As a busy professional, FrozenFoodPanda has been a game-changer for me. I always have delicious meals ready to go, and the delivery is always prompt and reliable."</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="user-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Regular Customer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                    <p class="card-text">"I love the variety of products available. From ready meals to frozen fruits for my smoothies, FrozenFoodPanda has everything I need. The website is also very easy to navigate."</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="user-avatar me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Emily Rodriguez</h6>
                            <small class="text-muted">New Customer</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="container-fluid py-5 bg-light" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <h2 class="mb-4">Contact Us</h2>
                <p class="mb-4">Have questions or feedback? We'd love to hear from you! Fill out the form and we'll get back to you as soon as possible.</p>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3 text-primary">
                        <i class="fas fa-map-marker-alt fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Our Location</h5>
                        <p class="mb-0">123 Frozen Lane, Iceville</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3 text-primary">
                        <i class="fas fa-phone fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Phone Number</h5>
                        <p class="mb-0">(555) 123-4567</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <div class="me-3 text-primary">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Email Address</h5>
                        <p class="mb-0">frozenfoodpanda347@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
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
                        
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number (Optional)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                        <option value="" selected disabled>Select a subject</option>
                                        <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="Product Question" {{ old('subject') == 'Product Question' ? 'selected' : '' }}>Product Question</option>
                                        <option value="Order Issue" {{ old('subject') == 'Order Issue' ? 'selected' : '' }}>Order Issue</option>
                                        <option value="Delivery Problem" {{ old('subject') == 'Delivery Problem' ? 'selected' : '' }}>Delivery Problem</option>
                                        <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                @error('subject')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4" placeholder="Enter your message" required>{{ old('message') }}</textarea>
                                </div>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('privacy_policy') is-invalid @enderror" id="privacy_policy" name="privacy_policy" required {{ old('privacy_policy') ? 'checked' : '' }}>
                                <label class="form-check-label" for="privacy_policy">
                                    I agree to the <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a> and consent to the processing of my data.
                                </label>
                                @error('privacy_policy')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h3 class="mb-3">Subscribe to Our Newsletter</h3>
                    <p class="mb-4">Stay updated with our latest products, promotions, and recipes!</p>
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-8">
                            <input type="email" class="form-control" placeholder="Enter your email address">
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hero Section Styles */
    .hero-section {
        background: linear-gradient(135deg, #0088cc 0%, #005580 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('https://images.unsplash.com/photo-1547592166-23ac45744acd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80');
        background-size: cover;
        background-position: center;
        opacity: 0.2;
        z-index: 1;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .hero-badge {
        display: inline-block;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.9;
    }
    
    .hero-buttons .btn {
        padding: 12px 24px;
        margin-right: 15px;
        border-radius: 50px;
        font-weight: 500;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .hero-buttons .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    .hero-image-container {
        position: relative;
        z-index: 2;
    }
    
    .hero-image {
        width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        transform: perspective(1000px) rotateY(-15deg);
        transition: all 0.5s ease;
    }
    
    .hero-image:hover {
        transform: perspective(1000px) rotateY(0deg);
    }
    
    .hero-image-badge {
        position: absolute;
        top: 20px;
        right: -15px;
        background-color: #ff6b6b;
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        transform: rotate(10deg);
    }
    
    .hero-image-badge span {
        font-size: 1rem;
    }
    
    .hero-image-badge small {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    
    /* Category Card Styles */
    .featured-categories {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    
    .category-card {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 200px;
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .category-image {
        height: 100%;
        width: 100%;
    }
    
    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .category-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7));
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .category-icon {
        background-color: rgba(255, 255, 255, 0.2);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 24px;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-icon {
        background-color: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }
    
    .category-title {
        font-weight: 600;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* About Us Section Styles */
    .about-us-icon {
        margin-bottom: 20px;
    }
</style>
@endsection