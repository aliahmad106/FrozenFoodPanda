@extends('layouts.app')

@section('title', 'Order Management')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-shopping-bag me-2 text-primary"></i>Order Management</h2>
                <div class="d-flex">
                    <div class="input-group">
                        <input type="text" id="orderSearch" class="form-control" placeholder="Search orders...">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <ul class="nav nav-pills" id="orderStatusFilter">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-status="all">All Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="pending">Pending</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="processing">Processing</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="shipped">Shipped</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="delivered">Delivered</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-status="cancelled">Cancelled</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-sort me-1"></i>Sort By
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" data-sort="newest">Newest First</a></li>
                                    <li><a class="dropdown-item" href="#" data-sort="oldest">Oldest First</a></li>
                                    <li><a class="dropdown-item" href="#" data-sort="highest">Highest Amount</a></li>
                                    <li><a class="dropdown-item" href="#" data-sort="lowest">Lowest Amount</a></li>
                                </ul>
                            </div>
                        </div>
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
                                    <th>Payment</th>
                                    <th>Date</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="order-row" data-status="{{ $order->status }}">
                                    <td class="ps-4">
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $order->user->name }}</h6>
                                                <small class="text-muted">{{ $order->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                                    </td>
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
                                    <td>
                                        <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} rounded-pill px-3 py-2">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders</span>
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary-light rounded-circle p-3 me-3">
                            <i class="fas fa-shopping-bag fa-lg text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Total Orders</h6>
                            <h3 class="mb-0">{{ $orders->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success-light rounded-circle p-3 me-3">
                            <i class="fas fa-check-circle fa-lg text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Completed</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'delivered')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning-light rounded-circle p-3 me-3">
                            <i class="fas fa-clock fa-lg text-warning"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Pending</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-danger-light rounded-circle p-3 me-3">
                            <i class="fas fa-times-circle fa-lg text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Cancelled</h6>
                            <h3 class="mb-0">{{ $orders->where('status', 'cancelled')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .user-avatar {
        width: 36px;
        height: 36px;
        background-color: var(--light-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
    }
    
    .bg-primary-light {
        background-color: rgba(0, 136, 204, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1);
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Order search functionality
    const searchInput = document.getElementById('orderSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.order-row');
            
            tableRows.forEach(row => {
                const orderId = row.querySelector('td:first-child').textContent.toLowerCase();
                const customerName = row.querySelector('h6').textContent.toLowerCase();
                const customerEmail = row.querySelector('small').textContent.toLowerCase();
                
                if (orderId.includes(searchTerm) || customerName.includes(searchTerm) || customerEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Order status filter
    const statusLinks = document.querySelectorAll('#orderStatusFilter .nav-link');
    statusLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active state
            statusLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            const status = this.getAttribute('data-status');
            const tableRows = document.querySelectorAll('.order-row');
            
            tableRows.forEach(row => {
                if (status === 'all' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    
    // Sort functionality
    const sortLinks = document.querySelectorAll('[data-sort]');
    sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const sortBy = this.getAttribute('data-sort');
            const tableRows = Array.from(document.querySelectorAll('.order-row'));
            const tbody = document.querySelector('tbody');
            
            tableRows.sort((a, b) => {
                if (sortBy === 'newest') {
                    const dateA = new Date(a.querySelector('td:nth-child(6) div').textContent);
                    const dateB = new Date(b.querySelector('td:nth-child(6) div').textContent);
                    return dateB - dateA;
                } else if (sortBy === 'oldest') {
                    const dateA = new Date(a.querySelector('td:nth-child(6) div').textContent);
                    const dateB = new Date(b.querySelector('td:nth-child(6) div').textContent);
                    return dateA - dateB;
                } else if (sortBy === 'highest') {
                    const amountA = parseFloat(a.querySelector('td:nth-child(3) span').textContent.replace('$', '').replace(',', ''));
                    const amountB = parseFloat(b.querySelector('td:nth-child(3) span').textContent.replace('$', '').replace(',', ''));
                    return amountB - amountA;
                } else if (sortBy === 'lowest') {
                    const amountA = parseFloat(a.querySelector('td:nth-child(3) span').textContent.replace('$', '').replace(',', ''));
                    const amountB = parseFloat(b.querySelector('td:nth-child(3) span').textContent.replace('$', '').replace(',', ''));
                    return amountA - amountB;
                }
                return 0;
            });
            
            // Clear and re-append sorted rows
            tableRows.forEach(row => row.remove());
            tableRows.forEach(row => tbody.appendChild(row));
        });
    });
});
</script>
@endpush
@endsection