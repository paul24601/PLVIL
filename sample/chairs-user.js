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
  
    // Function to render seats and update available seat count
    function renderSeats(container, availableSeatCountElement, start, totalSeats, seatsState) {
      container.innerHTML = ""; // Clear container
      let availableCount = 0;
      seatsState.slice(start, start + totalSeats).forEach((occupied, index) => {
        const seat = document.createElement("div");
        seat.classList.add(occupied ? "occupied" : "seat");
        container.appendChild(seat);
        if (!occupied) {
          availableCount++;
        }
      });
      availableSeatCountElement.textContent = availableCount;
    }
  
    // Function to update seat availability in real-time
    function updateSeats(seatsState) {
      renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, TABLES_CHAIRS_SEATS, seatsState);
      renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, TABLES_CHAIRS_SEATS, COMPUTER_SEATS, seatsState);
      renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, TABLES_CHAIRS_SEATS + COMPUTER_SEATS, GRADUATE_SEATS, seatsState);
    }
  
    // Initialize seats state from local storage or set to empty array
    let seatsState = JSON.parse(localStorage.getItem("seatsState"));
    if (!seatsState || seatsState.length !== TOTAL_SEATS) {
      seatsState = Array(TOTAL_SEATS).fill(false); // Ensure seatsState has TOTAL_SEATS elements
      localStorage.setItem("seatsState", JSON.stringify(seatsState)); // Initialize local storage
    }
  
    // Update seats initially
    updateSeats(seatsState);
  
    // Listen for changes in local storage
    window.addEventListener("storage", function(event) {
      if (event.key === "seatsState") {
        updateSeats(JSON.parse(event.newValue));
      }
    });
  
    // Disable seat clicking
    function preventSeatClick(event) {
      event.preventDefault();
    }
  
    tablesChairsContainer.addEventListener("click", preventSeatClick);
    computerSeatsContainer.addEventListener("click", preventSeatClick);
    graduateStudyContainer.addEventListener("click", preventSeatClick);
  });
  