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
  <div class="container2">
    <img src="images/logo_9.png" class="logo_top">

    <form action="{{ route('workout_plan_2') }}" method="POST">
      @csrf
      <div class="form-box">
        <p class="question">What best describes your workout setup? <br><span>(Select one)</span></p>
        <div class="goal-options">
          <button type="button" class="goal-button" data-goal="Full Gym Setup"> <img src="images/fullGym.png"> </button>
          <button type="button" class="goal-button" data-goal="Home / Minimal Setup"><img src="images/homeGym.png"> </button>
        </div>
      </div>

      <input type="hidden" name="setup" id="selected-setup" />

      <button type="submit" class="proceed-button"><img src="images/proceed.png"></button>
    </form>
  </div>

  <!-- Optional: Replace this with external file if desired -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let selectedValues = {};

      document.querySelectorAll(".goal-button").forEach(button => {
        button.addEventListener("click", () => {
          const field = document.getElementById("selected-setup");
          const fieldName = field.getAttribute("name");
          const label = button.getAttribute("data-goal");

          if (selectedValues[fieldName] === label) return;

          // Remove active class from previous
          if (selectedValues[fieldName]) {
            const prevButton = document.querySelector(`.goal-button[data-goal="${selectedValues[fieldName]}"]`);
            if (prevButton) prevButton.classList.remove("active");
          }

          button.classList.add("active");
          selectedValues[fieldName] = label;

          // Set hidden input value
          field.value = mapLabelToBackend(label);
        });
      });

      function mapLabelToBackend(label) {
        const map = {
          "Full Gym Setup": "full_gym",
          "Home / Minimal Setup": "home",
        };
        return map[label] || label.toLowerCase().replace(" ", "_");
      }
    });
  </script>
</body>
</html>
