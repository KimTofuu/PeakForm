<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h2>Reset Password</h2>

        @if (session('status'))
            <div style="color: green;">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <button type="submit">Send Password Reset Link</button>
            </div>
        </form>
    </div>
</body>
</html>