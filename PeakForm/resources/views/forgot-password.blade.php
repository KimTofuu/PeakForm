
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
        <img src= "images/logo_9.png" class="logo-login">
        <img src= "images/workout-7.png" class="icon-login">
    </div>

    <div class = "right_space">
    <div class="login-container2" style="border-radius: 2rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);">
        <h2 style="color:white;">Reset Password</h2>

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