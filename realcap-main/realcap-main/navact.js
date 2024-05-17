document.addEventListener("DOMContentLoaded", function() {
    var currentPage = window.location.href;
    var navLinks = document.querySelectorAll(".navbar a");
    navLinks.forEach(function(link) {
        if (link.href === currentPage) {
            link.classList.add("active");
        }
    });
});