const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const path = require('path');
const fs = require('fs');

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

// Initialize seats state and total seats
let seatsState = Array(223).fill(false);
let totalSeats = {
  tablesChairs: 184,
  computer: 9,
  graduate: 30,
};

// Initialize image paths
let images = {
  groundFloor: 'assets/image/GROUND FLOOR.png',
  secondFloor: 'assets/image/SECOND FLOOR.png',
};

// Function to broadcast data to all connected clients
function broadcast(data) {
  wss.clients.forEach((client) => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(JSON.stringify(data));
    }
  });
}

// WebSocket server connection handler
wss.on('connection', (ws) => {
  console.log('New client connected');

  // Send initial state to the newly connected client
  ws.send(JSON.stringify({ seatsState, totalSeats, images }));

  ws.on('message', (message) => {
    try {
      const { action, section, seatId, floorImage } = JSON.parse(message);

      if (action === 'toggleSeat' && seatId !== undefined) {
        seatsState[seatId] = !seatsState[seatId];
        broadcast({ seatsState });
      } else if (action === 'addSeat') {
        handleAddSeat(section);
      } else if (action === 'removeSeat') {
        handleRemoveSeat(section);
      } else if (action === 'updateImage' && floorImage) {
        handleUpdateImage(floorImage);
      } else {
        console.error('Unknown action or missing parameters:', action);
      }
    } catch (error) {
      console.error('Error processing message:', error);
    }
  });

  ws.on('close', () => {
    console.log('Client disconnected');
  });
});

// Handle add seat action
function handleAddSeat(section) {
  if (section === 'tables-chairs') {
    totalSeats.tablesChairs++;
    seatsState.splice(totalSeats.tablesChairs - 1, 0, false);
  } else if (section === 'computer-seats') {
    totalSeats.computer++;
    seatsState.splice(totalSeats.tablesChairs + totalSeats.computer - 1, 0, false);
  } else if (section === 'graduate-seats') {
    totalSeats.graduate++;
    seatsState.splice(totalSeats.tablesChairs + totalSeats.computer + totalSeats.graduate - 1, 0, false);
  }
  broadcast({ seatsState, totalSeats });
}

// Handle remove seat action
function handleRemoveSeat(section) {
  if (section === 'tables-chairs' && totalSeats.tablesChairs > 0) {
    totalSeats.tablesChairs--;
    seatsState.splice(totalSeats.tablesChairs, 1);
  } else if (section === 'computer-seats' && totalSeats.computer > 0) {
    totalSeats.computer--;
    seatsState.splice(totalSeats.tablesChairs + totalSeats.computer, 1);
  } else if (section === 'graduate-seats' && totalSeats.graduate > 0) {
    totalSeats.graduate--;
    seatsState.splice(totalSeats.tablesChairs + totalSeats.computer + totalSeats.graduate, 1);
  }
  broadcast({ seatsState, totalSeats });
}

// Handle image update action
function handleUpdateImage(floorImage) {
  const { floor, dataUrl } = floorImage;
  const fileName = floor === 'ground' ? 'GROUND FLOOR.png' : 'SECOND FLOOR.png';
  const filePath = path.join(__dirname, 'CHAIRS', 'assets', 'image', fileName);
  const base64Data = dataUrl.replace(/^data:image\/png;base64,/, '');

  fs.writeFile(filePath, base64Data, 'base64', (err) => {
    if (err) {
      console.error('Error saving image:', err);
    } else {
      images[floor === 'ground' ? 'groundFloor' : 'secondFloor'] = filePath;
      broadcast({ images });
    }
  });
}

// Serve static files from the 'CHAIRS' directory
app.use(express.static('CHAIRS'));

// Serve admin page as default
app.get('/', (req, res) => {
  res.redirect('/admin');
});

app.get('/admin', (req, res) => {
  res.sendFile(path.join(__dirname, 'CHAIRS', 'chairs-admin.html'));
});

app.get('/user', (req, res) => {
  res.sendFile(path.join(__dirname, 'CHAIRS', 'chairs-user.html'));
});

// Start the server
server.listen(3000, '192.168.254.124', () => {
  console.log('Server is running on http://192.168.254.124:3000');
});