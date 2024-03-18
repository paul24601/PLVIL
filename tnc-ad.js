document.addEventListener("DOMContentLoaded", function() {
  const seatsContainer = document.getElementById("seats");
  const availableSeatCount = document.getElementById("available-seat-count");

  // Initialize seats state from local storage or set to empty array
  let seatsState = JSON.parse(localStorage.getItem("seatsState"));
  if (!seatsState || seatsState.length !== 80) {
    seatsState = Array(80).fill(false); // Ensure seatsState has 80 elements
  }

  // Function to render seats and update available seat count
  function renderSeats() {
    seatsContainer.innerHTML = ""; // Clear container
    let availableCount = 0;
    seatsState.forEach((occupied, index) => {
      const seat = document.createElement("div");
      seat.classList.add(occupied ? "occupied" : "seat");
      seat.dataset.id = index;
      seatsContainer.appendChild(seat);
      if (!occupied) {
        availableCount++;
      }
    });
    availableSeatCount.textContent = availableCount;
  }

  renderSeats(); // Initial render

  // Seat click handler
  seatsContainer.addEventListener("click", function(event) {
    // Check if the clicked element is the container itself
    if (event.target === seatsContainer) {
      return; // Ignore the click event
    }
    const seat = event.target;
    const seatId = parseInt(seat.dataset.id);
    if (seat.classList.contains("occupied")) {
      seatsState[seatId] = false; // Set seat to available
    } else {
      seatsState[seatId] = true; // Set seat to occupied
    }
    localStorage.setItem("seatsState", JSON.stringify(seatsState)); // Update local storage
    renderSeats(); // Update view
  });
});
