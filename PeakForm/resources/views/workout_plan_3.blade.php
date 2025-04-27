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

  <form action="{{ route('workout_plan_4') }}" method="POST">
  @csrf
  <div class="form-box">
    <p class="question">Select workout intensity <br><span>(Select one)</span></p>
    <div class="goal-options">
      <button type="button" class="goal-button" data-goal="High Intensity">High Intensity</button>
      <button type="button" class="goal-button" data-goal="Moderate">Moderate</button>
      <button type="button" class="goal-button" data-goal="Low Intensity">Low Intensity</button>
    </div>
  </div>

  <!-- Hidden input to store selected intensity -->
  <input type="hidden" name="goal" id="selected-goal" />

  <button type="submit" class="proceed-button"> Proceed </button>
  </form>
</div>

  <script src="script.js"></script>
</body>
</html>