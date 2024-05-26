<?php
require_once('DBseatInitialize.php'); // Include the file containing the DBseatInitialize class

// Initialize seats
$dbSeatInitialize = new DBseatInitialize();
$dbSeatInitialize->initializeSeats();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin View - Library Seat Viewer</title>
  <link rel="stylesheet" href="tnc-ad.css">
</head>
<body>
  <div class="container">
    <h1>Library Seat Viewer</h1>
    <div class="legend">
      <div class="legend-item">
        <div class="available"></div>
        <span>Available</span>
      </div>
      <div class="legend-item">
        <div class="occupied-legend"></div>
        <span>Occupied</span>
      </div>
    </div>
    <div class="allseats">
      <h3>Tables and Chairs</h3>
      <div class="layout-container">
        <div id="tables-chairs" class="layout tables-chairs"></div>
      </div>
      <div class="available-seats">
        Available Seats: <span id="tables-chairs-available-seat-count">160</span> Seats
      </div>
      <div class="button-container">
        <button onclick="addSeat('tables-chairs')" class="add-button">Add Seat</button>
        <button onclick="removeSeat('tables-chairs')" class="remove-button">Remove Seat</button>
      </div>
    </div>
    <h3>Computer Seats</h3>
    <div class="layout-container">
      <div id="computer-seats" class="layout computer"></div>
    </div>
    <div class="available-seats">
      Available Seats: <span id="computer-seats-available-seat-count">9</span> Seats
    </div>
    <div class="button-container">
      <button onclick="addSeat('computer-seats')" class="add-button">Add Seat</button>
      <button onclick="removeSeat('computer-seats')" class="remove-button">Remove Seat</button>
    </div>
    <h3>Graduate Study</h3>
    <div class="layout-container">
      <div id="graduate-seats" class="layout graduate"></div>
    </div>
    <div class="available-seats">
      Available Seats: <span id="graduate-seats-available-seat-count">30</span> Seats
    </div>
    <div class="button-container">
      <button onclick="addSeat('graduate-seats')" class="add-button">Add Seat</button>
      <button onclick="removeSeat('graduate-seats')" class="remove-button">Remove Seat</button>
    </div>
  </div>
  <script src="tnc-ad.js"></script>
</body>
</html>
