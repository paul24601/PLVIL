document.addEventListener("DOMContentLoaded", loadChairs);

function loadChairs() {
    fetch("load_chairs.php")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("chairs-container");
            container.innerHTML = "";
            data.forEach(chair => {
                const button = document.createElement("button");
                button.classList.add("btn", "m-1");
                button.textContent = `Chair ${chair.seat_number}`;
                button.classList.add(chair.status === "occupied" ? "btn-danger" : "btn-success");
                button.onclick = () => toggleChair(chair.id);
                container.appendChild(button);
            });
        });
}

function toggleChair(id) {
    fetch(`toggle_chair.php?id=${id}`)
        .then(() => loadChairs());
}

function addChair() {
    fetch("add_chair.php")
        .then(() => loadChairs());
}
