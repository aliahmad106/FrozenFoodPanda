<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
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
        .order-details {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-details h3 {
            margin-top: 0;
            color: #0088cc;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }
        .order-details ul {
            list-style-type: none;
            padding: 0;
        }
        .order-details ul li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .order-details ul li:last-child {
            border-bottom: none;
        }
        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }
        .status-processing {
            background-color: #0088cc;
            color: white;
        }
        .status-shipped {
            background-color: #17a2b8;
            color: white;
        }
        .status-delivered {
            background-color: #28a745;
            color: white;
        }
        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0088cc;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
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
            <h1>Order Status Update</h1>
        </div>
        <div class="content">
            <p>Hello {{ $order->user->name }},</p>
            <p>Your order #{{ $order->id }} status has been updated to <span class="status status-{{ strtolower($order->status) }}">{{ $order->status }}</span>.</p>
            
            <div class="order-details">
                <h3>Order Details</h3>
                <ul>
                    <li><strong>Order ID:</strong> #{{ $order->id }}</li>
                    <li><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y, h:i A') }}</li>
                    <li><strong>New Status:</strong> {{ $order->status }}</li>
                    <li><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</li>
                </ul>
            </div>

            <p>If you have any questions about your order, please don't hesitate to contact our customer service team.</p>

            <center>
                <a href="{{ route('orders.history') }}" class="button">View Order Details</a>
            </center>

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