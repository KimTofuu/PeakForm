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
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <img src="images/logo_6.png" class="avatar">
        <p class="name"  style="font-family: 'Michroma', sans-serif;" >{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
      </div>
      <nav class="nav-menu">
        <a href="{{ route('overview_tab') }}">Overview</a>
        <a class="active" href="{{ route('progress_tab') }}">Progress</a>
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Meal Plan</a>
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
      <div class = "cards">
      <div class="middle">
          <div class = "progress_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Progress</h2>
            </div>
            <div class ="progress_contents">
              <div class="progress_table_section">
                <h3 style="font-family: 'Orbitron', sans-serif;">Track Your Progress</h3>

                <!-- Add Entry Form -->
                <form method="POST" action="{{ route('progress.store') }}" class="progress-form">
                  @csrf
                  <input type="date" name="recorded_at" required />
                  <input type="number" name="weight" step="0.1" placeholder="Weight (kg)" required />
                  <input type="number" name="body_fat" step="0.1" placeholder="Body Fat (%)" required />
                  <input type="number" name="muscle_mass" step="0.1" placeholder="Muscle Mass (kg)" required />
                  <button type="submit">Add Entry</button>
                </form>

                <!-- Table Displaying Progress -->
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
                        <td>{{ \Carbon\Carbon::parse($entry->created_at)->format('F j, Y') }}</td>                        <td>{{ $entry->weight }}</td>
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
              {{-- <div>
                <div id="radialChart"></div>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
      </div>
    </main>

    <script src="script.js"> </script>
  
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  
</body>
</html>