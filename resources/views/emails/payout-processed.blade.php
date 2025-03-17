<!-- resources/views/emails/payout-processed.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payout Processed - SkillBolt.dev</title>
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
        .payout-details {
            background-color: #eef2ff;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .transaction-id {
            font-family: monospace;
            background-color: #f3f4f6;
            padding: 5px 10px;
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
        <h1>Payout Processed!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $payout->user->name }},</p>
        
        <p>Good news! Your payout request has been processed and the funds are on their way to you.</p>
        
        <div class="payout-details">
            <h3>Payout Details</h3>
            <p><strong>Date:</strong> {{ $payout->payout_date->format('F j, Y') }}</p>
            <p><strong>Amount:</strong> ₹{{ number_format($payout->amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payout->payment_method)) }}</p>
            @if($payout->transaction_id)
            <p><strong>Transaction ID:</strong> <span class="transaction-id">{{ $payout->transaction_id }}</span></p>
            @endif
        </div>
        
        <p>Depending on your payment method, it may take 1-3 business days for the funds to appear in your account.</p>
        
        <div style="text-align: center;">
            <a href="{{ route('affiliate.payouts') }}" class="button">View Payout History</a>
        </div>
        
        <p>Thank you for being part of our affiliate program!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} SkillBolt.dev. All rights reserved.</p>
        <p>If you have any questions, please contact our support team at support@skillbolt.dev</p>
    </div>
</body>
</html>
