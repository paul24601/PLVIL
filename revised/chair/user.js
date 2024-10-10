// Set up Server-Sent Events for real-time updates
const eventSource = new EventSource('sse.php');

eventSource.onmessage = function(event) {
    const occupancyData = JSON.parse(event.data);

    // Update the UI based on the occupancy data
    for (let chairId in occupancyData) {
        const status = occupancyData[chairId];
        const chairElement = document.querySelector(`.chair[data-chair-id="${chairId}"]`);
        if (status === 1) {
            chairElement.classList.add('occupied');
        } else {
            chairElement.classList.remove('occupied');
        }
    }
};

eventSource.onerror = function(event) {
    console.error("EventSource failed:", event);
};
