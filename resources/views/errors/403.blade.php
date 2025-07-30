@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container mb-4">
                <div class="error-icon">
                    <i class="fas fa-lock text-danger"></i>
                </div>
                <h1 class="error-code">403</h1>
                <h2 class="error-title mb-4">Access Denied</h2>
            </div>
            
            <p class="lead mb-4">Sorry, you don't have permission to access this page.</p>
            <p class="mb-5">This area might be restricted to certain users or require additional permissions.</p>
            
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
        margin-bottom: 1rem;
    }
    
    .error-code {
        font-size: 6rem;
        font-weight: bold;
        color: var(--dark-gray);
        margin-bottom: 0;
    }
    
    .error-title {
        color: var(--dark-gray);
    }
</style>
@endsection