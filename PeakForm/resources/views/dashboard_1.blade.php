<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workout Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <div class="avatar"></div>
        <p class="name">{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
      </div>
      <nav class="nav-menu">
        <a class="active" href="#">Overview</a>
        <a href="#">Progress</a>
        <a href="#">Workouts</a>
        <a href="#">Meal Plan</a>
        <a href="#">Profile</a>
      </nav>
      <div class="logout">
        <button class="logout-btn" onclick="window.location.href='index.html'" ><img src="images/log_out.png"></button>
      </div>
    </aside>

    <main class="main-content">
      <div class="cards">
        <div class="card">
          <h2>Monday</h2>
        </div>
        <div class="card">
          <h2>Progress</h2>
        </div>
        <div class="card">
          <h2>Reminder</h2>
        </div>
      </div>

      <div class="actions">
        <button class="btn play">▶ View Video Guide</button>
        <button class="btn edit">✎ Edit Workout Plan</button>
        <button class="btn timer">⏱ Use Timer</button>
      </div>
    </main>
  </div>
</body>
</html>