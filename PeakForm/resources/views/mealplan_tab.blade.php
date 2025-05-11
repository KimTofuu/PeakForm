<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Meal Plan</title>
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
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a class="active" href="{{ route('mealplan_tab') }}">Meal Plan</a>
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
    <!-- Trigger Button -->
  <div class="main-content">
    <button id="openMealPlanModal" class="generate-btn">Generate Meal Plan</button>
  </div>

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
</body>
<script>
  const openBtn = document.getElementById('openMealPlanModal');
  const modal = document.getElementById('mealPlanModal');
  const closeBtn = document.getElementById('closeMealPlanModal');

  openBtn.onclick = () => modal.style.display = 'block';
  closeBtn.onclick = () => modal.style.display = 'none';
  window.onclick = e => { if (e.target == modal) modal.style.display = 'none'; };

  document.getElementById('mealPlanForm').onsubmit = async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch('{{ route("generate_meal_plan") }}', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: formData
    });

    const result = await response.json();

    if (result.success) {
      alert(`✅ Meal Plan Saved!\n\n${result.plan.PlanName}\nCalories: ${result.plan.CalorieTarget}\nProtein: ${result.plan.ProteinTarget}g\nCarbs: ${result.plan.CarbTarget}g\nFat: ${result.plan.FatTarget}g`);
      document.getElementById('mealPlanModal').style.display = 'none';
    } else {
      alert('❌ Failed to generate and save meal plan.');
    }
  };
</script>
</html>