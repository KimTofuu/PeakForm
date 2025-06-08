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
  <style>body{overflow-y: hidden;}</style>

</head>
<body>
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
              <img src="images/log_out2.png" alt="Log Out">
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
              <button onclick="previousDay()" class="prev-btn">Previous</button>
              <span id="day-label" style="color:white;">Day 1</span>
              <button onclick="nextDay()"  class="next-btn">Next</button>
            </div> 
            <div id="workout-container" class="workout-list" style="overflow-y: auto;"><br></div>
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
                <h4 style="font-family: 'inter', sans-serif;  opacity: 50%; font-weight:100; margin-top: 0.5rem; margin-bottom: 0.5rem;">Macros Target<br></h4>
                <p>Protein: <span id="protein">0</span> g</p>
                <p>Carbs: <span id="carbs">0</span> g</p>
                <p>Fat: <span id="fat">0</span> g</p>
              </div>
              <div class = "progress_tab4" style = "color: #fafafa;">
                <canvas id="comparisonChart" width="100%" ></canvas>
                <div class="dailyintake-inside">
                  <p><strong>Protein:</strong> <span id="inProtein">{{ $daily_intake->protein ?? '-' }}</span> g</p>
                  <p><strong>Carbs:</strong> <span id="inCarbs">{{ $daily_intake->carbs ?? '-' }}</span> g</p>
                  <p><strong>Fat:</strong> <span id="inFat">{{ $daily_intake->fat ?? '-' }}</span> g</p>
                </div>
              </div>
            </div>
          </div>
          <div class="actions">
            <div class = "actions_3">
              <a href="{{ route('mealplan_tab') }}" class="btn edit">
                <button> Edit Macros Intake </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <!-- Loading Screen -->
  <div id="loader-wrapper">
<img src="{{ asset('images/logo_6.png') }}" alt="Loading..." class="dumbbell-loader" style="width:150px;height:150px;"></div>
  <script src="script.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
  <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>
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
  console.log("displayWorkout called with:", exercises);
  return new Promise((resolve) => {
    const workoutContainer = document.getElementById('workout-container');
    const dayLabel = document.getElementById('day-label');

    dayLabel.textContent = `Day ${currentDay}`;

    if (!exercises || exercises.length === 0) {
      workoutContainer.innerHTML = '<p>It is rest day! Enjoy your break.</p>';
      return resolve();
    }

    workoutContainer.innerHTML = exercises.map((exercise, index) => {
      // Get the exercise title
      let exerciseTitle = exercise.title;
        while (typeof exerciseTitle === 'object' && exerciseTitle !== null && 'title' in exerciseTitle) {
          exerciseTitle = exerciseTitle.title;
        }
        if (typeof exerciseTitle !== 'string') {
          exerciseTitle = '[Unknown Exercise]';
        }

      // Get sets and reps, prefer root, fallback to nested
      let sets = exercise.sets ?? (exercise.title && exercise.title.sets);
      let reps = exercise.reps ?? (exercise.title && exercise.title.reps);

      let details = '';
      if (sets && reps) {
        details = ` <span class="exercise-details">(${sets} sets x ${reps} reps)</span>`;
      }
      let muscle = exercise.muscle_group ? `<br><span class="muscle-group">Target: ${exercise.muscle_group}</span>` : '';
      return `
        <div class="exercise-item">
          <input type="checkbox" id="exercise-${index}" data-title="${exerciseTitle}">
          <label for="exercise-${index}">${exerciseTitle}${details}${muscle}</label>
        </div>
      `;
    }).join('');

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

        workoutContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => {
          cb.addEventListener('change', () => {
            const completed = [...document.querySelectorAll('input[type="checkbox"]')]
              .filter(cb => cb.checked)
              .map(cb => cb.dataset.title);
            saveProgress(currentDay, completed);
            updateProgressChart();
          });
        });

        resolve();
      })
      .catch(err => {
        console.error('Failed to load progress:', err);
        resolve();
      });
  });
}

document.addEventListener('DOMContentLoaded', () => {
    if (dailyIntake) {
        document.getElementById('inProtein').textContent = dailyIntake.protein ?? '-';
        document.getElementById('inCarbs').textContent = dailyIntake.carbs ?? '-';
        document.getElementById('inFat').textContent = dailyIntake.fat ?? '-';
    } else {
        // Show placeholders if no data
        document.getElementById('inCalories').textContent = '-';
        document.getElementById('inProtein').textContent = '-';
        document.getElementById('inCarbs').textContent = '-';
        document.getElementById('inFat').textContent = '-';
    }
});

async function initPageData() {
  console.log("initPageData called");
  try {
    await Promise.all([
      updateProgressChart(),
      loadWorkoutForDay(currentDay),
      loadMealAndIntakeData()
    ]);
  } catch (err) {
    console.error("Error loading initial data:", err);
  } finally {
    const loader = document.getElementById('loader-wrapper');
    loader.style.opacity = '0';
    setTimeout(() => loader.style.display = 'none', 500);
  }
}


// Modify your functions slightly to return promises

function updateProgressChart() {
  return fetch('/api/workout/summary')
    .then(res => res.json())
    .then(data => {
      const dailyPercent = data.daily_percent ?? 0;
      const weeklyPercent = data.weekly_percent ?? 0;
      renderRadialChart(dailyPercent, weeklyPercent);
    });
}

function loadWorkoutForDay(day) {
  console.log("loadWorkoutForDay called with day:", day);
  return fetch(`/api/workout/day?day=${day}`)
    .then(response => response.json())
    .then(data => {
      console.log("API /api/workout/day response:", data);
      if (data.success) {
        return displayWorkout(data.exercises); // return the promise
      } else {
        console.error('Error loading workout: ', data.error);
      }
    });
}


async function loadMealAndIntakeData() {
  const responsePlan = await fetch('{{ route("mealplan.latest") }}');
  const resultPlan = await responsePlan.json();

  if (resultPlan.success) {
    const plan = resultPlan.meal_plan;

    document.getElementById('protein').textContent = plan.proteinTarget;
    document.getElementById('carbs').textContent = plan.carbsTarget;
    document.getElementById('fat').textContent = plan.fatTarget;

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
              backgroundColor: '#f06595'
            },
            {
              label: 'Daily (g)',
              data: [updated.protein, updated.carbs, updated.fat],
              backgroundColor: '#00e676'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false, // <-- Add this line
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
}

document.addEventListener('DOMContentLoaded', initPageData);

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