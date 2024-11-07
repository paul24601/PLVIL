document.addEventListener("DOMContentLoaded", function () {
  const tablesChairsContainer = document.getElementById("tables-chairs");
  const computerSeatsContainer = document.getElementById("computer-seats");
  const graduateStudyContainer = document.getElementById("graduate-seats");
  const tablesChairsAvailableSeatCount = document.getElementById("tables-chairs-available-seat-count");
  const computerSeatsAvailableSeatCount = document.getElementById("computer-seats-available-seat-count");
  const graduateStudyAvailableSeatCount = document.getElementById("graduate-seats-available-seat-count");

  const TOTAL_SEATS = 223; // Update total seat count
  const TABLES_CHAIRS_SEATS = 184; // Update to 184 seats
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

  function updateSeats() {
    const seatsState = JSON.parse(localStorage.getItem("seatsState")) || [];
    const totalSeats = JSON.parse(localStorage.getItem("totalSeats")) || {
      tablesChairs: TABLES_CHAIRS_SEATS,
      computer: COMPUTER_SEATS,
      graduate: GRADUATE_SEATS,
    };

    renderSeats(tablesChairsContainer, tablesChairsAvailableSeatCount, 0, totalSeats.tablesChairs);
    renderSeats(computerSeatsContainer, computerSeatsAvailableSeatCount, totalSeats.tablesChairs, totalSeats.computer);
    renderSeats(graduateStudyContainer, graduateStudyAvailableSeatCount, totalSeats.tablesChairs + totalSeats.computer, totalSeats.graduate);
  }

  function loadImage(src, imgElement) {
    imgElement.src = src;
    imgElement.onload = () => console.log(`Image loaded: ${src}`);
    imgElement.onerror = () => console.error(`Error loading image: ${src}`);
  }

  // Check images on page
  document.querySelectorAll('img').forEach(img => {
    loadImage(img.src, img);
  });

  window.addSeat = addSeat;
  window.removeSeat = removeSeat;

  // Image toggling logic
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

  // Initial image load
  showFloor('ground');

  // Render all seats initially and set up interval for updates
  updateSeats();
  setInterval(updateSeats, 1000);  // Refresh every second to reflect changes

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

  // Modal and Image Upload Logic

  var modal = document.getElementById("editModal");
  var btn = document.getElementById("edit-button");
  var closeBtn = document.getElementsByClassName("close")[0];
  var cancelBtn = document.getElementsByClassName("cancel-btn")[0];
  var saveBtn = document.getElementById("save-button"); // Add reference to the save button
  var floorSelect = document.getElementById("floor-select");
  var floorImageUpload = document.getElementById("floor-image-upload");
  var tempImageUrl = '';  // Temporary storage for the uploaded image URL

  btn.onclick = function () {
    modal.style.display = "block";
  }

  closeBtn.onclick = function () {
    modal.style.display = "none";
  }

  cancelBtn.onclick = function () {
    modal.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  floorImageUpload.onchange = function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        tempImageUrl = e.target.result;  // Store the image temporarily
        alert('Image selected. Click Save to apply changes.');
      };
      reader.readAsDataURL(file);
    }
  };

  saveBtn.onclick = function () {
    if (tempImageUrl) {
      if (floorSelect.value === '1st') {
        localStorage.setItem('groundFloorImage', tempImageUrl);
        if (currentFloor === 'ground') showFloor('ground');
      } else if (floorSelect.value === '2nd') {
        localStorage.setItem('secondFloorImage', tempImageUrl);
        if (currentFloor === 'second') showFloor('second');
      }
      alert('Image saved and applied successfully!');
      tempImageUrl = '';  // Clear the temporary storage after saving
    } else {
      alert('No image selected.');
    }
    modal.style.display = "none";
  };

  // Example function to save changes and update localStorage
function saveChanges() {
  // Save floor images
  const groundImage = document.getElementById('ground-image-input').files[0];
  const secondImage = document.getElementById('second-image-input').files[0];
  
  if (groundImage) {
    localStorage.setItem('groundFloorImage', URL.createObjectURL(groundImage));
  }
  
  if (secondImage) {
    localStorage.setItem('secondFloorImage', URL.createObjectURL(secondImage));
  }
  
  // Save seats state
  const seatsState = getSeatsState(); // Your function to get current seats state
  localStorage.setItem('seatsState', JSON.stringify(seatsState));
  
  // Save total seats
  const totalSeats = getTotalSeats(); // Your function to get total seats
  localStorage.setItem('totalSeats', JSON.stringify(totalSeats));

  // Close modal
  modal.style.display = "none";
}
})
