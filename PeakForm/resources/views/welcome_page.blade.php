<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeakForm - Your Personalized Path to Peak Performance</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/830b39c5c0.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id = "header">
        <nav>
           <img src="images/logo.png" class = "logo">
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#FAQs">FAQs</a></li>
                <li>
                    <a href="{{ route('login') }}">
                        <button>Log in</button>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    
    <div id="header-text">
        <div class="container">
            <div class="row">
                <div class="col_1">
                    <h1>Welcome beh! <br> Your Personalized Path <br> to Peak Performance.</h1>
                    <p>Unlock your full potential with PeakForm’s personalized fitness and <br> nutrition plans. 
                        From adaptive workouts to easy meal suggestions,
                    <br> everything you need to succeed is at your fingertips.</p>
                    <a href="{{ route('register') }}">
                        <button>Register</button>
                    </a>
                </div>
                <div class="col_2">
                    <img src='images/bowl.png'>
                </div>
            </div>
            <img src='images/dumbell.png' id = "dumbbell">
        </div>

        <a class="button-up" href="#header"> <i class="fa-solid fa-arrow-up"></i> </a>

    </div>


    <script src="script.js"></script>

</body>
</html>