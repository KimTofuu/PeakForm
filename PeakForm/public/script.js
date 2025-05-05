let selectedValues = {}; // Tracks selected value per input field

document.querySelectorAll(".goal-button").forEach(button => {
  button.addEventListener("click", () => {
    const field = button.closest("form").querySelector("input[type='hidden']");
    const fieldName = field.getAttribute("name");
    const label = button.getAttribute("data-goal");

    if (selectedValues[fieldName] === label) return;

    // Remove active class from previous
    if (selectedValues[fieldName]) {
      const prevButton = document.querySelector(`.goal-button[data-goal="${selectedValues[fieldName]}"]`);
      if (prevButton) prevButton.classList.remove("active");
    }

    // Set active
    button.classList.add("active");
    selectedValues[fieldName] = label;

    // Set hidden input value
    field.value = mapLabelToBackend(label);
  });
});

function mapLabelToBackend(label) {
  const map = {
    // Goal step
    "Lose Fat": "lose_fat",
    "Build Muscle": "gain_muscle",
    "Get Toned": "maintenance",

    // Intensity step
    "High Intensity": "high",
    "Moderate": "moderate",
    "Low Intensity": "low",

    // Setup step (if any)
    "Full Gym": "full_gym",
    "Home": "home",

    // Level step (if any)
    "Beginner": "beginner",
    "Intermediate": "intermediate",
    "Advanced": "advanced",
  };

  return map[label] || label.toLowerCase().replace(" ", "_"); // fallback
}

function openPrivacyModal(e) {
  e.preventDefault();
  document.getElementById('privacyModal').style.display = 'block';
}

function closePrivacyModal() {
  document.getElementById('privacyModal').style.display = 'none';
}

window.onclick = function(event) {
  if (event.target == document.getElementById('privacyModal')) {
    closePrivacyModal();
  }
}


    document.querySelectorAll('.faq-question').forEach(question => {
      question.addEventListener('click', () => {
          question.classList.toggle('active');
          const answer = question.nextElementSibling;
          answer.classList.toggle('show');
      });
  });
  



  document.addEventListener('DOMContentLoaded', function () {
      let time = 300; // default 5 minutes
      let originalTime = time;
      let interval = null;
      const timerDisplay = document.getElementById('timer');

      function updateDisplay() {
          const minutes = Math.floor(time / 60);
          const seconds = time % 60;
          timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      }

      function startTimer() {
          if (interval) return; // avoid double interval
          interval = setInterval(() => {
              if (time <= 0) {
                  clearInterval(interval);
                  interval = null;
                  timerDisplay.textContent = "Time's up!";
                  return;
              }
              time--;
              updateDisplay();
          }, 1000);
      }

      function stopTimer() {
          clearInterval(interval);
          interval = null;
      }

      function resetTimer() {
          stopTimer();
          time = originalTime;
          updateDisplay();
      }

      function editTime() {
          const input = prompt("Enter new time in minutes:", time / 60);
          if (input && !isNaN(input)) {
              stopTimer();
              time = parseInt(input) * 60;
              originalTime = time;
              updateDisplay();
          }
      }

      // Initial display
      updateDisplay();

      // Event listeners
      document.getElementById('startBtn').addEventListener('click', startTimer);
      document.getElementById('stopBtn').addEventListener('click', stopTimer);
      document.getElementById('resetBtn').addEventListener('click', resetTimer);
      document.getElementById('editBtn').addEventListener('click', editTime);
  });




    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('progressChart').getContext('2d');

        const progressChart = new Chart(ctx, {
            type: 'bar', // Change to 'line' or 'pie' if you prefer
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Progress (%)',
                    data: [25, 40, 65, 90], // Sample progress data
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    });
