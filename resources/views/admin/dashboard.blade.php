@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Admin Dashboard</h2>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary-light rounded-circle p-3 me-3">
                            <i class="fas fa-shopping-bag fa-lg text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Orders</h6>
                        </div>
                    </div>
                    <h3 class="mb-0">{{ $totalOrders }}</h3>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $orderGrowth }}%
                        </span>
                        <span class="text-muted ms-2">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-light rounded-circle p-3 me-3">
                            <i class="fas fa-dollar-sign fa-lg text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Revenue</h6>
                        </div>
                    </div>
                    <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $revenueGrowth }}%
                        </span>
                        <span class="text-muted ms-2">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-info-light rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-lg text-info"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Customers</h6>
                        </div>
                    </div>
                    <h3 class="mb-0">{{ $totalCustomers }}</h3>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $customerGrowth }}%
                        </span>
                        <span class="text-muted ms-2">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-light rounded-circle p-3 me-3">
                            <i class="fas fa-box fa-lg text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Products</h6>
                        </div>
                    </div>
                    <h3 class="mb-0">{{ $totalProducts }}</h3>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $productGrowth }}%
                        </span>
                        <span class="text-muted ms-2">vs last month</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Orders</h5>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'bg-warning',
                                                'processing' => 'bg-info',
                                                'shipped' => 'bg-primary',
                                                'delivered' => 'bg-success',
                                                'cancelled' => 'bg-danger'
                                            ][$order->status] ?? 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Reviews -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pending Reviews</h5>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pendingReviews->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No pending reviews to moderate.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($pendingReviews as $review)
                                <div class="list-group-item p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">{{ $review->product->name }}</h6>
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} small"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-2">{{ Str::limit($review->comment, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">By {{ $review->user->name }}</small>
                                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">Moderate</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sales Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Sales Overview</h5>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-period="weekly">Weekly</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-period="monthly">Monthly</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($topProducts as $product)
                            <div class="list-group-item p-3">
                                <div class="d-flex align-items-center">
                                    <div class="product-img me-3" style="width: 50px; height: 50px;">
                                        @if($product->image_url)
                                            <img src="{{ asset($product->image_url) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid rounded"
                                                 style="max-height: 50px; max-width: 50px; object-fit: contain;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $product->category->name }}</small>
                                            <span class="badge bg-success rounded-pill">{{ $product->total_sold }} sold</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-primary-light {
        background-color: rgba(0, 136, 204, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Use actual data from backend
    const weeklyData = {
        labels: {!! json_encode($weeklySales['labels']) !!},
        datasets: [{
            label: 'Sales',
            data: {!! json_encode($weeklySales['data']) !!},
            backgroundColor: 'rgba(0, 136, 204, 0.2)',
            borderColor: '#0088cc',
            borderWidth: 2,
            tension: 0.4,
            pointBackgroundColor: '#0088cc'
        }]
    };
    
    const monthlyData = {
        labels: {!! json_encode($monthlySales['labels']) !!},
        datasets: [{
            label: 'Sales',
            data: {!! json_encode($monthlySales['data']) !!},
            backgroundColor: 'rgba(0, 136, 204, 0.2)',
            borderColor: '#0088cc',
            borderWidth: 2,
            tension: 0.4,
            pointBackgroundColor: '#0088cc'
        }]
    };
    
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    };
    
    let salesChart = new Chart(ctx, {
        type: 'line',
        data: weeklyData,
        options: chartOptions
    });
    
    // Toggle between weekly and monthly data
    const periodButtons = document.querySelectorAll('[data-period]');
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            periodButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const period = this.getAttribute('data-period');
            salesChart.data = period === 'weekly' ? weeklyData : monthlyData;
            salesChart.update();
        });
    });
});
</script>
@endpush
@endsection