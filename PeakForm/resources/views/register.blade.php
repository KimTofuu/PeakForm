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

        <div class="form-group">
            <input type="password" placeholder="Confirm Password">
        </div>
       
    </div>
    
    <!-- Privacy Policy Checkbox -->
<!-- Privacy Policy Checkbox -->

<div class="priv_policy">
<form method="GET" action="{{ route('personal_info') }}">
    @csrf
    <div class="mb-4">
        <label for="privacy-policy" class="flex items-center">
            <input type="checkbox" id="privacy-policy" name="privacy_policy" class="mr-2" required>
            I agree to the <a href="#" id="open-privacy-policy" class="privacy-policy-link">Privacy Policy</a>
        </label>
    </div>

    <!-- Submit Button -->
    <a href="{{ route('personal_info') }}">
        <button type="submit" class="signup-btn"> Register </button>
    </a>
</form>
</div>
<!-- Privacy Policy Modal -->
<div id="privacy-policy-modal" class="modal hidden">
    <div class="modal-content">
        <h2>Privacy Policy</h2>
        <p>
            Your Privacy Policy content goes here.
        </p>
        <button id="close-privacy-policy" class="close-btn">Close</button>
    </div>
</div>
</div>

    </div>    
    <div class="lower_register"> 
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


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Open the Privacy Policy Modal
    document.getElementById('open-privacy-policy').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('privacy-policy-modal').style.display = 'flex'; // Show modal
    });

    // Close the Privacy Policy Modal
    document.getElementById('close-privacy-policy').addEventListener('click', function() {
        document.getElementById('privacy-policy-modal').style.display = 'none'; // Hide modal
    });
});
</script>

</body>
</html>