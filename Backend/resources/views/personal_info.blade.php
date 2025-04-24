<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Personalized Plan</title>
  <link rel="stylesheet" href="{{ asset('css/personal_info.css') }}">
</head>
<body>
  <div class="container">
    <h2>Let’s Build Your Personalized Plan!</h2>
    <img src="images/logo_4.png" alt="Dumbbell Icon" class="icon" />
    
    <div class="form-box">
      <form>
        <div class="form-group">
            <label for="height">Height<br><span>(cm)</span></label>
            <input type="number" id="height" name="height" required />
        </div>

        <div class="form-group">
            <label for="currentWeight">Current Weight<br><span>(kg)</span></label>
            <input type="number" id="currentWeight" name="currentWeight" required />
        </div>

        <div class="form-group">
            <label for="targetWeight">Target Weight<br><span>(kg)</span></label>
            <input type="number" id="targetWeight" name="targetWeight" required />
        </div>
        
        <div class="form-group">
            <label for="age">Age<br></label>
            <input type="number" id="age" name="age" required />
        </div>

        <div class="form-group">
            <label for="gender">Gender<br></label>
            <input type="text" id="gender" name="gender" required />
        </div>
        
      </form>
    </div>

    <div>
      <a href="{{ route('workout_plan_1') }}">
        <button class="login-btn"> Proceed </button>
      </a>
    </div>
  </div>
</body>
</html>