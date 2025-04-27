<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="upper_register">
        <img src="images/register.png">
    </div>
    <form action="{{ route('register') }}" method="POST" class="signup-container">
        @csrf
        <div class="form-group">
            <input type="text" name="Fname" placeholder="First Name" required>
            @error('Fname')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
    
        <div class="form-group">
            <input type="text" name="Lname" placeholder="Last Name" required>
            @error('Lname')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
    
        <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
    
        <div class="mid_register"> 
            <button type="submit" class="signup-btn"> Register </button>
        </div>    
    </form>   
    <div class="lower_register"> 
        <div class="login-link">
            <p>Already have an account? 
                <a href="{{ route('login') }}">
                    Log in
                </a>
            </p>
        </div>
        
        <div class="divider">or</div>
        
        <button class="google-btn" onclick="window.location.href='{{ route('google.redirect') }}'">
            <i class="fab fa-google"></i>
            Continue with Google
        </button>
    </div>
</body>
</html>