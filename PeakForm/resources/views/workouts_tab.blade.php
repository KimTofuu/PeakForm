<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workouts</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  <style>body{overflow-y: hidden;}</style>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <img src="images/logo_6.png" class="avatar">
        <p class="name"  style="font-family: 'Michroma', sans-serif;" >{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
      </div>
      <nav class="nav-menu">
        <a href="{{ route('overview_tab') }}">Overview</a>
        <a href="{{ route('progress_tab') }}">Progress</a>
        <a class="active" href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Macros</a>
        <a href="{{ route('profile_tab') }}">Profile</a>
        <a href="{{ route('timer_tab') }}">Timer</a>
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
          @php
            $dayCount = 1; // Initialize a counter for day numbers
          @endphp

          @foreach ($workouts as $exercises)
            <div class="daily_tab_2">
              <div class="header_content">
                <h2 style="font-family: 'Michroma', sans-serif;">Day {{ $dayCount }}</h2> 
              </div>

              @forelse ($exercises as $exercise)
                    @php
                      $normalized = strtolower(trim($exercise));
                      $video = $videoList[$normalized] ?? null;
                      // dd($video);
                    @endphp
                <div class="workout_content_2">
                  <label>
                  <img src="images/push-up.jpg"> 
                    {{ $exercise }} <br>
                    
                    @if ($video)
                      <a href="{{ $video->youtube_url }}" target="_blank" class="video-link">
                        <button>View Video Tutorial</button>
                      </a>
                    @else
                      <span style="color: gray;">No video available</span>
                    @endif
                  </label>
                </div>
              @empty
                <p>No exercises for this day.</p>
              @endforelse
            </div>
            @php
              $dayCount++; // Increment the day number for each loop iteration
            @endphp
          @endforeach
        </div>

        <div class = "right_side_2">
          <div class="goals_plan">
            <div class="header_content">
              <h2 style="font-family: 'Michroma', sans-serif;">Goals / Plan</h2>
            </div>
            <div class="goals_contents">
              <p>
                Goal: {{ ucwords(str_replace('_', ' ', $input['goal'])) }}
              </p>
            </div>

            <div class="goals_contents">
              <p>
                Setup: {{ ucwords(str_replace('_', ' ', $input['setup'])) }}
              </p>
            </div>

            <div class="goals_contents">
              <p>
                Workout Type: {{ ucwords(str_replace('_', ' ', $input['splitType'])) }}
              </p>
            </div>

            <div class="goals_contents">
              <p>
                <b>{{ $input['days'] }}</b> Days / Week Workout
              </p>
            </div>
          </div>
          <div class="actions">
            <div class="actions_3" style="margin-top: 10px;">
              <a href="{{ route('workout_plan_1') }}" class="btn update" onclick="confirmUpdate(event)">
                <button>Update Workout Preferences</button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="script.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmUpdate(event) {
        event.preventDefault(); // Stop default action
        const url = "{{ route('workout_plan_1') }}";

        Swal.fire({
            title: 'Update Preferences?',
            text: "Are you sure you want to update your workout preferences?",
            showCancelButton: true,
            confirmButtonColor: '#8FB031',
            cancelButtonColor: '#ccc',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
  </script>
  <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  

</body>
</html>