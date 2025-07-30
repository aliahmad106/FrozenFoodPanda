@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container mb-4">
                <div class="error-icon">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                </div>
                <h1 class="error-code">500</h1>
                <h2 class="error-title mb-4">Server Error</h2>
            </div>
            
            <p class="lead mb-4">Oops! Something went wrong on our end.</p>
            <p class="mb-5">We're experiencing some technical difficulties. Please try again later or contact our support team if the problem persists.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Go to Homepage
                </a>
                <button onclick="window.location.reload()" class="btn btn-outline-primary">
                    <i class="fas fa-redo-alt me-2"></i>Try Again
                </button>
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