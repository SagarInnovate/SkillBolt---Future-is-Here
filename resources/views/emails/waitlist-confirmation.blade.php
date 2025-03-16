<!-- resources/views/emails/waitlist-confirmation.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SkillBolt.dev Waitlist</title>
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
        .referral-section {
            background-color: #eef2ff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #4f46e5;
        }
        .referral-link {
            background-color: white;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            word-break: break-all;
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
        <h1>Thanks for joining our waitlist!</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $waitlist->name ?? 'there' }},</p>
        
        <p>Thanks for joining the SkillBolt.dev waitlist! We're excited to have you on board as we prepare to launch India's first AI-powered final-year project marketplace.</p>
        
        <p>You're now on our priority list and will be among the first to know when we launch. We're working hard to bring you a platform that will revolutionize how engineering students approach their final year projects.</p>
        
        <div class="referral-section">
            <h3>Refer friends & earn rewards!</h3>
            <p>Share your unique referral link with friends and earn ₹100 for each person who signs up using your link!</p>
            
            <p><strong>Your referral link:</strong></p>
            <div class="referral-link">
                {{ url('/') }}?ref={{ $waitlist->referral_code ?? Str::random(8) }}
            </div>
            
            <p>Top referrers will get:</p>
            <ul>
                <li>Early access to the platform</li>
                <li>Free premium projects</li>
                <li>Exclusive perks and benefits</li>
            </ul>
        </div>
        
        <p>We'll keep you updated with our progress and let you know when we're ready to launch!</p>
        
        <p>Best regards,<br>The SkillBolt.dev Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>Your final year project marketplace</p>
    </div>
</body>
</html>