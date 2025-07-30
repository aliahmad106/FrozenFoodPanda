<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We Received Your Message</title>
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
        .info-box {
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
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0088cc;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-snowflake"></i>
            </div>
            <h1>Thank You for Contacting Us!</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>Thank you for reaching out to FrozenFoodPanda. We have received your message regarding "{{ $subject }}" and will get back to you as soon as possible.</p>
            
            <div class="info-box">
                <p><strong>What happens next?</strong></p>
                <p>Our team is reviewing your message and will respond within 24-48 hours during business days. For urgent matters, please call us at (555) 123-4567.</p>
            </div>
            
            <p>While you wait, you might want to:</p>
            <ul>
                <li>Browse our <a href="{{ url('/products') }}">product catalog</a></li>
                <li>Check out our <a href="{{ url('/faq') }}">frequently asked questions</a></li>
                <li>Learn more <a href="{{ url('/about') }}">about us</a></li>
            </ul>
            
            <center>
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
            </center>
            
            <p>If you have any additional questions or information to add to your inquiry, please feel free to reply to this email.</p>
            
            <p>Best regards,<br>The FrozenFoodPanda Team</p>
        </div>
        <div class="footer">
            <p>© 2025 FrozenFoodPanda. All rights reserved.</p>
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            <p>123 Frozen Lane, Iceville • (555) 123-4567 • frozenfoodpanda347@gmail.com</p>
            <p>This is an automated message confirming we received your inquiry.</p>
        </div>
    </div>
</body>
</html>