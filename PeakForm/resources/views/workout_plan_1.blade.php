<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Select Your Goal</title>
  <link rel="stylesheet" href="{{ asset('css/workout_plan.css') }}">
</head>
<body>

  <div class="container">
    
  <img src="images/logo_9.png" class="logo_top">

    <form action="{{ route('workout_plan_1') }}" method="POST">
      @csrf
      <div class="form-box">
        <p class="question">What’s your primary goal? <br><span>(Select one)</span></p>
        <div class="goal-options">
          <button type="button" class="goal-button" data-goal="Lose Fat"><img src="images/loseFat.png"> </button>
          <button type="button" class="goal-button" data-goal="Build Muscle"><img src="images/buildMuscle.png"> </button>
          <button type="button" class="goal-button" data-goal="Get Toned"><img src="images/getToned.png"> </button>
        </div>
      </div>

      <input type="hidden" name="goal" id="selected-goal" />

      <button type="submit" class="proceed-button"><img src="images/proceed.png"></button>
    </form>
  </div>

  <!-- Use asset() to ensure correct JS path -->
  <script src="{{ asset('js/script.js') }}"></script>

  <!-- Inline fallback if needed -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let selectedValues = {};

      document.querySelectorAll(".goal-button").forEach(button => {
        button.addEventListener("click", () => {
          const field = document.getElementById("selected-goal");
          const fieldName = field.getAttribute("name");
          const label = button.getAttribute("data-goal");

          if (selectedValues[fieldName] === label) return;

          // Remove previous active button
          if (selectedValues[fieldName]) {
            const prev = document.querySelector(`.goal-button[data-goal="${selectedValues[fieldName]}"]`);
            if (prev) prev.classList.remove("active");
          }

          button.classList.add("active");
          selectedValues[fieldName] = label;
          field.value = mapLabelToBackend(label);
        });
      });

      function mapLabelToBackend(label) {
        const map = {
          "Lose Fat": "lose_fat",
          "Build Muscle": "gain_muscle",
          "Get Toned": "maintenance",
        };
        return map[label] || label.toLowerCase().replace(" ", "_");
      }
    });
  </script>
</body>
</html>
