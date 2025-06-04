<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Workout Preview</title>
  <link rel="stylesheet" href="{{ asset('css/workout_plan.css') }}">
</head>
<body style="background-image: url('../images/background-18.jpg'); background-size: auto 120%;  background-position: center; background-repeat: no-repeat; overflow-x:hidden;">
    <div class="container">
        <img src="images/logo_9.png" class="logo_top">

        <div class="workout-box">
        <div class="workouts-card">
          @php
            $dayCount = 1; // Initialize a counter for day numbers
          @endphp

          @foreach ($workouts as $exercises)
            <div class="daily_tab_3">
              <div class="header_content">
                <h2 style="font-family: 'Michroma', sans-serif;color:#1c7ed6; font-size:1.9rem;" >Day {{ $dayCount }}</h2> <!-- Day 1, Day 2, ... -->
              </div>

              @forelse ($exercises as $exercise)
                  <div class="workout_content_2">
                    <label style="color:#1a1a1a;">
                      @php
    // Unwrap $title until it's a string
    $title = is_array($exercise) && isset($exercise['title']) ? $exercise['title'] : $exercise;
    while (is_array($title) && isset($title['title'])) {
        $title = $title['title'];
    }
    if (!is_string($title)) {
        $title = '[Unknown Exercise]';
    }
@endphp
<label style="color:#1a1a1a;">
    {{ $title }}
    @if(is_array($exercise) && isset($exercise['sets'], $exercise['reps']) && $exercise['sets'] && $exercise['reps'])
        ({{ $exercise['sets'] }} sets x {{ $exercise['reps'] }} reps)
    @endif
</label>
                  </div>
              @empty
                  <p style="color:#1a1a1a;">No exercises for this day.</p>
              @endforelse
            </div>

            @php
              $dayCount++; // Increment the day number for each loop iteration
            @endphp
          @endforeach
          
        </div>
        </div>
        <br>
        <a href="{{ route('overview_tab') }}" >
          <button type="submit" class="proceed-button">
          <img src="images/proceed.png" alt="Proceed">
          <span class="button-text">Proceed</span>
          </button>
        </a>
    </div>

    <script src="script.js"> </script>
    <script src="https://cdn.botpress.cloud/webchat/v2.4/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/04/26/11/20250426115151-6TMZVHFH.js"></script>  

</body>
</html>