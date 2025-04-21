<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PeakForm</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="upper_login">
        <img src="images/login.png">
    </div>

    <div class="login-container">
        <form class="login-form" id="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <button class="login-btn" type="submit"> Log in </button>
                @if(session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif
        </form>
    </div>
        <div class = "lower_login">
            
            <div class="register-link">
                <p>Don't have an account? 
                    <a href="{{ route('register') }}">
                    Register
                    </a>
                </p>
            </div>
        
             <div class="divider">
                <span>or</span>
            </div>
        
            <button class="google-btn" onclick="window.location.href='{{ route('google.redirect') }}'">
                <i class="fab fa-google"></i>
                Continue with Google
            </button>
        </div>
    
</body>
</html>