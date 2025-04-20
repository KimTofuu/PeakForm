<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: grid;
            place-items: center;
            height: 100vh;
            background-color: #f3f3f3;
        }
        .login-container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .google-btn {
            display: inline-flex;
            align-items: center;
            background-color: #4285F4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        .google-btn img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <a href="{{ route('google.redirect') }}" class="google-btn">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
            Sign in with Google
        </a>
    </div>
</body>
</html>
