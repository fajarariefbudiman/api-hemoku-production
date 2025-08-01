<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OTP Anda</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div
        style="background-color: white; max-width: 500px; margin: auto; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.05); border-top: 5px solid #A12020;">
        <h2 style="color: #A12020; margin-top: 0;">Kode OTP Anda</h2>
        <p>Gunakan kode berikut untuk reset password akun Anda:</p>
        <div style="background-color: #f0f0f0; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
            <span
                style="font-size: 32px; letter-spacing: 8px; color: #A12020; font-weight: bold;">{{ $otp }}</span>
        </div>
        <p>Kode ini akan <strong>kadaluarsa dalam 10 menit</strong>.</p>
        <br>
        <p style="color: #888;">Salam hangat,</p>
        <p style="color: #A12020; font-weight: bold;">Tim Hemoku</p>
    </div>
</body>

</html>
