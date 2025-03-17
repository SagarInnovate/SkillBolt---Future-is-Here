<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement Unlocked - SkillBolt.dev</title>
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
        .achievement {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .achievement-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .achievement-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .achievement-description {
            font-size: 16px;
            opacity: 0.9;
        }
        .achievement-points {
            font-size: 18px;
            margin-top: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
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
        <h1>Achievement Unlocked!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        
        <p>Congratulations! You've earned a new achievement on SkillBolt.dev!</p>
        
        <div class="achievement">
            <div class="achievement-icon">🏆</div>
            <div class="achievement-name">{{ $achievement->name }}</div>
            <div class="achievement-description">{{ $achievement->description }}</div>
            <div class="achievement-points">+{{ $achievement->points_value }} Points</div>
        </div>
        
        <p>Keep up the great work! Continue referring friends to unlock more achievements and earn higher rewards.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('affiliate.dashboard') }}" class="button">View Your Achievements</a>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>If you have any questions, please contact our support team at support@skillbolt.dev</p>
    </div>
</body>
</html>
