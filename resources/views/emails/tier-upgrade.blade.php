
<!-- resources/views/emails/tier-upgrade.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tier Upgraded - SkillBolt.dev</title>
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
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
        }
        .tier-upgrade {
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .tier-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .tier-level {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .benefits-list {
            background-color: #f3f4f6;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .benefits-list ul {
            margin: 0;
            padding-left: 20px;
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
        <h1>Tier Upgraded!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        
        <p>Congratulations! You've been upgraded to a higher tier in our affiliate program!</p>
        
        <div class="tier-upgrade">
            <div class="tier-icon">⭐</div>
            <div class="tier-level">Tier {{ $newTier }}</div>
        </div>
        
        <p>Your successful referrals and dedication have earned you this upgrade. Here are the benefits you now enjoy:</p>
        
        <div class="benefits-list">
            <ul>
                <li><strong>Higher Commission Rate:</strong> You now earn ₹{{ $baseCommission + $tierBonus }} per successful referral (includes ₹{{ $tierBonus }} tier bonus)</li>
                <li><strong>Priority Support:</strong> Faster responses to your inquiries</li>
                <li><strong>Special Badge:</strong> Your profile now displays your elevated tier status</li>
            </ul>
        </div>
        
        <p>Keep referring to reach even higher tiers with greater rewards!</p>
        
        <div style="text-align: center;">
            <a href="{{ route('affiliate.dashboard') }}" class="button">View Your Dashboard</a>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>If you have any questions, please contact our support team at support@skillbolt.dev</p>
    </div>
</body>
</html>