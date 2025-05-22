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

    <form action="{{ route('workout_plan_6') }}" method="POST">
      @csrf
      <div class="form-box">
        <p class="question">Select your Workout Routine Type <br><span>(Select one)</span></p>
        <div class="goal-options">
          <button type="button" class="goal-button" data-goal="PPL"> <img src="images/PPL.png"> </button>
          <button type="button" class="goal-button" data-goal="Upper/Lower"> <img src="images/upperLower.png"> </button>
          <button type="button" class="goal-button" data-goal="Full Body"> <img src="images/fullBody.png"></button>
        </div>
      </div>

      <input type="hidden" name="splitType" id="selected-splitType" />
      <button type="submit" class="proceed-button"> <img src="images/proceed.png"> </button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let selectedValues = {};

      document.querySelectorAll(".goal-button").forEach(button => {
        button.addEventListener("click", () => {
          const field = document.getElementById("selected-splitType");
          const fieldName = field.getAttribute("name");
          const label = button.getAttribute("data-goal");

          if (selectedValues[fieldName] === label) return;

          // Remove active class from previously selected
          if (selectedValues[fieldName]) {
            const prevButton = document.querySelector(`.goal-button[data-goal="${selectedValues[fieldName]}"]`);
            if (prevButton) prevButton.classList.remove("active");
          }

          // Set current button as active
          button.classList.add("active");
          selectedValues[fieldName] = label;

          // Update hidden input
          field.value = mapLabelToBackend(label);
        });
      });

      function mapLabelToBackend(label) {
        const map = {
          "PPL": "PPL",
          "Upper/Lower": "Upper Lower",
          "Full Body": "Full Body",
        };
        return map[label] || label.toLowerCase().replace(" ", "_");
      }
    });
  </script>
</body>
</html>
