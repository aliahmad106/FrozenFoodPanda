<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0088cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-section {
            background-color: #e6f7ff;
            border-radius: 4px;
            padding: 15px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        table td:first-child {
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-snowflake"></i>
            </div>
            <h1>New Contact Form Submission</h1>
        </div>
        <div class="content">
            <p>A new message has been submitted through the contact form on your website.</p>
            
            <table>
                <tr>
                    <td>Name:</td>
                    <td>{{ $name }}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{ $email }}</td>
                </tr>
                @if($phone)
                <tr>
                    <td>Phone:</td>
                    <td>{{ $phone }}</td>
                </tr>
                @endif
                <tr>
                    <td>Subject:</td>
                    <td>{{ $subject }}</td>
                </tr>
            </table>
            
            <div class="message-box">
                <h3>Message:</h3>
                <p>{{ $userMessage }}</p>
            </div>
            
            <div class="info-section">
                <h3>Submission Details:</h3>
                <p><strong>IP Address:</strong> {{ $ip }}</p>
                <p><strong>Browser:</strong> {{ $userAgent }}</p>
                <p><strong>Time:</strong> {{ $time }}</p>
            </div>
            
            <p>You can reply directly to this email to respond to the sender.</p>
        </div>
        <div class="footer">
            <p>© 2025 FrozenFoodPanda. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            <p>123 Frozen Lane, Iceville • (555) 123-4567 • frozenfoodpanda347@gmail.com</p>
        </div>
    </div>
</body>
</html>