<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <h1>New Order Notification</h1>
    <p>Dear Admin,</p>
    <p>We are pleased to inform you that a new order has been created on the TakersPay application.</p>
    <p>Order Details:</p>
    <ul>
        <li><strong>Order ID:</strong> {{ $order?->reference }}</li>
        <li><strong>Customer Email:</strong> {{ $order?->user?->email }}</li>
        <li><strong>Order Type:</strong> {{ $order?->type }}</li>
        <li><strong>Asset Type:</strong> {{ $order?->asset }}</li>
        <li><strong>Order Date:</strong> {{ $order?->created_at->format('F j, Y, g:i a') }}</li>
    </ul>
    <p>Please log in to the admin panel to view more details.</p>
    <p>Thank you,</p>
    <p>The TakersPay Team</p>
</body>

</html>
