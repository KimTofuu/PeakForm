let selectedGoal = null;

document.querySelectorAll(".goal-button").forEach(button => {
  button.addEventListener("click", () => {
    const goal = button.getAttribute("data-goal");

    // Skip if already selected
    if (selectedGoal === goal) return;

    // Remove "active" from previously selected button
    if (selectedGoal !== null) {
      const prevButton = document.querySelector(`.goal-button[data-goal="${selectedGoal}"]`);
      if (prevButton) prevButton.classList.remove("active");
    }

    // Add "active" to newly selected button
    button.classList.add("active");
    selectedGoal = goal;
  });
});