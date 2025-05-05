let selectedGoal = null;

document.querySelectorAll(".goal-button").forEach(button => {
  button.addEventListener("click", () => {
    const goal = button.getAttribute("data-goal");

    if (selectedGoal === goal) return;

    if (selectedGoal !== null) {
      const prevButton = document.querySelector(`.goal-button[data-goal="${selectedGoal}"]`);
      if (prevButton) prevButton.classList.remove("active");
    }

    button.classList.add("active");
    selectedGoal = goal;

    // 🔥 Set hidden input value based on selected goal
    document.getElementById("selected-goal").value = mapGoalToBackend(goal);
  });
});

function mapGoalToBackend(label) {
  const goalMap = {
    "Lose Fat": "lose_fat",
    "Build Muscle": "gain_muscle",
    "Get Toned": "maintenance"
  };
  return goalMap[label] || "";
}


    function openPrivacyModal(e) {
      e.preventDefault();
      document.getElementById('privacyModal').style.display = 'block';
    }

    function closePrivacyModal() {
      document.getElementById('privacyModal').style.display = 'none';
    }

<<<<<<< Updated upstream
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
=======
    window.onclick = function(event) {
      if (event.target == document.getElementById('privacyModal')) {
        closePrivacyModal();
      }
    }
>>>>>>> Stashed changes
