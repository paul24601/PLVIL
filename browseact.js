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
// for active book category nav
document.addEventListener('DOMContentLoaded', function () {
    var bookCategoryLinks = document.querySelectorAll('.book-categories a');

    bookCategoryLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            bookCategoryLinks.forEach(function (link) {
                link.classList.remove('active');
            });

            link.classList.add('active');
        });
    });
});

