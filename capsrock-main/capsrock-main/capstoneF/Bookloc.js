// for active nav header
document.addEventListener("DOMContentLoaded", function() {
    var currentPage = window.location.href;
    var navLinks = document.querySelectorAll(".navbar a");
    navLinks.forEach(function(link) {
        if (link.href === currentPage) {
            link.classList.add("active");
        }
    });
});

// gif fullsize click
function change(element) {
    element.classList.toggle("fullsize");
    var background = element.parentElement.parentElement.querySelector('.bookloc');
    background.classList.toggle("darken");
}
