<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PeakForm</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">

</head>
<body>

<div class = "main-cont">
    <div class = "left_space">
        <h1 style="font-family: 'Michroma', sans-serif;"> PeakForm </h1>
        <p>Your Personalized Path to Peak Performance </p>
        <img src= "images/logo_5.png">
    </div>

    <div class = "right_space">
    <div class="upper_login">
        <img src="images/login_2.png">
    </div>

    <div class="login-container">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="position-absolute" onclick="togglePassword()">
                    <i id="eyeIcon" class="fa fa-eye"></i>
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                </span> 
                
            </div>
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p style="color: red;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            </div>
            <div class = "mid_login">
                <button type="submit" class="login-btn">Log in</button>
            </div>
        </form>
        <div class = "lower_login">    
            <div class="register-link">
                <p>Doesn't have an account? 
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
    </div>
</div>
    

        <script>
            function togglePassword() {
                const password = document.getElementById("password");
                const icon = document.getElementById("eyeIcon");
        
                if (password.type === "password") {
                    password.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    password.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        </script>
</body>
</html>