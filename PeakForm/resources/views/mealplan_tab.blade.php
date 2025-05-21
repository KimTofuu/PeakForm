<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Meal Plan</title>
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
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a class="active" href="{{ route('mealplan_tab') }}">Macros</a>
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
    <!-- Trigger Button -->

  <main class = "main-content">
    <div class="cards">
      <div class="first-side">
        <div class="progress_tab2">
          <button id="openMealPlanModal" class="generate-btn">Generate Macros</button>
        

  <!-- Meal Plan Output Will Be Injected Here -->
  <div id="mealPlanSummary" class="meal-summary hidden">
    <h2>Generated Meal Plan</h2>
    <p><strong>Name:</strong> <span id="planName"></span></p>
    <p><strong>Calories:</strong> <span id="calories"></span></p>
    <p><strong>Protein:</strong> <span id="protein"></span> g</p>
    <p><strong>Carbs:</strong> <span id="carbs"></span> g</p>
    <p><strong>Fat:</strong> <span id="fat"></span> g</p>
    <p><strong>BMR:</strong> <span id="bmr"></span></p>
    <canvas id="mealPlanChart" width="300" height="300" style="max-width: 400px; margin-top: 20px;"></canvas>
  </div>
  </div>
</div>


      <div class="second-side">
        <div class = "progress_tab3">
          <h3>Enter Your Actual Daily Intake</h3>
          <div class = "mealplan-label">
          <label> <input type="number" id="actualProtein" min="0" placeholder="Protein (g)"></label><br>
          <label> <input type="number" id="actualCarbs" min="0" placeholder="Carbs (g)"></label><br>
          <label> <input type="number" id="actualFat" min="0" placeholder="Fat (g)"></label><br>
          <button id="compareIntakeBtn"  class="generate-btn" >Compare</button>
          <button id="ResetBtn"  class="generate-btn" >Reset</button>
          </div>
        </div>
        <div class = "progress_tab5">
          <canvas id="comparisonChart" width="100%"></canvas>
        </div>
      </div>
    </div>
  </main>


  <!-- Modal Form -->
  <div id="mealPlanModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeMealPlanModal">&times;</span>
      <h2>Enter Your Details</h2>
      <form id="mealPlanForm">
        @csrf
        <label>Age: <input type="number" name="age" min="13" max="80" required></label>
        <label>Gender:
          <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </label>
        <label>Weight (kg): <input type="number" name="weight" min="30" max="200" required></label>
        <label>Height (cm): <input type="number" name="height" min="120" max="250" required></label>
        <label>Goal:
          <select name="goal" required>
            <option value="gain_muscle">Gain Muscle</option>
            <option value="lose_fat">Lose Fat</option>
            <option value="maintenance">Maintenance</option>
          </select>
        </label>
        <label>Activity Level:
          <select name="activity" required>
            <option value="1.2">Sedentary</option>
            <option value="1.375">Lightly active</option>
            <option value="1.55">Moderately active</option>
            <option value="1.725">Very active</option>
            <option value="1.9">Extra active</option>
          </select>
        </label>
        <button type="submit">Generate</button>
      </form>
    </div>
  </div>
  </div>

</body>
<script>
  const openBtn = document.getElementById('openMealPlanModal');
  const modal = document.getElementById('mealPlanModal');
  const closeBtn = document.getElementById('closeMealPlanModal');

  openBtn.onclick = () => modal.style.display = 'block';
  closeBtn.onclick = () => modal.style.display = 'none';
  window.onclick = e => { if (e.target === modal) modal.style.display = 'none'; };

  document.getElementById('mealPlanForm').onsubmit = async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Optional: loading state
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = "Generating...";

    try {
      const response = await fetch('{{ route("generate_meal_plan") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: formData
      });

      const result = await response.json();
      console.log(result);
      submitButton.disabled = false;
      submitButton.textContent = "Generate";

      if (result.success) {
        const plan = result.meal_plan;

        document.getElementById('planName').textContent = plan.MealplanName;
        document.getElementById('calories').textContent = plan.calorieTarget;
        document.getElementById('protein').textContent = plan.proteinTarget;
        document.getElementById('carbs').textContent = plan.carbsTarget;
        document.getElementById('fat').textContent = plan.fatTarget;
        document.getElementById('bmr').textContent = plan.bmr;

        document.getElementById('mealPlanSummary').classList.remove('hidden');
        modal.style.display = 'none';

        setTimeout(() => {
          const ctx = document.getElementById('mealPlanChart').getContext('2d');

          if (window.mealPlanChart instanceof Chart) {
            window.mealPlanChart.destroy();
          }
          window.mealPlanChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ['Protein (g)', 'Carbs (g)', 'Fat (g)'],
              datasets: [{
                label: 'Macronutrient Breakdown',
                data: [plan.proteinTarget, plan.carbsTarget, plan.fatTarget],
                backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom'
                },
                title: {
                  display: true,
                  text: 'Macronutrient Distribution'
                }
              }
            }
          });
          document.getElementById('compareIntakeBtn').onclick = () => {
          const actualProtein = parseInt(document.getElementById('actualProtein').value);
          const actualCarbs = parseInt(document.getElementById('actualCarbs').value);
          const actualFat = parseInt(document.getElementById('actualFat').value);

          const targetProtein = plan.proteinTarget;
          const targetCarbs = plan.carbsTarget;
          const targetFat = plan.fatTarget;

          const ctxCompare = document.getElementById('comparisonChart').getContext('2d');

          // Destroy old comparison chart if exists
          if (window.comparisonChart && typeof window.comparisonChart.destroy === 'function') {
            window.comparisonChart.destroy();
          }

          window.comparisonChart = new Chart(ctxCompare, {
            type: 'bar',
            data: {
              labels: ['Protein', 'Carbs', 'Fat'],
              datasets: [
                {
                  label: 'Target (g)',
                  data: [targetProtein, targetCarbs, targetFat],
                  backgroundColor: 'rgba(54, 162, 235, 0.5)'
                },
                {
                  label: 'Daily (g)',
                  data: [actualProtein, actualCarbs, actualFat],
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
        };
        }, 100); // small delay to ensure canvas is visible
      } else {
        alert('❌ Failed to generate and save meal plan.');
      }
    } catch (err) {
      console.error(err);
      submitButton.disabled = false;
      submitButton.textContent = "Generate";
      alert('⚠️ An error occurred. Please try again.');
    }
  };
