// gif fullsize click
function change(element) {
    element.classList.toggle("fullsize");
    var background = element.parentElement.parentElement.querySelector('.bookloc');
    background.classList.toggle("darken");
}
