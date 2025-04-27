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
        <a class="active" href="{{ route('dashboard_1') }}">Overview</a>
        <a href="{{ route('dashboard_2') }}">Progress</a>
        <a href="{{ route('dashboard_3') }}">Workouts</a>
        <a href="{{ route('dashboard_4') }}">Meal Plan</a>
        <a href="{{ route('dashboard_5') }}">Profile</a>
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
              <button class="btn play">▶ View Video Guide</button>
            </div>
            <div class = "actions_3">
              <button class="btn edit">✎ Edit Workout Plan</button>
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