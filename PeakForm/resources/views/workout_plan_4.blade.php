<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Select Workout Days</title>
  <link rel="stylesheet" href="{{ asset('css/workout_plan.css') }}">
</head>
<body>
  <div class="container">
    <img src="images/logo_9.png" class="logo_top">

    <form action="{{ route('workout_plan_4') }}" method="POST">
      @csrf
      <div class="form-box">
        <p class="question">How many days a week do you want to work out?<br><span>(Select one)</span></p>
        <div class="day-options">
          @for ($i = 1; $i <= 6; $i++)
            <button type="button" class="day-button" data-day="{{ $i }}">{{ $i }}</button>
          @endfor
        </div>
      </div>

      <input type="hidden" name="days" id="selected-days" />
      <button type="submit" class="proceed-button"><img src="images/proceed.png"></button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let selected = {};

      document.querySelectorAll(".day-button").forEach(button => {
        button.addEventListener("click", () => {
          const field = document.getElementById("selected-days");
          const fieldName = field.getAttribute("name");
          const label = button.getAttribute("data-day");

          if (selected[fieldName] === label) return;

          // Remove previous active
          if (selected[fieldName]) {
            const prev = document.querySelector(`.day-button[data-day="${selected[fieldName]}"]`);
            if (prev) prev.classList.remove("active");
          }

          button.classList.add("active");
          selected[fieldName] = label;

          field.value = label;
        });
      });
    });
  </script>
</body>
</html>
