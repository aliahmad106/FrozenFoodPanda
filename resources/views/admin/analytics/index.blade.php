@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Analytics Dashboard</h2>
                <a href="{{ route('admin.products') }}" class="btn btn-outline-primary">
                    <i class="fas fa-box me-2"></i>Manage Products
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-light-primary me-3">
                            <i class="fas fa-box text-primary"></i>
                        </div>
                        <h5 class="card-title mb-0">Total Products</h5>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 mt-auto">{{ $analytics['totalProducts'] }}</h2>
                    <p class="text-muted mb-0">Products in inventory</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-light-success me-3">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <h5 class="card-title mb-0">Active Products</h5>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 mt-auto">{{ $analytics['activeProducts'] }}</h2>
                    <p class="text-muted mb-0">Currently available</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-light-info me-3">
                            <i class="fas fa-shopping-bag text-info"></i>
                        </div>
                        <h5 class="card-title mb-0">Total Orders</h5>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 mt-auto">{{ $analytics['totalOrders'] }}</h2>
                    <p class="text-muted mb-0">Orders placed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-light-warning me-3">
                            <i class="fas fa-dollar-sign text-warning"></i>
                        </div>
                        <h5 class="card-title mb-0">Total Revenue</h5>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 mt-auto">${{ number_format($analytics['totalRevenue'], 2) }}</h2>
                    <p class="text-muted mb-0">From completed orders</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">Product Performance</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Product</th>
                            <th class="text-center">Orders</th>
                            <th class="text-center">Revenue</th>
                            <th class="text-center">Avg Rating</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($analytics['productAnalytics'] as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if($product->image_url)
                                        <div class="me-3" style="width: 40px; height: 40px;">
                                            <img src="{{ asset($product->image_url) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid rounded"
                                                 style="max-height: 40px; max-width: 40px; object-fit: contain;">
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">{{ $product->order_items_count ?? 0 }}</td>
                            <td class="text-center align-middle">${{ number_format($product->order_items_sum_price_multiply_by_quantity ?? 0, 2) }}</td>
                            <td class="text-center align-middle">
                                @if($product->reviews_avg_rating)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="me-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                @else
                                    <span class="text-muted">No ratings</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 align-middle">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-light-primary {
        background-color: rgba(0, 136, 204, 0.1);
    }
    
    .bg-light-success {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .bg-light-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .text-primary {
        color: var(--primary-color) !important;
    }
    
    .text-success {
        color: var(--success) !important;
    }
    
    .text-info {
        color: #17a2b8 !important;
    }
    
    .text-warning {
        color: var(--warning) !important;
    }
</style>
@endsection