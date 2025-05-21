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
        <img src="images/logo_6.png" class="avatar">
        <p class="name"  style="font-family: 'Michroma', sans-serif;" >{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
        </div>
        <nav class="nav-menu">
          <a class="active" href="{{ route('overview_tab') }}">Overview</a>
          <a href="{{ route('progress_tab') }}">Progress</a>
          <a href="{{ route('workouts_tab') }}">Workouts</a>
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
        <div class="left_side">
          <div class="daily_tab">
            <h2 style="font-family: 'Michroma', sans-serif;">Today's Workout</h2>
            <div class="day-controls">
              <span id="day-label">Day 1</span>
            </div> 
            <div id="workout-container" class="workout-list"></div>
            <div class="day-controls2">
            <button onclick="previousDay()" class="prev-btn">Previous</button>
            <button onclick="nextDay()"  class="next-btn">Next</button>
            </div>
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
              <h2 style="font-family: 'Michroma', sans-serif;" >Macros</h2>
            </div>
            <div class ="progress_contents">
              
              <div class="intake-summary">
                <h4 style="font-family: 'inter', sans-serif;  opacity: 50%; font-weight:100; margin-top: 2.8rem; margin-bottom: 2rem;">Macros Target</h4>
                <p>Protein: <span id="protein">0</span> g</p>
                <p>Carbs: <span id="carbs">0</span> g</p>
                <p>Fat: <span id="fat">0</span> g</p>
              </div>
              <div class = "progress_tab4">
                <canvas id="comparisonChart" width="100%"></canvas>
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
      </div>
    </main>
  </div>

  <script src="script.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
<script>
  let currentDay = 1;

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
    const nextDay = currentDay + 1;
    if (nextDay > 7) return; // assuming max 7 days

    // Check if next day has exercises
    fetch(`/api/workout/day?day=${nextDay}`)
      .then(response => response.json())
      .then(data => {
        if (data.success && data.exercises && data.exercises.length > 0) {
          currentDay = nextDay;
          displayWorkout(data.exercises);
        } else {
          // Optionally alert or just do nothing to prevent next day navigation
          console.log('No workout for the next day.');
        }
      })
      .catch(err => console.error('Failed to check next day workout:', err));
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
    <input type="checkbox" id="exercise-${index}" data-title="${exercise.title}">
    <label for="exercise-${index}">${exercise.title}</label>
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

  window.addEventListener('DOMContentLoaded', async () => {
  try {
    const responsePlan = await fetch('{{ route("mealplan.latest") }}');
    const resultPlan = await responsePlan.json();

    if (resultPlan.success) {
      const plan = resultPlan.meal_plan;

      document.getElementById('protein').textContent = plan.proteinTarget;
      document.getElementById('carbs').textContent = plan.carbsTarget;
      document.getElementById('fat').textContent = plan.fatTarget;

      // Fetch actual intake data
      const intakeResponse = await fetch('{{ route("intake.latest") }}');
      const intakeResult = await intakeResponse.json();

      if (intakeResult.success && intakeResult.data) {
        const updated = intakeResult.data;

        const ctxCompare = document.getElementById('comparisonChart').getContext('2d');

        if (window.comparisonChart instanceof Chart) {
          window.comparisonChart.destroy();
        }

        window.comparisonChart = new Chart(ctxCompare, {
          type: 'bar',
          data: {
            labels: ['Protein', 'Carbs', 'Fat'],
            datasets: [
              {
                label: 'Target (g)',
                data: [plan.proteinTarget, plan.carbsTarget, plan.fatTarget],
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
              },
              {
                label: 'Daily (g)',
                data: [updated.protein, updated.carbs, updated.fat],
                backgroundColor: 'rgba(255, 99, 132, 0.5)'
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Target vs Daily Intake'
              },
              legend: {
                position: 'bottom'
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }
    }
  } catch (err) {
    console.error('Failed to load latest meal plan or intake data:', err);
  }
});

</script>
</html>