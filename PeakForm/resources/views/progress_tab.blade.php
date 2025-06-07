<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Progress</title>
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
        <a class="active" href="{{ route('progress_tab') }}">Progress</a>
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Macros</a>
        <a href="{{ route('profile_tab') }}">Profile</a>
        <a href="{{ route('timer_tab') }}">Timer</a>
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
    <main class="main-content">
      <div class = "cards" >
      <div class="middle2">
          <div class = "progress_tab6">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Progress</h2>
            </div>
            <div class ="progress_contents" style="text-align: left;">
              <div class="progress_table_section">
                <h3 style="font-family: 'Inter', sans-serif; opacity: 50%; color:white;" >Track Your Progress</h3>
                
                
                <div id="goalModal" class="modal" style="display:none;">
                  <div class="modal-content" style="width: 30rem; display: flex; justify-content:center;">
                    <span class="close" id="closeGoalModal">&times;</span>
                    <form method="POST" action="{{ route('progress.goal') }}" class="progress-form">
                      @csrf
                      @php
                          $goal = strtolower(trim(str_replace('_', ' ', $userGoal ?? '')));
                      @endphp
                      @if($goal === 'gain muscle')  
                        <input type="number" name="goal_muscle_mass" step="0.01" placeholder="Goal Muscle Mass (kg)"/>
                      @elseif($goal === 'lose fat')
                        <input type="number" name="goal_body_fat_percentage" step="0.01" placeholder="Goal Body Fat (%)"/>
                      @elseif($goal === 'maintenance')
                        <input type="number" name="goal_body_fat_percentage" step="0.01" placeholder="Goal Body Fat (%)"/>
                      @else
                        <p style="color: #fff;">Set your goal in your profile to enable goal input.</p>
                      @endif
                      <button type="submit">Set Goal</button>
                    </form>
                  </div>
                </div>
                <!-- Add Entry Form -->
                <form method="POST" action="{{ route('progress.store') }}" class="progress-form">
                  @csrf
                  <div style="position: relative; width: 100%;">
                  <input
                    type="date"
                    name="date_recorded"
                    required
                    value="{{ \Carbon\Carbon::now()->toDateString() }}"
                    max="{{ \Carbon\Carbon::now()->toDateString() }}"
                  />
                  </div>
                  <div style="position: relative; width: 100%;">
                    <input type="number" name="weight" step="0.01" placeholder="Weight (kg)" required />
                  </div>
                  <div style="position: relative; width: 100%; ">
                    <input
                      type="number"
                      name="body_fat_percentage"
                      step="0.01"
                      placeholder="Body Fat (%)"
                      style="padding-right: 0.1rem; width: 100%;"
                    />
                    <button
                    type="button"
                    id="openBodyFatModal"
                    style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%);
                            background: none; border: none; font-weight: bold; cursor: pointer; color: #1c7ed6;"
                    title="What is Body Fat %?"
                    >?</button>
                  </div>

                  <div style="position: relative; width: 100%;">
                    <input
                      type="number"
                      name="muscle_mass"
                      step="0.01"
                      placeholder="Muscle Mass (kg)"
                      style="padding-right: 0.1rem;  width: 100%;"
                    />
                    <button
                      type="button"
                      id="openMuscleModal"
                      style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%);
                            background: none; border: none; font-weight: bold; cursor: pointer; color: #1c7ed6;"
                      title="What is Muscle Mass?"
                      >?</button>
                  </div>

                  <button type="submit">Add Entry</button>
                </form>
              </div>
            </div>
          </div>
              <div class = "progress_lower" style="display:flex;">
              <div class="table-scroll-container">
                <table class="progress-table">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Weight (kg)</th>
                      <th>Body Fat (%)</th>
                      <th>Muscle Mass (kg)</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($progressEntries as $entry)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($entry->date_recorded)->format('F j, Y') }}</td>   
                        <td>{{ $entry->weight }}</td>
                        <td>{{ $entry->body_fat_percentage }}</td>
                        <td>{{ $entry->muscle_mass }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" style="text-align:center; font-style: italic; color: #666;">
                          No progress entries found yet.
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                </div>
              <div class="runner-track-container" >
        <div class="progress-info" style="display: flex; justify-content: space-between;">
            <div style = "color:white; font-size: 1rem;">
                <strong>Current:</strong>
                {{ $currentProgress ?? '-' }} %
            </div>
            <div style = "color:white; font-size: 1rem;">
                <strong>Goal:</strong>
                {{ $goalValue ?? '-' }} %
            </div>
            <button id="openGoalModal" type="button" class="modal-btn">Set/Edit Goal</button>
        </div>
<div class="progress-bar-container">
 <div class="progress-track">
  <!-- Progress Fill -->
  <div class="progress-bar-fill" style="width: {{ $progress }}%;"></div>
</div>
  <!-- Milestones -->
  @foreach([25, 50, 75] as $milestone)
    <div class="milestone" style="left: {{ $milestone }}%;">
      <div class="milestone-line"></div>
      <span class="milestone-label">{{ $milestone }}%</span>
    </div>
  @endforeach

  <!-- Runner -->
  <div class="runner" style="left: {{ $progress }}%;"></div>

  <!-- Finish Line -->
  <div class="finish-line"></div>
</div>

    </div>
    </div>
            
          
        </div>
      </div>
      </div>
      {{-- Runner Progress Visualization --}}
      
    </main>

    <!-- Body Fat Modal -->
<div id="bodyFatModal" class="modal" style="display: none;">
  <div class="modal-content" style="width: 30rem; display: flex; flex-direction: column; align-items: flex-start;">
    <span class="close" id="closeBodyFatModal" style="align-self: flex-end;">&times;</span>
    <h3 style="margin-bottom: 10px;">How to get Body Fat Percentage?</h3>
    <p><br>Body Fat % = (1.20 × BMI) + (0.23 × Age) - (10.8 × Gender) - 5.4<br><br>BMI = weight (kg) / height² (m²)<br><br>Gender: Male = 1 , Female = 0</p>
  </div>
</div>

<!-- Muscle Mass Modal -->
<div id="muscleModal" class="modal" style="display: none;">
  <div class="modal-content" style="width: 30rem; display: flex; flex-direction: column; align-items: flex-start;">
    <span class="close" id="closeMuscleModal" style="align-self: flex-end;">&times;</span>
    <h3 style="margin-bottom: 10px;">How to get Muscle Mass?</h3>
    <p><br>Muscle Mass (kg) ≈ 0.55 × LBM <br><br> Male: <br>LBM = 0.407 × weight(kg) + 0.267 × height(cm) - 19.2 <br><br>Female:<br>LBM = 0.252 × weight(kg) + 0.473 × height(cm) - 48.3</p>
  </div>
</div>


    <script src="script.js"> </script>
  
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for DOM and (optionally) images to load
    setTimeout(function() {
        const loader = document.getElementById('loader-wrapper');
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 500);
    }, 300); // You can adjust the timeout or remove it if not needed
});

document.getElementById('openGoalModal').onclick = function() {
  document.getElementById('goalModal').style.display = 'block';
};
document.getElementById('closeGoalModal').onclick = function() {
  document.getElementById('goalModal').style.display = 'none';
};
window.onclick = function(event) {
  if (event.target == document.getElementById('goalModal')) {
    document.getElementById('goalModal').style.display = 'none';
  }
};

// Body Fat Modal
document.getElementById('openBodyFatModal').onclick = function () {
  document.getElementById('bodyFatModal').style.display = 'block';
};
document.getElementById('closeBodyFatModal').onclick = function () {
  document.getElementById('bodyFatModal').style.display = 'none';
};

// Muscle Mass Modal
document.getElementById('openMuscleModal').onclick = function () {
  document.getElementById('muscleModal').style.display = 'block';
};
document.getElementById('closeMuscleModal').onclick = function () {
  document.getElementById('muscleModal').style.display = 'none';
};

// Close if clicking outside modal
window.addEventListener('click', function (event) {
  if (event.target === document.getElementById('bodyFatModal')) {
    document.getElementById('bodyFatModal').style.display = 'none';
  }
  if (event.target === document.getElementById('muscleModal')) {
    document.getElementById('muscleModal').style.display = 'none';
  }
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
</html>