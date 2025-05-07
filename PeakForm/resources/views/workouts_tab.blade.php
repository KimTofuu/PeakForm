<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workouts</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <div class="avatar"></div>
        <p class="name"  style="font-family: 'Michroma', sans-serif;" >{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
      </div>
      <nav class="nav-menu">
        <a href="{{ route('overview_tab') }}">Overview</a>
        <a href="{{ route('progress_tab') }}">Progress</a>
        <a class="active" href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Meal Plan</a>
        <a href="{{ route('profile_tab') }}">Profile</a>
      </nav>
      <div class="logout">
        <form method="GET" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-btn">
            <img src="images/log_out.png" alt="Log Out">
          </button>
        </form>
      </div>
    </aside>

    <main class="main-content">
      <div class="cards">
    
        <div class="left_side">
          <div class = "daily_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Monday</h2>
            </div>
            <div class = "workout_content_2">
              <label>
                <input type="checkbox" name="agree"> <img src = "images/push-up.jpg"> <br> <p> Push-Ups <span> 250 times </span> </p>
              </label>
            </div>

            <div class = "workout_content_2">
              <label>
                <input type="checkbox" name="agree"> <img src = "images/push-up.jpg"> <br> <p> Squats <span> 250 times </span> </p>
              </label>
            </div>
          </div>

          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play"> Edit Daily Workout </a>
            </div>
          </div>
        </div>

        <div class="middle">
          <div class = "progress_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Weekly</h2>
            </div>

            <div class ="progress_contents">
              <div>
                <canvas id="progressChart"></canvas>
              </div>
            </div>
          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit"> Edit Weekly Workout </a>
            </div>
          </div>
        </div>

        <div class = "right_side">
          <div class="goals_plan">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Goals / Plan</h2>
            </div>

            <div class = "goals_contents">
              <p>
                Target Weight: <b> 60kg </b>
              </p>
            </div>
            <div class = "goals_contents">
              <p>
                 Build Muscle
              </p>
            </div>

            <div class = "goals_contents">
              <p>
                 Full Gym Setup
              </p>
            </div>

            <div class = "goals_contents">
              <p>
                 High Intensity
              </p>
            </div>

             <div class = "goals_contents">
              <p>
                 <b> 5 </b> Days / Week Workout
              </p>
            </div>

          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit"> Edit Goals / Plan </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

    <script src="script.js"> </script>
</body>
</html>