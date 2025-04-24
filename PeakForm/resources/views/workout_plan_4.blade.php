<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Your Goal</title>
  <link rel="stylesheet" href="{{ asset('css/workout_plan.css') }}">
</head>
<body>
  <div class="container">
    <h2>Let’s Build Your Personalized Plan!</h2>
    <img src="images/logo_4.png"  alt="Dumbbell Icon" class="icon" />

    <div class="form-box">
      <p class="question">How many days a week do you want to work out?</p>
      <div class="goal-options">
            <input type="number" id="days" name="days" required />
        </div>
      </div>
    </div>

    <a href="{{ route('dashboard_1') }}">
        <button class="proceed-button"> Proceed </button>
    </a>
  </div>

  <script src="script.js"></script>
</body>
</html>