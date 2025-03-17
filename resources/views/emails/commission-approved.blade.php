<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Approved - SkillBolt.dev</title>
<!-- resources/views/emails/commission-approved.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Approved - SkillBolt.dev</title>
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
        .commission-details {
            background-color: #ecfdf5;
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
        <h1>Commission Approved!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $commission->user->name }},</p>
        
        <p>Great news! Your commission has been approved and added to your available balance.</p>
        
        <div class="commission-details">
            <h3>Commission Details</h3>
            <p><strong>Date:</strong> {{ $commission->created_at->format('F j, Y') }}</p>
            <p><strong>Amount:</strong> ₹{{ number_format($commission->amount, 2) }}</p>
            <p><strong>New Available Balance:</strong> ₹{{ number_format($commission->user->affiliateDetails->available_balance, 2) }}</p>
        </div>
        
        <p>You can request a payout once your available balance reaches the minimum threshold of ₹{{ number_format($minPayoutThreshold, 2) }}.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('affiliate.dashboard') }}" class="button">View Your Dashboard</a>
        </div>
        
        <p>Thank you for being part of our affiliate program!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>If you have any questions, please contact our support team at support@skillbolt.dev</p>
    </div>
</body>
</html>
