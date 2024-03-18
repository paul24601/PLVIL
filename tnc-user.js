document.addEventListener("DOMContentLoaded", function() {
  const userSeatsContainer = document.getElementById("user-seats");
  const availableSeatCount = document.getElementById("available-seat-count");

  // Function to render user view seats and update available seat count
  function renderUserSeats() {
    const seatsState = JSON.parse(localStorage.getItem("seatsState")) || Array(80).fill(false);
    userSeatsContainer.innerHTML = ""; // Clear container
    let availableCount = 0;
    seatsState.forEach((occupied, index) => {
      const seat = document.createElement("div");
      seat.classList.add(occupied ? "occupied" : "seat");
      seat.dataset.id = index;
      userSeatsContainer.appendChild(seat);
      if (!occupied) {
        availableCount++;
      }
    });
    availableSeatCount.textContent = availableCount;
  }

  renderUserSeats(); // Initial render

  // Listen for changes in local storage
  window.addEventListener("storage", function(event) {
    if (event.key === "seatsState") {
      renderUserSeats(); // Update user view when seats state changes
    }
  });
});
