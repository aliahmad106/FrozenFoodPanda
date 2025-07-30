@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Order History</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="alert alert-info">
            You haven't placed any orders yet.
        </div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Order #{{ $order->id }}</h5>
                        <small class="text-muted">
                            Placed on {{ $order->created_at->format('M d, Y h:i A') }}
                        </small>
                    </div>
                    <div>
                        <span class="badge bg-{{ $order->order_status === 'Delivered' ? 'success' : 'primary' }}">
                            {{ $order->order_status }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>${{ number_format($detail->price, 2) }}</td>
                                        <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                    <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-3">
                        <strong>Delivery Address:</strong> {{ $order->delivery_address }}<br>
                        <strong>Phone Number:</strong> {{ $order->phone_number }}<br>
                        <strong>Payment Method:</strong> {{ $order->payment_method }}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection