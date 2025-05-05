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
  