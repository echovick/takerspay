<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - TakersPay</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .header {
            background: linear-gradient(135deg, #B0149A 0%, #CE3F7E 100%);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .welcome-text {
            font-size: 24px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
        }
        .description {
            font-size: 16px;
            color: #718096;
            margin-bottom: 32px;
            line-height: 1.5;
        }
        .otp-container {
            background-color: #f7fafc;
            border: 2px dashed #B0149A;
            border-radius: 12px;
            padding: 30px 20px;
            margin: 32px 0;
            text-align: center;
        }
        .otp-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #B0149A;
            font-family: 'Courier New', monospace;
            letter-spacing: 4px;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .otp-note {
            font-size: 14px;
            color: #e53e3e;
            margin-top: 15px;
            font-weight: 500;
        }
        .instructions {
            background-color: #edf2f7;
            border-left: 4px solid #B0149A;
            padding: 20px;
            margin: 32px 0;
            text-align: left;
            border-radius: 0 6px 6px 0;
        }
        .instructions h3 {
            margin: 0 0 12px 0;
            font-size: 16px;
            color: #2d3748;
            font-weight: 600;
        }
        .instructions ol {
            margin: 0;
            padding-left: 20px;
            color: #4a5568;
        }
        .instructions li {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .footer {
            background-color: #2d3748;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .footer-content {
            font-size: 14px;
            margin-bottom: 16px;
        }
        .footer-links {
            margin-bottom: 16px;
        }
        .footer-links a {
            color: #B0149A;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }
        .footer-links a:hover {
            color: #CE3F7E;
        }
        .copyright {
            font-size: 12px;
            color: #a0aec0;
            margin: 0;
        }
        .security-notice {
            background-color: #fef5e7;
            border: 1px solid #f6e05e;
            border-radius: 6px;
            padding: 16px;
            margin: 24px 0;
            text-align: left;
        }
        .security-notice h4 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #d69e2e;
            font-weight: 600;
        }
        .security-notice p {
            margin: 0;
            font-size: 13px;
            color: #744210;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">TakersPay</div>
            <p class="tagline">Secure Cryptocurrency Trading Platform</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h1 class="welcome-text">Welcome to TakersPay!</h1>
            <p class="description">
                Thank you for creating your account. To complete your registration and secure your account, 
                please verify your email address using the verification code below.
            </p>

            <!-- OTP Container -->
            <div class="otp-container">
                <div class="otp-label">Your Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-note">⏰ This code expires in 10 minutes</div>
            </div>

            <!-- Instructions -->
            <div class="instructions">
                <h3>How to verify your email:</h3>
                <ol>
                    <li>Return to the TakersPay verification page</li>
                    <li>Enter the 6-digit code shown above</li>
                    <li>Click "Verify Email" to complete the process</li>
                </ol>
            </div>

            <!-- Security Notice -->
            <div class="security-notice">
                <h4>🔒 Security Notice</h4>
                <p>
                    If you didn't create a TakersPay account, please ignore this email. 
                    Never share your verification code with anyone. TakersPay will never ask for your 
                    verification code via phone, SMS, or email.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <strong>Need help?</strong> Our support team is here for you.
            </div>
            <div class="footer-links">
                <a href="mailto:support@takerspay.com">Contact Support</a>
                <a href="https://takerspay.com">Visit Website</a>
            </div>
            <p class="copyright">
                © {{ date('Y') }} TakersPay. All rights reserved.<br>
                This is an automated message, please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>