window.addEventListener('DOMContentLoaded', async () => {
  try {
    const response = await fetch('{{ route("mealplan.latest") }}');
    const result = await response.json();

    if (result.success) {
      const plan = result.meal_plan;

      document.getElementById('planName').textContent = plan.MealplanName;
      document.getElementById('calories').textContent = plan.calorieTarget;
      document.getElementById('protein').textContent = plan.proteinTarget;
      document.getElementById('carbs').textContent = plan.carbsTarget;
      document.getElementById('fat').textContent = plan.fatTarget;
      document.getElementById('bmr').textContent = plan.bmr;

      document.getElementById('mealPlanSummary').classList.remove('hidden');

      const ctx = document.getElementById('mealPlanChart').getContext('2d');
      if (window.mealPlanChart instanceof Chart) {
        window.mealPlanChart.destroy();
      }
      window.mealPlanChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Protein (g)', 'Carbs (g)', 'Fat (g)'],
          datasets: [{
            label: 'Macronutrient Breakdown',
            data: [plan.proteinTarget, plan.carbsTarget, plan.fatTarget],
            backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'bottom' },
            title: { display: true, text: 'Macronutrient Distribution' }
          }
        }
      });

      // ⬇️ Add this block to fetch and render the comparison chart
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
document.getElementById('compareIntakeBtn').onclick = async () => {
  const actualProtein = parseInt(document.getElementById('actualProtein').value);
  const actualCarbs = parseInt(document.getElementById('actualCarbs').value);
  const actualFat = parseInt(document.getElementById('actualFat').value);

  if (isNaN(actualProtein) || isNaN(actualCarbs) || isNaN(actualFat)) {
    alert("Please enter all values.");
    return;
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const response = await fetch('{{ route("update_intake") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        protein: actualProtein,
        carbs: actualCarbs,
        fat: actualFat
      })
    });

    const result = await response.json();

    if (result.success) {
      const updated = result.data;

      const ctxCompare = document.getElementById('comparisonChart').getContext('2d');

      if (window.comparisonChart && typeof window.comparisonChart.destroy === 'function') {
        window.comparisonChart.destroy();
      }

      window.comparisonChart = new Chart(ctxCompare, {
        type: 'bar',
        data: {
          labels: ['Protein', 'Carbs', 'Fat'],
          datasets: [
            {
              label: 'Target (g)',
              data: [parseInt(document.getElementById('protein').textContent), parseInt(document.getElementById('carbs').textContent), parseInt(document.getElementById('fat').textContent)],
              backgroundColor: 'rgba(54, 162, 235, 0.5)'
            },
            {
              label: 'Actual (g)',
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
      document.getElementById('actualProtein').value = '';
      document.getElementById('actualCarbs').value = '';
      document.getElementById('actualFat').value = '';
    }
  } catch (err) {
    console.error(err);
    alert("Something went wrong saving your intake.");
  }
};
document.getElementById("ResetBtn").addEventListener("click", async () => {
  const confirmed = confirm("Are you sure you want to reset today's intake?");
  if (!confirmed) return;

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const response = await fetch("/daily-intake", {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
        "Accept": "application/json"
      },
    });

    const data = await response.json();

    if (response.ok) {
      alert("Daily intake has been reset.");
      document.getElementById("actualProtein").value = "";
      document.getElementById("actualCarbs").value = "";
      document.getElementById("actualFat").value = "";
    } else {
      alert("Failed to reset intake: " + data.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Something went wrong.");
  }
});
</script>
</html>