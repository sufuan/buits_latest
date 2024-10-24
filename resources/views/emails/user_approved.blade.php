<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approved</title>
</head>
<body>
    <h1>Dear {{ $user->name }},</h1>
    <p>We are pleased to inform you that your account has been approved!</p>
    <p>Your Member ID: <strong>{{ $user->member_id }}</strong></p>
    <p>You can now log in to your account.</p>
    <p>Best Regards,<br>Your App Team</p>
</body>
</html>
