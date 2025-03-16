<!-- resources/views/emails/reset-password-otp.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - SkillBolt.dev</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
        }
        .content {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 20px;
        }
        .otp-container {
            text-align: center;
            margin: 30px 0;
        }
        .otp {
            font-size: 32px;
            letter-spacing: 5px;
            font-weight: bold;
            color: #4f46e5;
            background-color: #eef2ff;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/skillbolt-logo.svg') }}" alt="SkillBolt.dev" class="logo">
        <h1>Reset Your Password</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $user->name }},</p>
        
        <p>We received a request to reset your password. Enter the following OTP code to continue with the password reset process:</p>
        
        <div class="otp-container">
            <span class="otp">{{ $otp }}</span>
        </div>
        
        <p>This OTP code is valid for 15 minutes and can only be used once.</p>
        
        <p>If you didn't request a password reset, you can safely ignore this email.</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>Your final year project marketplace</p>
    </div>
</body>
</html>