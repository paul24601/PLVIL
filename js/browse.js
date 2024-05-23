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
// for active book category and nextable
document.addEventListener("DOMContentLoaded", function() {
    const categories = document.querySelectorAll('.category');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    let startIndex = 0;
    const categoriesPerPage = 5;

    function showCategories(startIndex) {
        categories.forEach((category, index) => {
            if (index >= startIndex && index < startIndex + categoriesPerPage) {
                category.parentElement.style.display = 'block';
            } else {
                category.parentElement.style.display = 'none';
            }
        });

        if (startIndex + categoriesPerPage >= categories.length) {
            nextButton.disabled = true;
        } else {
            nextButton.disabled = false;
        }
    }

    function setActiveCategory(clickedCategory) {
        categories.forEach(category => {
            category.classList.remove('active_page');
        });
        clickedCategory.classList.add('active_page');
    }

    showCategories(startIndex);

    categories.forEach(category => {
        category.addEventListener('click', function() {
            setActiveCategory(category);
        });
    });

    nextButton.addEventListener('click', function() {
        startIndex += categoriesPerPage;
        showCategories(startIndex);
    });

    prevButton.addEventListener('click', function() {
        startIndex -= categoriesPerPage;
        if (startIndex < 0) {
            startIndex = 0;
        }
        showCategories(startIndex);
    });
});

// for pagination
let thisPage = 1;
let limit = 25;
let list = document.querySelectorAll('.list .item');

function loadItem() {
    let beginGet = limit * (thisPage - 1);
    let endGet = limit * thisPage - 1;
    list.forEach((item, key) => {
        if (key >= beginGet && key <= endGet) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    })
    listPage();
}
loadItem();

function listPage() {
    let count = Math.ceil(list.length / limit);
    document.querySelector('.listPage').innerHTML = '';

    if (thisPage > 1) {
        let prev = document.createElement('li');
        prev.innerText = 'PREV';
        prev.setAttribute('onclick', "changePage(" + (thisPage - 1) + ")");
        document.querySelector('.listPage').appendChild(prev);
    }

    let startPage = Math.max(1, thisPage - Math.floor(limit / 2));
    let endPage = Math.min(count, startPage + limit - 1);
    startPage = Math.max(1, endPage - limit + 1);

    for (let i = startPage; i <= endPage; i++) {
        let newPage = document.createElement('li');
        newPage.innerText = i;
        if (i === thisPage) {
            newPage.classList.add('active');
        }
        newPage.setAttribute('onclick', "changePage(" + i + ")");
        document.querySelector('.listPage').appendChild(newPage);
    }

    if (thisPage < count) {
        let next = document.createElement('li');
        next.innerText = 'NEXT';
        next.setAttribute('onclick', "changePage(" + (thisPage + 1) + ")");
        document.querySelector('.listPage').appendChild(next);
    }
}

function changePage(i) {
    thisPage = i;
    loadItem();
}
