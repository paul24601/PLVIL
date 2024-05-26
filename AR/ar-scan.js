// Marker handler component
AFRAME.registerComponent('markerhandler', {
    schema: {
      soundSrc: { type: 'string' }
    },
    init: function() { 
      let curSound = document.querySelector(this.data.soundSrc);
      this.el.addEventListener('markerFound', () => {
        // Play the current sound file
        curSound.components.sound.playSound();
      });
  
      this.el.addEventListener('markerLost', () => {
        curSound.components.sound.stopSound();
      });
    }
  });
  
  // Function to handle changing pictures
  function changePicture(planeId) {
    var lastChangeTime = 0; // Variable to store the time of the last image change
    var currentTime = Date.now(); // Get the current time
    var timeSinceLastChange = currentTime - lastChangeTime; // Calculate the time since the last change
  
    // If less than 500 milliseconds have passed since the last change, exit the function
    if (timeSinceLastChange < 500) {
      return;
    }
  
    var plane = document.getElementById(planeId);
  
    // Check if the new source is different from the current one
    var newSrc = plane.getAttribute('src') === 'assets/sample-ar-1.png' ? 'assets/asset1.jpg' : 'assets/sample-ar-1.png';
  
    // Update the image source and the time of the last change
    plane.setAttribute('src', newSrc);
    lastChangeTime = currentTime;
  }
  window.addEventListener ("click", ()=>{
    const video = document.getElementById("video" )
    video.play()
  })