document.addEventListener("DOMContentLoaded", function() {
  const tablesChairsContainer = document.getElementById("tables-chairs");
  const computerSeatsContainer = document.getElementById("computer-seats");
  const graduateStudyContainer = document.getElementById("graduate-seats");
  const tablesChairsAvailableSeatCount = document.getElementById("tables-chairs-available-seat-count");
  const computerSeatsAvailableSeatCount = document.getElementById("computer-seats-available-seat-count");
  const graduateStudyAvailableSeatCount = document.getElementById("graduate-seats-available-seat-count");

  const floorImage = document.getElementById("floor-image");
  const upButton = document.getElementById("up-button");
  const downButton = document.getElementById("down-button");

  let currentFloor = 'ground';

  function showFloor(floor) {
    if (floor === 'ground') {
      floorImage.src = localStorage.getItem('groundFloorImage') || 'assets/image/GROUND FLOOR.png';
      currentFloor = 'ground';
    } else {
      floorImage.src = localStorage.getItem('secondFloorImage') || 'assets/image/SECOND FLOOR.png';
      currentFloor = 'second';
    }
  }

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
      tablesChairs: 184,
      computer: 9,
      graduate: 30,
    };

    renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, totalSeats.tablesChairs, seatsState);
    renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, totalSeats.tablesChairs, totalSeats.computer, seatsState);
    renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, totalSeats.tablesChairs + totalSeats.computer, totalSeats.graduate, seatsState);
  }

  function initialize() {
    showFloor('ground');
    updateSeats();
  }

  // Initialize the view on page load
  initialize();

  // Event listeners for floor change buttons
  upButton.addEventListener("click", () => {
    if (currentFloor === 'ground') {
      showFloor('second');
    }
  });

  downButton.addEventListener("click", () => {
    if (currentFloor === 'second') {
      showFloor('ground');
    }
  });

  // Listen for localStorage changes
  window.addEventListener('storage', function(event) {
    if (event.key === 'groundFloorImage' || event.key === 'secondFloorImage' || event.key === 'seatsState' || event.key === 'totalSeats') {
      updateSeats();
      showFloor(currentFloor); // Refresh the floor image
    }
  });

  // Set an interval to check for changes (fallback)
  setInterval(() => {
    updateSeats();
    showFloor(currentFloor);
  }, 1000);  // Check every second
});


document.addEventListener('DOMContentLoaded', function () {
  // Handle Accept button click
  document.getElementById('acceptBtn').addEventListener('click', function () {
      // Show confirmation message
      alert('Thank you for your cooperation and participation in the PLVIL project. If you have any questions or concerns regarding this consent form or the AR feature, please do not hesitate to contact us.');
      
      // Redirect to AR scan page after a short delay
      setTimeout(function() {
          window.location.href = '../../AR/ar-scan.html';
      }, 1000); // Delay of 1 second
  });

  // Handle Decline button click (close modal by default)
  document.getElementById('declineBtn').addEventListener('click', function () {
      $('#arModal').modal('hide');
  });
});

