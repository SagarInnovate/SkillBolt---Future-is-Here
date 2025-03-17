<!-- resources/views/emails/referral-confirmed.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Confirmed - SkillBolt.dev</title>
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
        .referral-details {
            background-color: #eef2ff;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
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
        <h1>Referral Confirmed!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $referrer->name }},</p>
        
        <p>Great news! Someone you referred has just joined SkillBolt.dev. Thanks for spreading the word!</p>
        
        <div class="referral-details">
            <h3>Referral Details</h3>
            <p><strong>Date:</strong> {{ $referral->created_at->format('F j, Y') }}</p>
            <p><strong>New User:</strong> {{ substr($referral->referredUser->name, 0, 1) }}*** (Name partially hidden for privacy)</p>
            <p><strong>Status:</strong> Confirmed</p>
        </div>
        
        <p>Your referral is now in "pending" status. Once they complete the required actions, you'll earn your commission of ₹{{ number_format($commissionRate, 2) }}!</p>
        
        <p>Keep sharing your referral link to earn more rewards!</p>
        
        <div style="text-align: center;">
            <a href="{{ route('affiliate.dashboard') }}" class="button">View Your Dashboard</a>
        </div>
        
        <p>Want to refer more friends? Here's your referral link:</p>
        <p style="word-break: break-all; background-color: #f3f4f6; padding: 10px; border-radius: 4px;">{{ url('/?ref=' . $referrer->affiliateDetails->affiliate_code) }}</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>If you have any questions, please contact our support team at support@skillbolt.dev</p>
    </div>
</body>
</html>