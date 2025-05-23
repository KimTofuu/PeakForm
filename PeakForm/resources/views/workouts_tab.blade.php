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
              $dayCount = 1;
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
                          // dump($normalized, $videoList->keys());
                          // dump($videoList->keys()->all());
                      @endphp
                      <div class="workout_content_2">
                          <label>
                              <img src="images/push-up.jpg"> 
                              {{ $exercise }} <br>
                          </label>
                          @php
                              $embedUrl = '';
                              if ($video && $video->youtube_url) {
                                  // Try to match both youtube.com/watch?v= and youtu.be/ and also handle extra params
                                  if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->youtube_url, $matches)) {
                                      $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                  }
                              }
                          @endphp
                          @if($embedUrl)
                            <button type="button" onclick="showVideo('{{ $embedUrl }}', '{{ $video->youtube_url }}')">Watch Video</button>
                        @endif
                      </div>
                  @empty
                      <p>No exercises for this day.</p>
                  @endforelse
              </div>
              @php $dayCount++; @endphp
          @endforeach
        </div>
        <div id="videoModal" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:#fff; z-index:1000; padding:20px; border-radius:8px;">
          <button onclick="closeVideo()" style="float:right;">Close</button>
          <iframe id="videoFrame" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
          <div id="fallbackLink" style="margin-top:10px; text-align:center; display:none;">
              <a id="originalVideoLink" href="#" target="_blank" style="color:#007bff;">Can't see the video? Click here to watch on YouTube</a>
          </div>
      </div>
        <div id="modalBackdrop" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.5); z-index:999;" onclick="closeVideo()"></div>
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
    function showVideo(embedUrl, originalUrl) {
    var iframe = document.getElementById('videoFrame');
    var modal = document.getElementById('videoModal');
    var backdrop = document.getElementById('modalBackdrop');
    var fallbackLink = document.getElementById('fallbackLink');
    var originalVideoLink = document.getElementById('originalVideoLink');

    iframe.src = embedUrl;
    modal.style.display = 'block';
    backdrop.style.display = 'block';

    // Always show the fallback link with the correct URL
    fallbackLink.style.display = 'block';
    originalVideoLink.href = originalUrl;
}

function closeVideo() {
    var iframe = document.getElementById('videoFrame');
    document.getElementById('videoModal').style.display = 'none';
    document.getElementById('modalBackdrop').style.display = 'none';
    iframe.src = '';
}
  </script>
  <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  

</body>
</html>