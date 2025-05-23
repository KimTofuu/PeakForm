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
           <img src="images/logo_7.png" class = "welcome_logo">
        </nav>
    </header>
    
    <div id = "welcome_contents">
        <div class = "header_welcome">
            <h1> Welcome, {{$user->Fname}}! <br> to PeakForm </h1>
            <p> Your personalized path to peak performance! </p>
            <img src="images/bowl.png">
        </div>
        
        <div class = "proceed_options">
            <div class = "proceed_opt">
                <h4> Let's build your Workout </h4>
                <a href="{{ route('workout_plan_1') }}" class = "button_proceed">
                    <button>Proceed</button>
                </a>
            </div>
        </div>
    </div>
            
    <script src="script.js"></script>

</body>
</html>