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
        <a href="{{ route('dashboard_1') }}">Overview</a>
        <a href="{{ route('dashboard_2') }}">Progress</a>
        <a class="active" href="{{ route('dashboard_3') }}"> Workouts</a>
        <a href="{{ route('dashboard_4') }}">Meal Plan</a>
        <a href="{{ route('dashboard_5') }}">Profile</a>
      </nav>
      <div class="logout">
        <button class="logout-btn">
          <img src="images/log_out.png">
        </button>
      </div>
    </aside>