document.addEventListener("DOMContentLoaded", function() {
  const tablesChairsContainer = document.getElementById("tables-chairs");
  const computerSeatsContainer = document.getElementById("computer-seats");
  const graduateStudyContainer = document.getElementById("graduate-seats");
  const tablesChairsAvailableSeatCount = document.getElementById("tables-chairs-available-seat-count");
  const computerSeatsAvailableSeatCount = document.getElementById("computer-seats-available-seat-count");
  const graduateStudyAvailableSeatCount = document.getElementById("graduate-seats-available-seat-count");

  function renderSeats(container, availableSeatCountElement, start, totalSeats, seatsState) {
    container.innerHTML = "";
    let availableCount = 0;
    seatsState.slice(start, start + totalSeats).forEach((occupied, index) => {
      const seat = document.createElement("div");
      seat.classList.add(occupied ? "occupied" : "seat");
      container.appendChild(seat);
      if (!occupied) availableCount++;
    });
    availableSeatCountElement.textContent = availableCount;
  }

  function updateSeats() {
    const seatsState = JSON.parse(localStorage.getItem("seatsState")) || [];
    const totalSeats = JSON.parse(localStorage.getItem("totalSeats")) || {
      tablesChairs: 160,
      computer: 9,
      graduate: 30,
    };

    renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, totalSeats.tablesChairs, seatsState);
    renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, totalSeats.tablesChairs, totalSeats.computer, seatsState);
    renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, totalSeats.tablesChairs + totalSeats.computer, totalSeats.graduate, seatsState);
  }

  updateSeats();
  setInterval(updateSeats, 1000);  // Refresh every second to reflect changes
});
