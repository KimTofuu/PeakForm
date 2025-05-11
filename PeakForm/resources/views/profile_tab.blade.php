<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>
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
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Meal Plan</a>
        <a class="active" href="{{ route('profile_tab') }}">Profile</a>
        <a href="{{ route('timer_tab') }}">Timer</a>

      </nav>
      <div class="logout">
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
    
        <div class="left_side_2">
          <div class = "daily_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" > Account </h2>
            </div>
            <div class = "workout_content">
              Name:
            </div>

            <div class = "workout_content">
              Email Address:
            </div>

            <div class = "workout_content">
              Password:
            </div>
          </div>

          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play"> 
                <button> Edit Account </button>
              </a>
            </div>
          </div>
        </div>

        <div class="left_side_2">
          <div class = "daily_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" > Profile </h2>
            </div>
            <div class = "workout_content">
              Name:
            </div>

            <div class = "workout_content">
              Age:
            </div>

            <div class = "workout_content">
              Gender:
            </div>

            <div class = "workout_content">
              Current Weight:  
            </div>

          </div>

          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play"> 
                <button> Edit Profile </button>
              </a>
            </div>
          </div>
        </div>

      </div>
  </main>

  </body>
  </html>
