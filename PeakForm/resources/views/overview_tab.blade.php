<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workout Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <div class="avatar"></div>
        <p class="name"  style="font-family: 'Michroma', sans-serif;" >FRANCIS EMIL ROSETE</p>
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
        <button class="logout-btn">
          <img src="images/log_out.png">
        </button>
      </div>
    </aside>

    <main class="main-content">
      <div class="cards">
        <div class="card">
          <h2 style="font-family: 'Michroma', sans-serif;" >Monday</h2>
        </div>
        <div class="card">
          <h2 style="font-family: 'Michroma', sans-serif;" >Progress</h2>
        </div>
        <div class="card">
          <h2 style="font-family: 'Michroma', sans-serif;" >Reminder</h2>
        </div>
      </div>

      <div class="actions">
        <div class = "actions_2">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play">▶ View Video Guide </a>
            </div>
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit"> ✎ Edit Workout Plan </a>
            </div>
            <div class = "actions_3">
              <button class="btn timer">⏱ Use Timer</button>
            </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>