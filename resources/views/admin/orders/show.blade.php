@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-file-invoice me-2 text-primary"></i>Order #{{ $order->id }}</h2>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>

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

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Order Items</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="ps-4">Product</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image_url)
                                                    <div class="me-3" style="width: 60px; height: 60px;">
                                                        <img src="{{ asset($item->product->image_url) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="img-fluid rounded"
                                                             style="max-height: 60px; max-width: 60px; object-fit: contain;">
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Product Not Available' }}</h6>
                                                    @if($item->product && $item->product->category)
                                                        <small class="text-muted">{{ $item->product->category->name }}</small>
                                                    @endif
                                                </div>
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
                                    <td class="text-end pe-4"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end pe-4"><strong>Shipping:</strong></td>
                                    <td class="text-end pe-4"><strong>Free</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end pe-4"><strong>Total:</strong></td>
                                    <td class="text-end pe-4"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Order Information</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Order Status</h6>
                        <div class="d-flex align-items-center">
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'processing' => 'bg-info',
                                    'shipped' => 'bg-primary',
                                    'delivered' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    'refunded' => 'bg-secondary'
                                ][$order->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} me-2">{{ ucfirst($order->status) }}</span>
                            <span class="text-muted small">
                                @if($order->status_updated_at)
                                    Updated {{ $order->status_updated_at->diffForHumans() }}
                                @else
                                    Created {{ $order->created_at->diffForHumans() }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Payment Method</h6>
                        <div class="d-flex align-items-center">
                            @if($order->payment_method == 'cod')
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <span>Cash on Delivery</span>
                            @elseif($order->payment_method == 'bank_transfer')
                                <i class="fas fa-university text-primary me-2"></i>
                                <span>Bank Transfer</span>
                            @elseif($order->payment_method == 'easypaisa')
                                <i class="fas fa-mobile-alt text-success me-2"></i>
                                <span>EasyPaisa</span>
                            @elseif($order->payment_method == 'jazzcash')
                                <i class="fas fa-wallet text-danger me-2"></i>
                                <span>JazzCash</span>
                            @else
                                <i class="fas fa-credit-card me-2"></i>
                                <span>{{ $order->payment_method }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Payment Status</h6>
                        <div class="d-flex align-items-center">
                            @php
                                $paymentStatusClass = [
                                    'pending' => 'bg-warning',
                                    'paid' => 'bg-success',
                                    'failed' => 'bg-danger',
                                    'refunded' => 'bg-secondary'
                                ][$order->payment_status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $paymentStatusClass }} me-2">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                    </div>

                    @if($order->payment_receipt)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Payment Receipt</h6>
                            <div class="payment-receipt">
                                <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="d-block">
                                    <img src="{{ asset('storage/' . $order->payment_receipt) }}" alt="Payment Receipt" class="img-fluid rounded border">
                                </a>
                                <div class="mt-2 text-center">
                                    <a href="{{ asset('storage/' . $order->payment_receipt) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> View Full Size
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Order Date</h6>
                        <p class="mb-0">{{ $order->created_at->format('F j, Y g:i A') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Customer</h6>
                        <p class="mb-0">{{ $order->user->name }}</p>
                        <p class="mb-0">{{ $order->user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Delivery Address</h6>
                        <p class="mb-0">{{ $order->delivery_address }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Phone Number</h6>
                        <p class="mb-0">{{ $order->phone_number }}</p>
                    </div>

                    @if($order->admin_notes)
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Admin Notes</h6>
                            <p class="mb-0">{{ $order->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Update Order</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label">Order Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        @if($order->payment_method != 'cod')
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-select">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3">{{ $order->admin_notes }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Order
                            </button>
                        </div>
                    </form>

                    @if($order->status != 'refunded' && $order->status != 'cancelled')
                        <hr>
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#refundModal">
                                <i class="fas fa-undo me-2"></i>Process Refund
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.refund', $order) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refund_amount" class="form-label">Refund Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" max="{{ $order->total }}" name="refund_amount" id="refund_amount" class="form-control" value="{{ $order->total }}" required>
                        </div>
                        <small class="form-text text-muted">Maximum refund amount: ${{ number_format($order->total, 2) }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="refund_reason" class="form-label">Reason for Refund</label>
                        <textarea name="refund_reason" id="refund_reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Process Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection