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
<body style = "
	color: #fff;
	overflow-x: hidden;
	background-image: url('../images/background-18.jpg'); /* Replace with your image path */
    background-size: 100% auto;
    background-position: center;
    background-repeat: no-repeat;
    overflow-y: hidden;
">

    <div id = "header">
        <nav>
           <img src="images/logo_9.png" class = "welcome_logo">
        </nav>
    </header>
    
    <div id = "welcome_contents">
        <div class = "header_welcome">
            <h1> Welcome, <span>{{$user->Fname}}!</span> <br> to PeakForm </h1>
            <p> Your personalized path to peak performance! </p>
            <img src="images/welcome_icon.png">
        </div>
        
        <div class = "proceed_options">
            <div class = "proceed_opt">
                <h4> Let's build your Workout! </h4>
                <a href="{{ route('workout_plan_1') }}" class="button_proceed">
                  <img src="images/proceed-2.png" alt="Proceed Icon">
                  <span class="button-text">Proceed</span>
                </a>
            </div>
        </div>
    </div>
            
    <script src="script.js"></script>

</body>
</html>