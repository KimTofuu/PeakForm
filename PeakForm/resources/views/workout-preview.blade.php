<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Workout Preview</title>
  <link rel="stylesheet" href="{{ asset('css/workout_plan.css') }}">
</head>
<body>
    <div class="container">
        <h2>Your workout preview!</h2>
        <img src="images/logo_6.png" alt="Dumbbell Icon" class="icon" />

        <div class="workout-box">
        <div class="workouts-card">
          @php
            $dayCount = 1; // Initialize a counter for day numbers
          @endphp

          @foreach ($workouts as $exercises)
            <div class="daily_tab_3">
              <div class="header_content">
                <h2 style="font-family: 'Michroma', sans-serif;">Day {{ $dayCount }}</h2> <!-- Day 1, Day 2, ... -->
              </div>

              @forelse ($exercises as $exercise)
                <div class="workout_content_2">
                  <label>
                    {{ $exercise }}
                  </label>
                </div>
              @empty
                <p>No exercises for this day.</p>
              @endforelse
            </div>

            @php
              $dayCount++; // Increment the day number for each loop iteration
            @endphp
          @endforeach
          
        </div>
        </div>
        <br>
        <a href="{{ route('overview_tab') }}" class = "button_proceed">
          Proceed
        </a>
    </div>

    <script src="script.js"> </script>
    <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  

</body>
</html>