<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #e21b70;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Status Update</h1>
        </div>
        <div class="content">
            <p>Hello!</p>
            <p>Your order #{{ $order->id }} status has been updated to {{ $order->status }}.</p>
            
            <p>Order Details:</p>
            <ul>
                <li>Order ID: #{{ $order->id }}</li>
                <li>New Status: {{ $order->status }}</li>
                <li>Total Amount: ${{ number_format($order->total, 2) }}</li>
            </ul>

            <p>If you have any questions about your order, please don't hesitate to contact us.</p>

            <div class="footer">
                <p>Regards,<br>Frozen Food Panda Team</p>
            </div>
        </div>
    </div>
</body>
</html>