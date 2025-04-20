<!DOCTYPE html>
<html>
<head>
    <title>Account Registered</title>
</head>
<body>
    <h2>Hello {{ $user->Fname }}!</h2>
    <p>Your account ({{ $user->email }}) has just been registered and is now active.</p>
    <p>If this wasn't you, please contact our support team immediately.</p>
    <br>
    <p>– PeakForm Team</p>
</body>
</html>
