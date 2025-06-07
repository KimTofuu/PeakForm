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
  <div id="loader-wrapper" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background:#111;display:flex;align-items:center;justify-content:center;">
    <img src="{{ asset('images/logo_6.png') }}" alt="Loading..." class="dumbbell-loader" style="width:150px;height:150px;">
  </div>
  <div class="container">
    <div class="burger-menu" onclick="toggleSidebar()"></div>
<aside class="sidebar">
  <div class="close-btn" onclick="toggleSidebar()"></div>
      <div class="profile-section">
          <img src="images/logo_8.png" class="avatar">
          <p class="name"  style="font-family: 'Michroma', sans-serif; color:#fafafa;" >{{$user->Fname}} {{$user->Lname}}</p>
          <hr />
        </div>
        <nav class="nav-menu">
          <a href="{{ route('overview_tab') }}">Overview</a>
          <a href="{{ route('progress_tab') }}">Progress</a>
          <a href="{{ route('workouts_tab') }}">Workouts</a>
          <a href="{{ route('mealplan_tab') }}">Macros</a>
          <a href="{{ route('profile_tab') }}">Profile</a>
          <a class="active" href="{{ route('timer_tab') }}">Timer</a>
        </nav>
        <div class="logout">
          <form method="GET" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
              <img src="images/log_out2.png" alt="Log Out">
            </button>
          </form>
        </div>
    </aside>

    <main class="main-content" style="display: flex; justify-content: center;">
      <div class="cards">
    

          <div class="timer_tab">
            <div>
              <h2 style="font-family: 'Michroma', sans-serif; color:white;margin-bottom:2rem;">Timer</h2>
              <div class="circle-timer">
                <svg class="progress-ring" width="240" height="240">
                  <circle class="progress-ring__circle" stroke="#00bfff" stroke-width="10" fill="transparent" r="100" cx="120" cy="120"/>
                </svg>
                <div id="timer" class="timer-text">05:00</div>
              </div>

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
    </main>
  </div>



  <script src="script.js"> </script>
  
  <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const loader = document.getElementById('loader-wrapper');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 500);
        }, 300); // Adjust delay if needed
    });

    function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const closeBtn = document.querySelector('.close-btn');

  if (sidebar.style.left === '-250px') {
    sidebar.style.left = '0';
    closeBtn.style.display = 'block'; // Show close button when sidebar is visible
  } else {
    sidebar.style.left = '-250px';
    closeBtn.style.display = 'none'; // Hide close button when sidebar is hidden
  }
}
    </script>
</body>
</html>