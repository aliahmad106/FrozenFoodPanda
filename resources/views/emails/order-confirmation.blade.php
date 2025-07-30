<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #0088cc 0%, #005580 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            margin-bottom: 15px;
        }
        .logo i {
            font-size: 40px;
            color: white;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        .thank-you {
            text-align: center;
            margin-bottom: 30px;
        }
        .thank-you h2 {
            color: #0088cc;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-summary h3 {
            margin-top: 0;
            color: #0088cc;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }
        .order-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .order-info-item {
            flex: 1;
            min-width: 200px;
            margin-bottom: 15px;
        }
        .order-info-item h4 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #6c757d;
            font-size: 14px;
        }
        .order-info-item p {
            margin: 0;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #dee2e6;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            margin-right: 10px;
            vertical-align: middle;
        }
        .product-name {
            vertical-align: middle;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0088cc;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
        }
        .delivery-info {
            background-color: #e6f7ff;
            border-left: 4px solid #0088cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 5px;
            color: #0088cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-snowflake"></i>
            </div>
            <h1>Order Confirmation</h1>
        </div>
        <div class="content">
            <div class="thank-you">
                <h2>Thank You for Your Order!</h2>
                <p>We've received your order and are working on it now.</p>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="order-info">
                    <div class="order-info-item">
                        <h4>Order Number</h4>
                        <p>#{{ $order->id }}</p>
                    </div>
                    <div class="order-info-item">
                        <h4>Order Date</h4>
                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="order-info-item">
                        <h4>Payment Method</h4>
                        <p>{{ ucfirst($order->payment_method) }}</p>
                    </div>
                    <div class="order-info-item">
                        <h4>Order Status</h4>
                        <p>{{ ucfirst($order->status) }}</p>
                    </div>
                </div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="product-image">
                                @endif
                                <span class="product-name">{{ $item->product ? $item->product->name : 'Product not available' }}</span>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Subtotal:</td>
                        <td class="text-right">${{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Shipping:</td>
                        <td class="text-right">Free</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" class="text-right">Total:</td>
                        <td class="text-right">${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="delivery-info">
                <h4>Delivery Information</h4>
                <p><strong>Address:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Phone:</strong> {{ $order->phone_number }}</p>
                <p><strong>Estimated Delivery:</strong> Within 2-3 business days</p>
            </div>
            
            <center>
                <a href="{{ route('orders.history') }}" class="button">Track Your Order</a>
            </center>
            
            <p>If you have any questions about your order, please contact our customer service team.</p>
            <p>Thank you for shopping with FrozenFoodPanda!</p>
        </div>
        <div class="footer">
            <p>© 2025 FrozenFoodPanda. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            <p>123 Frozen Lane, Iceville • (555) 123-4567 • info@frozenfoodpanda.com</p>
        </div>
    </div>
</body>
</html>