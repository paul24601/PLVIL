<?php

require_once "db_functions.php";

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
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 1;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 2;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 3;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 4;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 5;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 6;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 7;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 8;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 9;">
    <img src="Image1.png" alt="Image" class="seat-image" style="--index: 10;">
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
    <div id="seats" class="layout">
    </div>
    <div class="available-seats">Available Seats: <span id="available-seat-count">80</span> Seats</div>
  </div>
  <script src="tnc-ad.js"></script>
</body>
</html>
