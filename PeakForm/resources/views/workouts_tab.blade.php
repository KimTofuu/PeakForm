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
    
        <div class="left_side_1">
          @foreach ($workouts as $day => $exercises)
            <div class="daily_tab">
              <div class="header_content">
                <h2 style="font-family: 'Michroma', sans-serif;">{{ $day }}</h2>
              </div>

              @forelse ($exercises as $exercise)
                <div class="workout_content_2">
                  <label>
                    <input type="checkbox" name="completed[]"> 
                    <img src="{{ asset('images/push-up.jpg') }}" alt="Exercise Image"> 
                    {{ $exercise }} 
                    <span> x12 reps </span>
                  </label>
                </div>
              @empty
                <p>No exercises for this day.</p>
              @endforelse
            </div>
          @endforeach

        </div>

        <div class = "right_side">
          <div class="goals_plan">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Goals / Plan</h2>
            </div>

            {{-- <div class = "goals_contents">
              <p>
                Target Weight: <b> 60kg </b>
              </p>
            </div> --}}
            <div class = "goals_contents">
              <p>
                 Goal: {{ $input['goal'] }}
              </p>
            </div>

            <div class = "goals_contents">
              <p>
                 Setup: {{ $input['setup'] }}
              </p>
            </div>

            <div class = "goals_contents">
              <p>
                 Workout Type: {{ $input['splitType'] }}
              </p>
            </div>

             <div class = "goals_contents">
              <p>
                 <b> {{$input['days']}} </b> Days / Week Workout
              </p>
            </div>

          </div>
          <div class="actions">
            <div class="actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit">Edit Goals / Plan</a>
            </div>
            <div class="actions_3" style="margin-top: 10px;">
              <a href="{{ route('workout_plan_1') }}" class="btn update">Update Workout Preferences</a>
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