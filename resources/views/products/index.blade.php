@extends('layouts.app')

@section('title', 'Premium Frozen Foods')

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
                    <a href="#featured-products" class="btn btn-light btn-lg">
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
        @foreach($categories->take(4) as $category)
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

<div class="container" id="featured-products">
    <div class="search-filter-container mb-4">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}" 
                                    {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="number" name="min_price" class="form-control" 
                               placeholder="Min Price" value="{{ request('min_price') }}">
                        <input type="number" name="max_price" class="form-control" 
                               placeholder="Max Price" value="{{ request('max_price') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <select name="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                        <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>
                            Latest
                        </option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ $product->image_url }}" 
                             class="product-image" 
                             alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
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

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
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
    
    /* Product Card Styles */
    .product-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: white;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .product-image-container {
        height: 200px;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-title {
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .product-description {
        color: #6c757d;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0088cc;
        margin-bottom: 15px;
    }
    
    .product-actions {
        display: flex;
        justify-content: space-between;
    }
    
    .product-actions .btn {
        border-radius: 50px;
    }
    
    /* Search and Filter Styles */
    .search-filter-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection