<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PeakForm</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="upper_login">
        <img src="images/login.png">
    </div>

    <div class="login-container">
        <form class="login-form">
            <div class="form-group">
                <input type="email" id="email" placeholder="Email">
            </div>
            
            <div class="form-group">
                <input type="password" id="password" placeholder="Password">
            </div>
            
        </form>
    </div>
        <div class = "lower_login">
            {{-- <a href="{{ route('dashboard_1') }}"> --}}
              <button class="login-btn" type="submit"> Log in </button>
            {{-- </a> --}}
            
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
        
            <button class="google-btn">
                <i class="fab fa-google"></i>
                Continue with Google
            </button>
        </div>
    
</body>
</html>