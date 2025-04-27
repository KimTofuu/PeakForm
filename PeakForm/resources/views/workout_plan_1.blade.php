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
    <img src="images/logo_4.png" alt="Dumbbell Icon" class="icon" />

    <div class="form-box">
      <p class="question">What’s your primary goal? <br><span>(Select one)</span></p>
      <div class="goal-options">
        <button class="goal-button" data-goal="Lose Fat">Lose Fat</button>
        <button class="goal-button" data-goal="Build Muscle">Build Muscle</button>
        <button class="goal-button" data-goal="Get Toned">Get Toned</button>
      </div>
    </div>

    <a href="{{ route('workout_plan_2') }}">
        <button class="proceed-button"> Proceed </button>
    </a>
  </div>

  <script src="script.js"></script>
  
</body>
</html>