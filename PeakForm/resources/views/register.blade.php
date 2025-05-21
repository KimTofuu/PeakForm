<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
    
</head>
<body>

<div class = "main-cont">
    <div class = "left_space">
        <img src= "images/logo_7.png">
        <h1>Your Personalized Path <br> to Peak Performance.</h1>
        <p>Unlock your full potential with PeakForm’s personalized fitness and <br> nutrition plans. 
            From adaptive workouts to easy meal suggestions,
            <br> everything you need to succeed is at your fingertips.
        </p>
        
    </div>

    <div class = "right_space">
        <div class="upper_register">
            <img src="images/signup.png">
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
        
        <div class="form-group-pass" style="position: relative;">
            <input type="password" name="password" id="password" placeholder="Password" required oninput="validatePassword()">
            <span class="toggle-password" style="cursor: pointer;" onclick="togglePassword()">
                <i id="eyeIcon1" class="fa fa-eye"></i>
            </span>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror

            <!-- Password Rules -->
            <div id="password-feedback" style="display: none;">
    <ul id="password-rules" style="list-style: none; padding:0; margin: 0; font-size: 13px; color: red;">
        <li id="rule-length" class="rule">❌ At least 8 characters</li>
        <li id="rule-upper" class="rule">❌ At least 1 uppercase letter</li>
        <li id="rule-lower" class="rule">❌ At least 1 lowercase letter</li>
        <li id="rule-number" class="rule">❌ At least 1 number</li>
        <li id="rule-special" class="rule">❌ At least 1 special character (@$!%*?&)</li>
    </ul>
</div>
        </div>


        <div class="form-group-pass" style="position: relative;">
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                <span class="toggle-password-2" style=" cursor: pointer;" onclick="togglePassword2()">
                    <i id="eyeIcon2" class="fa fa-eye"></i>
                </span>
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
    


    <div class="privacy_policy">
        <input type="checkbox" id="privacyCheck" name="privacy" required style="margin-right: 8px;">
        <label for="privacyCheck">
            I agree to the <a href="#" onclick="openPrivacyModal(event)">Privacy Policy</a>
        </label>
    </div>

    <div id="privacyModal" class="privacy-modal">
        <div class="privacy-modal-content">
            <span class="close" onclick="closePrivacyModal()">&times;</span>
            <h2>Privacy Policy <br><br> </h2>
            <p>

Welcome to PeakForm. Your privacy is important to us. This Privacy <br> Policy outlines how we collect, use, store, and protect the information <br> you provide to us through our platform.

<br><br><b>1. Information We Collect</b>
<br> When you register for and use PeakForm, we may collect the following information:

<br>a. Personal Identification Data: Name, Email Address, and Age

<br>b. Demographic Information: Gender

<br>c. Physical Information: Weight, height, fitness goals, and other health-related data

<br>d. Usage Data: Information about how you use our platform and interact with features

<br><br><b>2. How We Use Your Information</b>
<br>The data we collect is used to:

<br>a. Personalize your fitness and meal plans

<br>b. Monitor progress and provide insights

<br>c. Improve our services and user experience

<br>d. Communicate with you about updates, tips, or relevant information

<br>e. Ensure the security and integrity of our platform

<br><br><b>3. Data Protection and Security</b>
<br>We take your privacy seriously and implement appropriate technical and organizational measures to protect your personal data from unauthorized access, misuse, or disclosure.

<br>All sensitive information is encrypted and stored securely. Access is limited to authorized personnel only.

<br><br><b>4. Sharing Your Information</b>
<br>PeakForm does not sell, rent, or lease your personal data to third parties.

<br>We may share your data only in the following cases:

<br>a. With service providers that help us deliver our services (e.g., analytics or hosting)

<br>b. If required by law or in response to a legal request

<br>c. To protect our rights or users’ safety

<br><br><b>5. Your Rights and Choices</b>
<br>You have the right to:

<br>a. Access, update, or delete your personal data

<br>b. Withdraw consent at any time (note: this may affect your ability to use our services)

<br>c. Request a copy of the data we store about you

<br>d. To exercise these rights, contact us at [email ng PeakForm].

<br><br><b>6. Retention of Data</b>
<br>We retain your personal data for as long as you use PeakForm and for a reasonable time thereafter to comply with legal obligations or resolve disputes.

<br><br><b>7. Children’s Privacy</b>
<br>PeakForm is not intended for users under the age of 13. We do not knowingly collect data from children without parental consent.

<br><br><b>8. Changes to This Policy</b>
<br>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised effective date. We encourage you to review this page regularly.

<br><br><b>9. Contact Us</b>
<br>If you have any questions or concerns about this Privacy Policy, please contact us at:

<br>📧 peakformtech@gmail.com
<br>🌐 www.peakform.com
            </p>
        </div>
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
</div>
</div>
    
    <script src="script.js"></script>
    <script>
        const passwordInput = document.getElementById("password");
    const feedbackBox = document.getElementById("password-feedback");

    function validatePassword() {
        const password = passwordInput.value;
        const errors = [];

        if (password.length < 8) errors.push("At least 8 characters");
        if (!/[A-Z]/.test(password)) errors.push("At least 1 uppercase letter");
        if (!/[a-z]/.test(password)) errors.push("At least 1 lowercase letter");
        if (!/[0-9]/.test(password)) errors.push("At least 1 number");
        if (!/[@$!%*?&]/.test(password)) errors.push("At least 1 special character (@$!%*?&)");

        if (password.length === 0) {
            feedbackBox.style.display = "none";
        } else if (errors.length === 0) {
            feedbackBox.style.display = "block";
            feedbackBox.style.color = "green";
            feedbackBox.innerHTML = "✅ Strong password";
        } else {
            feedbackBox.style.display = "block";
            feedbackBox.style.color = "red";
            feedbackBox.innerHTML = "<ul style='padding-left: 20px; margin: 0;'>" +
                errors.map(err => `<li>❌ ${err}</li>`).join("") + "</ul>";
        }
    }

    passwordInput.addEventListener("input", validatePassword);
    </script>

</body>
</html>