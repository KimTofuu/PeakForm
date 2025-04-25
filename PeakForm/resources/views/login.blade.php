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
                <span class="position-absolute" onclick="togglePassword()">
                    <i id="eyeIcon" class="fa fa-eye"></i>
                </span>
            </div>
            
        </form>
    </div>
        <div class = "mid_login">
            <a href="{{ route('dashboard_1') }}">
              <button class="login-btn"> Log in </button>
            </a>
        </div>
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