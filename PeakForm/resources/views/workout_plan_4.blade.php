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
      <form action="{{ route('dashboard_1') }}" method="GET">
        <p class="question">How many days a week do you want to work out?</p>
        <div class="goal-options">
          <input type="number" id="days" name="days" required />
        </div>
        <button type="submit" class="proceed-button">Proceed</button>
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>