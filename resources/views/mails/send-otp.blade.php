<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email</title>
</head>

<body style="font-family: 'Arial', sans-serif;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">

        <h2 style="text-align: center; color: #333;">Your OTP for Signup</h2>

        <p>Hello ,</p>

        <p>Your OTP for signup is: <strong>{{ $otp }}</strong></p>

        <p>Use this OTP to verify your account.</p>

        <p>If you didn't request this OTP, please ignore this email.</p>

        <p>Thanks,<br> Your App Team</p>

    </div>

</body>

</html>
