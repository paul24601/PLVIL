document.addEventListener("DOMContentLoaded", function() {
  const tablesChairsContainer = document.getElementById("tables-chairs");
  const computerSeatsContainer = document.getElementById("computer-seats");
  const graduateStudyContainer = document.getElementById("graduate-seats");
  const tablesChairsAvailableSeatCount = document.getElementById("tables-chairs-available-seat-count");
  const computerSeatsAvailableSeatCount = document.getElementById("computer-seats-available-seat-count");
  const graduateStudyAvailableSeatCount = document.getElementById("graduate-seats-available-seat-count");

  const TOTAL_SEATS = 199;
  const TABLES_CHAIRS_SEATS = 160;
  const COMPUTER_SEATS = 9;
  const GRADUATE_SEATS = 30;

  let seatsState = JSON.parse(localStorage.getItem("seatsState")) || [];
  let totalSeats = JSON.parse(localStorage.getItem("totalSeats")) || {
    tablesChairs: TABLES_CHAIRS_SEATS,
    computer: COMPUTER_SEATS,
    graduate: GRADUATE_SEATS,
  };

  if (seatsState.length !== TOTAL_SEATS) {
    seatsState = Array(TOTAL_SEATS).fill(false);
    localStorage.setItem("seatsState", JSON.stringify(seatsState));
  }

  function renderSeats(container, availableSeatCountElement, start, totalSeats) {
    container.innerHTML = "";
    let availableCount = 0;
    seatsState.slice(start, start + totalSeats).forEach((occupied, index) => {
      const seat = document.createElement("div");
      seat.classList.add(occupied ? "occupied" : "seat");
      seat.dataset.id = start + index;
      container.appendChild(seat);
      if (!occupied) availableCount++;
    });
    availableSeatCountElement.textContent = availableCount;
  }

  function renderAll() {
    renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, totalSeats.tablesChairs);
    renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, totalSeats.tablesChairs, totalSeats.computer);
    renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, totalSeats.tablesChairs + totalSeats.computer, totalSeats.graduate);
  }

  function saveState() {
    localStorage.setItem("seatsState", JSON.stringify(seatsState));
    localStorage.setItem("totalSeats", JSON.stringify(totalSeats));
  }

  function addSeat(section) {
    if (section === "tables-chairs") {
      totalSeats.tablesChairs++;
      seatsState.splice(totalSeats.tablesChairs, 0, false);
    } else if (section === "computer-seats") {
      totalSeats.computer++;
      seatsState.splice(totalSeats.tablesChairs + totalSeats.computer, 0, false);
    } else if (section === "graduate-seats") {
      totalSeats.graduate++;
      seatsState.splice(totalSeats.tablesChairs + totalSeats.computer + totalSeats.graduate, 0, false);
    }
    saveState();
    renderAll();
  }

  function removeSeat(section) {
    if (section === "tables-chairs" && totalSeats.tablesChairs > 0) {
      totalSeats.tablesChairs--;
      seatsState.splice(totalSeats.tablesChairs, 1);
    } else if (section === "computer-seats" && totalSeats.computer > 0) {
      totalSeats.computer--;
      seatsState.splice(totalSeats.tablesChairs + totalSeats.computer, 1);
    } else if (section === "graduate-seats" && totalSeats.graduate > 0) {
      totalSeats.graduate--;
      seatsState.splice(totalSeats.tablesChairs + totalSeats.computer + totalSeats.graduate, 1);
    }
    saveState();
    renderAll();
  }

  window.addSeat = addSeat;
  window.removeSeat = removeSeat;

  renderAll();

  tablesChairsContainer.addEventListener("click", function(event) {
    if (event.target.classList.contains("seat") || event.target.classList.contains("occupied")) {
      const seatId = parseInt(event.target.dataset.id);
      seatsState[seatId] = !seatsState[seatId];
      saveState();
      renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, totalSeats.tablesChairs);
    }
  });

  computerSeatsContainer.addEventListener("click", function(event) {
    if (event.target.classList.contains("seat") || event.target.classList.contains("occupied")) {
      const seatId = parseInt(event.target.dataset.id);
      seatsState[seatId] = !seatsState[seatId];
      saveState();
      renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, totalSeats.tablesChairs, totalSeats.computer);
    }
  });

  graduateStudyContainer.addEventListener("click", function(event) {
    if (event.target.classList.contains("seat") || event.target.classList.contains("occupied")) {
      const seatId = parseInt(event.target.dataset.id);
      seatsState[seatId] = !seatsState[seatId];
      saveState();
      renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, totalSeats.tablesChairs + totalSeats.computer, totalSeats.graduate);
    }
  });
});
