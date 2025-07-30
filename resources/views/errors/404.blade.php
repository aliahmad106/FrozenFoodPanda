@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container mb-4">
                <div class="error-icon">
                    <i class="fas fa-snowflake fa-spin"></i>
                </div>
                <h1 class="error-code">404</h1>
                <h2 class="error-title mb-4">Page Not Found</h2>
            </div>
            
            <p class="lead mb-4">Oops! It looks like this page has melted away.</p>
            <p class="mb-5">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Go to Homepage
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .error-container {
        padding: 2rem;
    }
    
    .error-icon {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    
    .error-code {
        font-size: 6rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0;
    }
    
    .error-title {
        color: var(--dark-gray);
    }
    
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .fa-spin {
        animation: spin 10s linear infinite;
    }
</style>
@endsection