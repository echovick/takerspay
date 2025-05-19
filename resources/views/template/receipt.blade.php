<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TakersPay - Order Receipt</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #fcf2f6;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            background-color: white;
            overflow: hidden;
            border-top: 6px solid #ec407a;
            min-height: 100vh;
        }

        .header {
            background-color: #ec407a;
            color: white;
            padding: 22px;
            display: flex;
            justify-content: space-between;
        }

        .header-left h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header-left p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }

        .header-right {
            text-align: right;
        }

        .header-right p:first-child {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .header-right p:last-child {
            font-size: 14px;
        }

        .section {
            padding: 24px;
            border-bottom: 1px solid #f8bbd0;
        }

        .section-title {
            color: #ec407a;
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .label {
            color: #ec407a;
            font-weight: 500;
            font-size: 15px;
        }

        .value {
            font-weight: 600;
            font-size: 15px;
        }

        .status-badge {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .timeline {
            margin-top: 18px;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 18px;
            position: relative;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: 0;
            height: 16px;
            width: 16px;
            background-color: #f48fb1;
            border-radius: 50%;
            margin-top: 4px;
        }

        .timeline-content {
            margin-left: 30px;
        }

        .timeline-content p {
            margin: 0;
        }

        .timeline-content p:first-child {
            font-weight: 600;
            font-size: 15px;
        }

        .timeline-content p:last-child {
            font-size: 14px;
            color: #555;
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .user-info:before {
            content: '';
            width: 46px;
            height: 46px;
            background-color: #f8bbd0;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #ec407a;
            margin-right: 18px;
            flex-shrink: 0;
        }

        .user-details p {
            margin: 0;
        }

        .user-details p:first-child {
            font-size: 16px;
            font-weight: 600;
        }

        .user-details p:last-child {
            color: #ec407a;
            font-size: 14px;
            font-weight: 500;
        }

        .footer {
            padding: 24px;
            background-color: #fce4ec;
            text-align: center;
        }

        .footer p {
            margin: 6px 0;
            font-size: 13px;
            color: #555;
        }

        .footer p:last-child {
            color: #ec407a;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>TakersPay</h1>
                <p>Secure Crypto Trading</p>
            </div>
            <div class="header-right">
                <p>ORDER RECEIPT</p>
                <p>{{ $OrderDateTime }}</p>
            </div>
        </div>

        <!-- Order Info -->
        <div class="section">
            <div class="row">
                <span class="label">Reference:</span>
                <span class="value">{{ $OrderReference }}</span>
            </div>
            <div class="row">
                <span class="label">Status:</span>
                <span class="value status-badge">{{ $OrderStatus }}</span>
            </div>
            <div class="row">
                <span class="label">Transaction Type:</span>
                <span class="value">{{ $BuyOrSell }}</span>
            </div>
        </div>

        <!-- Asset Details -->
        <div class="section">
            <h2 class="section-title">Asset Details</h2>
            <div class="row">
                <span class="label">Asset:</span>
                <span class="value">{{ $AssetName }}</span>
            </div>
            <div class="row">
                <span class="label">Quantity:</span>
                <span class="value">{{ $AssetValue }}</span>
            </div>
            <div class="row">
                <span class="label">USD Rate:</span>
                <span class="value">${{ $DollarPrice }}</span>
            </div>
            <div class="row">
                <span class="label">NGN Rate:</span>
                <span class="value">NGN {{ $NairaPrice }}</span>
            </div>
            <div class="row">
                <span class="label">Trade Currency:</span>
                <span class="value">{{ $TradeCurrency }}</span>
            </div>
        </div>

        <!-- Timeline -->
        <div class="section">
            <h2 class="section-title">Transaction Timeline</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <p>Order Created</p>
                        <p>{{ $OrderCreatedAt }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <p>Order Confirmed</p>
                        <p>{{ $ConfirmedAt }}</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-content">
                        <p>Order Fulfilled</p>
                        <p>{{ $FulfilledAt }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="section">
            <h2 class="section-title">User Information</h2>
            <div class="user-info">
                <div class="user-details">
                    <p>{{ $UserName }}</p>
                    <p>@ {{ $UserTag }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This receipt serves as confirmation of your crypto transaction.</p>
            <p>TakersPay &copy; {{ $CurrentYear }}</p>
        </div>
    </div>
</body>

</html>
