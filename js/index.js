// for advance search
let dropdownBtn = document.getElementById("drop-text");
let list = document.getElementById("list");
let icon = document.getElementById("icon");
let span = document.getElementById("span");
let input = document.getElementById("search-input");
let listItems = document.querySelectorAll(".dropdown-list-item");


dropdownBtn.onclick = function () {
    if (list.classList.contains('show')) {
        icon.style.rotate = "0deg";
    } else {
        icon.style.rotate = "-180deg";
    }
    list.classList.toggle('show');
};

window.onclick = function (e) {
    if (
        e.target.id !== "drop-text" &&
        e.target.id !== "span" &&
        e.target.id !== "icon"
    ) {
        list.classList.remove('show');
        icon.style.rotate = "0deg";
    }
};

for (item of listItems) {
    item.onclick = function (e) {
        span.innerText = e.target.innerText;

        input.placeholder = "Search for " + e.target.innerText;
    };
}