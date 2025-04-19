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
    <div class="signup-container">
        <div class="form-group">
            <input type="text" placeholder="First Name">
        </div>

        <div class="form-group">
            <input type="text" placeholder="Last Name">
        </div>
        
        <div class="form-group">
            <input type="email" placeholder="Email">
        </div>
        
        <div class="form-group">
            <input type="password" placeholder="Password">
        </div>
    </div>
    <div class="lower_register"> 
        <button class="signup-btn" onclick="window.location.href='personal_info_1.html'">
            Sign Up
          </button>
        
        <div class="login-link">
            <p>Already have an account? 
                <a href="{{ route('login') }}">
                    Log in
                </a>
            </p>
        </div>
        
        <div class="divider">or</div>
        
        <button class="google-btn">
            <i class="fab fa-google"></i>
            Continue with Google
        </button>
    </div>
</body>
</html>