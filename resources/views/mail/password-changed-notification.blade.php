<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Changed Notification</title>
</head>

<body>
    <h1>Password Changed</h1>
    <p>Dear {{ $user?->metaData?->first_name ?? 'User' }},</p>
    <p>We wanted to let you know that your password was successfully changed. If you did not make this change, please
        contact our support team immediately.</p>
    <p>If you have any questions or need further assistance, please do not hesitate to reach out to us.</p>
    <p>Thank you,</p>
    <p>The Takerspay Team</p>
</body>

</html>
