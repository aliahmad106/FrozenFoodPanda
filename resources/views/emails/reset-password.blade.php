<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
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
        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #0088cc;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
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
        .url-display {
            word-break: break-all;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-snowflake"></i>
            </div>
            <h1>Reset Your Password</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account at FrozenFoodPanda.</p>
            
            <center>
                <a href="{{ url('reset-password/' . $token) }}" class="button">Reset Password</a>
            </center>
            
            <div class="warning-box">
                <p><strong>Important:</strong> This password reset link will expire in 60 minutes.</p>
                <p>If you did not request a password reset, no further action is required and your account remains secure.</p>
            </div>

            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
            
            <div class="url-display">
                {{ url('reset-password/' . $token) }}
            </div>
            
            <p>For security reasons, this password reset request was received from:</p>
            <ul>
                <li><strong>IP Address:</strong> {{ request()->ip() }}</li>
                <li><strong>Browser:</strong> {{ request()->header('User-Agent') }}</li>
                <li><strong>Time:</strong> {{ now()->format('M d, Y, h:i A') }}</li>
            </ul>
            
            <p>If you have any questions or concerns, please contact our support team.</p>
        </div>
        <div class="footer">
            <p>© 2025 FrozenFoodPanda. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            <p>123 Frozen Lane, Iceville • (555) 123-4567 • info@frozenfoodpanda.com</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>