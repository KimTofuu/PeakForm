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
  <div class="container">
    <aside class="sidebar">
      <div class="profile-section">
        <div class="avatar"></div>
          <p class="name"  style="font-family: 'Michroma', sans-serif;" >{{$user->Fname}} {{$user->Lname}}</p>
          <hr />
        </div>
        <nav class="nav-menu">
          <a class="active" href="{{ route('overview_tab') }}">Overview</a>
          <a href="{{ route('progress_tab') }}">Progress</a>
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
      <div class="cards">
        <div class="left_side">
          <div class="daily_tab">
            <h2 style="font-family: 'Michroma', sans-serif;">Today's Workout</h2>
            <div class="day-controls">
              <button onclick="previousDay()">Previous</button>
              <span id="day-label">Day 1</span>
              <button onclick="nextDay()">Next</button>
            </div> 
            <div id="workout-container" class="workout-list"></div>
          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn play"> 
                <button> View Video Guide </button>
              </a>
            </div>
          </div>
        </div>

        <div class="middle">
          <div class = "progress_tab">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Progress</h2>
            </div>
            <div class ="progress_contents">
              <div>
                <div id="radialChart" style="height: 350px;"></div>
              </div>
            </div>
          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('workouts_tab') }}" class="btn edit">
                <button> Edit Workout Plan </button>
              </a>
            </div>
          </div>
        </div>

        <div class = "right_side">
          <div class="reminders">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" >Reminder</h2>
            </div>

            <div class = "reminders_contents">
              <p>
                Workout Reminder
              </p>
            </div>
            <div class = "reminders_contents">
              <p>
                Meal Plan Reminder
              </p>
            </div>

          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="script.js"> </script>
  
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  
</body>
<script>
  let currentDay = 1;
  let radialChart;

  function renderRadialChart(dailyPercent, weeklyPercent) {
    const options = {
      series: [dailyPercent, weeklyPercent],
      chart: {
        height: 350,
        type: 'radialBar',
      },
      plotOptions: {
        radialBar: {
          dataLabels: {
            name: {
              fontSize: '18px',
            },
            value: {
              fontSize: '16px',
              formatter: val => `${val}%`
            },
            total: {
              show: true,
              label: 'Total Progress',
              formatter: () => `${Math.round((dailyPercent + weeklyPercent) / 2)}%`
            }
          }
        }
      },
      labels: ['Today', 'This Week'],
      colors: ['#00E396', '#FEB019'],
    };

    if (radialChart) {
      radialChart.updateOptions(options);
    } else {
      const chartEl = document.querySelector("#radialChart");
      if (!chartEl) return console.error("radialChart element not found!");
      radialChart = new ApexCharts(chartEl, options);
      radialChart.render();
    }
  }

 function updateProgressChart() {
    fetch('/api/workout/summary')
      .then(res => res.json())
      .then(data => {
        console.log("Workout summary data:", data);
        const dailyPercent = data.daily_percent ?? 0;
        const weeklyPercent = data.weekly_percent ?? 0;
        renderRadialChart(dailyPercent, weeklyPercent);
      })
      .catch(error => console.error("Failed to fetch workout summary", error));
  }


  

  function loadWorkoutForDay(day) {
      fetch(`/api/workout/day?day=${day}`)
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  // Update the workout display with the new day exercises
                  displayWorkout(data.exercises);
              } else {
                  console.error('Error loading workout: ', data.error);
              }
          });
  }

  function nextDay() {
      if (currentDay < 7) {
          currentDay++;
          loadWorkoutForDay(currentDay);
      }
  }

  function previousDay() {
      if (currentDay > 1) {
          currentDay--;
          loadWorkoutForDay(currentDay);
      }
  }

  function saveProgress(day, completedTitles) {
    fetch('/api/workout/progress', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ day: day, exercises: completedTitles })
    }).then(response => response.json())
      .then(data => {
        if (!data.success) {
          console.error('Failed to save progress:', data.message);
        }
      });
  }

  function displayWorkout(exercises) {
      const workoutContainer = document.getElementById('workout-container');
      const dayLabel = document.getElementById('day-label');

      dayLabel.textContent = `Day ${currentDay}`;

      if (!exercises || exercises.length === 0) {
          workoutContainer.innerHTML = '<p>It is rest day! Enjoy your break.</p>';
          return;
      }

      workoutContainer.innerHTML = exercises.map((exercise, index) => `
          <div class="exercise-item">
              <label>
                  <input type="checkbox" id="exercise-${index}" />
                  ${exercise.title}
              </label>
          </div>
      `).join('');

      fetch(`/api/workout/progress?day=${currentDay}`)
      .then(response => response.json())
      .then(data => {
        if (data.success && data.completed) {
          data.completed.forEach(title => {
            const checkbox = [...document.querySelectorAll('input[type="checkbox"]')]
              .find(cb => cb.dataset.title === title);
            if (checkbox) checkbox.checked = true;
          });
        }
      });

      workoutContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => {
      cb.addEventListener('change', () => {
        const completed = [...document.querySelectorAll('input[type="checkbox"]')]
          .filter(cb => cb.checked)
          .map(cb => cb.dataset.title);
        saveProgress(currentDay, completed);
        updateProgressChart(); // optionally refresh the chart
      });
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    updateProgressChart();
    loadWorkoutForDay(currentDay);
  });

</script>
</html>