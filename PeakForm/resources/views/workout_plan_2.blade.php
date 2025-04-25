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
      <form action="{{ route('workout_plan_3') }}" method="GET">
        @csrf
        <p class="question">What best describes your workout setup? <br><span>(Select one)</span></p>
        
        <input type="hidden" name="setup" id="selectedSetup" required />

        <div class="goal-options">
          <button type="button" class="goal-button" data-goal="Full Gym Setup">Full Gym Setup</button>
          <button type="button" class="goal-button" data-goal="Home / Minimal Setup">Home / Minimal Setup</button>
        </div>

        <button type="submit" class="proceed-button">Proceed</button>
      </form>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>