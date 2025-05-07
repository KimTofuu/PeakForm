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
    <h2>Let’s Build Your Personalized Plan!</h2>
    <img src="images/logo_4.png" alt="Dumbbell Icon" class="icon" />

    <form action="{{ route('workout_plan_3') }}" method="POST">
      @csrf
      <div class="form-box">
        <p class="question">Select Level of Expertise <br><span>(Select one)</span></p>
        <div class="goal-options">
          <button type="button" class="goal-button" data-goal="Beginner"><b> Beginner </b> <br> <span> New to working out or returning after a long break. </span></button>
          <button type="button" class="goal-button" data-goal="Intermediate"> <b> Intermediate </b> <br> <span> 6 months to 2 years of consistent training. </span> </button>
          <button type="button" class="goal-button" data-goal="Advanced"><b> Advanced </b> <br> <span>  2+ years of consistent and structured training. </span></button>
        </div>
      </div>

      <input type="hidden" name="intensity" id="selected-intensity" />
      <button type="submit" class="proceed-button"> Proceed </button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let selectedValues = {};

      document.querySelectorAll(".goal-button").forEach(button => {
        button.addEventListener("click", () => {
          const field = document.getElementById("selected-intensity");
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
          "High Intensity": "high",
          "Moderate": "moderate",
          "Low Intensity": "low",
        };
        return map[label] || label.toLowerCase().replace(" ", "_");
      }
    });
  </script>
</body>
</html>
