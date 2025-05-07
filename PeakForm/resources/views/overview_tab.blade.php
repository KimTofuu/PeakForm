<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Overview</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
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
          <a class="active" href="{{ route('overview_tab') }}">Overview</a>
          <a href="{{ route('progress_tab') }}">Progress</a>
          <a href="{{ route('workouts_tab') }}">Workouts</a>
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
            <div class = "workout_content">
              <label>
                <input type="checkbox" name="agree"> Push-Ups <span> 250 times </span>
              </label>
            </div>

            <div class = "workout_content">
              <label>
                <input type="checkbox" name="agree"> Squats <span> 250 times </span>
              </label>
            </div>
          </div>

          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play"> View Video Guide </a>
            </div>
          </div>
        </div>

        <div class="middle">
          <div class = "progress_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Progress</h2>
            </div>

            <div class ="progress_contents">
              <div>
                <canvas id="progressChart"></canvas>
              </div>
            </div>
          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit"> Edit Workout Plan </a>
            </div>
          </div>
        </div>

        <div class = "right_side">
          <div class="reminders">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Reminder</h2>
            </div>

            <div class = "reminders_contents">
              <p>
                Workout Reminder
              </p>
            </div>
            <div class = "reminders_contents">
              <p>
                Meal Plan Reminder
              </p>
            </div>

          </div>

          <div class="timer_tab">
            <div>
              <h2 style="font-family: 'Michroma', sans-serif;" >Timer</h2>
              <div id="timer" style="font-family: 'Michroma', sans-serif; margin-bottom: 20px;">05:00</div>

                <button id="startBtn">Start</button>
                <button id="stopBtn">Stop</button>
                <button id="resetBtn">Reset</button>
                <button id="editBtn">Edit</button>
                <button id="oneMinBtn">1 Min</button>
                <button id="twoMinBtn">2 Min</button>
                <button id="threeMinBtn">3 Min</button>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="script.js"> </script>
  
  <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  
</body>
</html>