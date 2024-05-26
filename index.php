<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/classes/book.php';
$db = new DBConnection();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLVIL</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-md">
        <div class="container-lg">
            <a href="index.html" class="navbar-brand">
                <span class="fw-bold text-light display-5">PLVIL</span>
            </a>

            <!--toggle button for mobile-->
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav"
                aria-controls="main-nav" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span></button>

            <!--navbar links-->
            <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
                <ul class="navbar-nav">
                    <li class="class-item">
                        <a href="index.html" class="ms-3 fs-5 text-light fw-bold nav-link">Home</a>
                    </li>
                    <li class="class-item">
                        <a href="browse.html" class="fs-5 text-light fw-bold nav-link">Browse</a>
                    </li>
                    <li class="class-item">
                        <a href="AR/index.html" class="fs-5 text-light fw-bold nav-link">AR Scan</a>
                    </li>
                    <li class="class-item">
                        <a href="chairs-user.html" class="fs-5 text-light fw-bold nav-link">Chairs</a>
                    </li>
                    <li class="class-item">
                        <a href="about.html" class="fs-5 text-light fw-bold nav-link active">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!--search bar-->
    <section class="search-sec">
        <div class="container-fluid pt-5">
            <div class="logo">
                <img src="assets/plvlogo.png" class="img-fluid rounded mx-auto d-block my-5" alt="PLV Logo">
            </div>

            <!--search bar-->
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6">
                    <div class="search container mb-5">
                        <div class="input-group">
                            <select id="searchType" class="form-select rounded-start-pill">
                                <option value="title">Title</option>
                                <option value="author">Author</option>
                                <option value="year">Year</option>
                                <option value="category">Category</option>
                            </select>

                            <input type="text" class="form-control  rounded-end-pill" id="searchInput"
                                placeholder="Search...">
                        </div>
                    </div>
                </div>
            </div>

            <!--results-->
            <table id="booksTable" class="table table-striped table-hover table-responsive d-none">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="10%">Category</th>
                        <th width="10%">Book Stem</th>
                        <th width="10%">Front Cover</th>
                        <th width="10%">Title</th>
                        <th width="10%">Author</th>
                        <th width="5%" class="d-none d-lg-table-cell">Column Number</th>
                        <th width="5%" class="d-none d-lg-table-cell">Accession</th>
                        <th width="5%" class="d-none d-lg-table-cell">Edition</th>
                        <th width="5%" class="d-none d-lg-table-cell">Year</th>
                        <th width="10%" class="d-none d-lg-table-cell">Property</th>
                        <th width="10%" class="d-none d-lg-table-cell">ISBN/ISSN</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        // getting all books list
        $bookObj = new book();
        $books = $bookObj->getAllBooks();
        $no = 0;
        $matchesFound = false; // Flag to track if any matches are found

        foreach ($books as $book):
            $no++;
            $matchesFound = true; // Assuming at least one book found

            // Add a link to each row with the correct book ID
            $bookId = $book['bookId'];
            ?>
            <tr data-book-id="<?php echo $bookId; ?>">
                <td><?php echo $no; ?></td>
                <td><?php echo $book['bookCategory']; ?></td>
                <td><img src="/PLVIL/Admin/uploads/<?php echo $book['image1']; ?>" alt="Book Stem"
                        style="width: 100px; height: 100px; border-radius: 0%"></td>
                <td><img src="/PLVIL/Admin/uploads/<?php echo $book['image2']; ?>" alt="Front Cover"
                        style="width: 100px; height: 100px; border-radius: 0%"></td>
                <td><?php echo $book['Title']; ?></td>
                <td><?php echo $book['Author']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['columnNumber']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['Accession']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['bookEdition']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['bookYear']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['Property']; ?></td>
                <td class="d-none d-lg-table-cell"><?php echo $book['isbn']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>

                <script>
                    var matchesFound = <?php echo json_encode($matchesFound); ?>;
                </script>
            </table>


        </div>
    </section>

    <div id="noMatchesMessage"
        class="d-none d-flex justify-content-center align-items-center text-center bg-light container mx-auto py-5">
        <h1>No matches found.</h1>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        $(document).ready(function () {
            // Add click event listener to each row
    $('tbody tr').on('click', function() {
        // Extract the book ID from the row's data attribute
        var bookId = $(this).data('book-id');

        // Construct the URL for bookloc.html with the book ID as a query parameter
        var url = 'bookloc.html?bookId=' + bookId;

        // Redirect to bookloc.html
        window.location.href = url;
    });

            // Function to check if there are matches found during search
            function checkMatchesFound() {
                if (!matchesFound) {
                    $('#booksTable').addClass('d-none');
                    $('#noMatchesMessage').removeClass('d-none');
                } else {
                    $('#booksTable').removeClass('d-none');
                    $('#noMatchesMessage').addClass('d-none');
                }
            }

            // Function to check if the search input is empty
            function checkSearchInput() {
                var searchInput = $('#searchInput').val().trim();
                if (searchInput === '') {
                    $('#booksTable').addClass('d-none');
                    $('#noMatchesMessage').addClass('d-none');
                } else {
                    $('#booksTable').removeClass('d-none');
                    checkMatchesFound();
                }
            }

            // Call the function on page load
            checkSearchInput();

            // Function for search
            $('#searchInput').on('input', function () {
                var searchType = $('#searchType').val(); // Get the selected search type (e.g. title, author, etc.)
                var searchText = $(this).val().toLowerCase();
                var rows = $('tbody tr');
                var matches = false;

                rows.each(function () {
                    var shouldShowRow = false; // Initially set shouldShowRow to false

                    // Check searchType and compare the appropriate column based on search type
                    if (searchType === 'title') {
                        var title = $(this).find('td:eq(4)').text().toLowerCase(); // Title is in the 5th column (index 4)
                        shouldShowRow = title.includes(searchText);
                    } else if (searchType === 'author') {
                        var author = $(this).find('td:eq(5)').text().toLowerCase(); // Author is in the 6th column (index 5)
                        shouldShowRow = author.includes(searchText);
                    } else if (searchType === 'year') {
                        var year = $(this).find('td:eq(9)').text().toLowerCase(); // Year is in the 10th column (index 9)
                        shouldShowRow = year.includes(searchText);
                    } else if (searchType === 'category') {
                        var category = $(this).find('td:eq(1)').text().toLowerCase(); // Category is in the 2nd column (index 1)
                        shouldShowRow = category.includes(searchText);
                    }

                    // Show or hide the row based on the value of shouldShowRow
                    if (shouldShowRow) {
                        $(this).show();
                        matches = true;
                    } else {
                        $(this).hide();
                    }
                });

                // Set the matchesFound variable based on matches
                matchesFound = matches;

                // Show or hide the table and message based on matches found
                checkMatchesFound();

                // Check if search input is empty and hide elements accordingly
                checkSearchInput();
            });

            // Function for sorting by category
            $('#categoryFilter').on('change', function () {
                var selectedCategory = $(this).val();
                filterBooks(selectedCategory);
            });

            function filterBooks(category) {
                $('tbody tr').hide(); // Hide all rows initially
                if (category === 'all') {
                    $('tbody tr').show(); // Show all rows if 'All Categories' selected
                } else {
                    $('tbody tr').each(function () {
                        var bookCategory = $(this).find('td:eq(1)').text(); // Index 1 corresponds to the Category column
                        if (bookCategory === category) {
                            $(this).show(); // Show rows matching the selected category
                        }
                    });
                }
            };

        });

        document.addEventListener("DOMContentLoaded", function () {
            // Automatically load the literature category on page load
            fetchBooksByCategory('Literature');
            const categories = document.querySelectorAll('.category');

            categories.forEach(category => {
                category.addEventListener('click', function () {
                    const categoryName = category.getAttribute('data-category');
                    fetchBooksByCategory(categoryName);
                });
            });

            function fetchBooksByCategory(category) {
                fetch('Admin/browse_backend.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ category })
                })
                    .then(response => response.json())
                    .then(data => {
                        displayBooks(data, category);
                    })
                    .catch(error => {
                        console.error('Error fetching books:', error);
                    });
            }

            function displayBooks(books, category) {
                const bookListId = `book-list-${category.toLowerCase()}`;
                const bookList = document.getElementById(bookListId);
                if (bookList) {
                    bookList.innerHTML = ''; // Clear previous books

                    books.forEach(book => {
                        const bookCard = `
                            <div class="col">
                                <div class="card p-1 text-center">
                                    <img src="Admin/uploads/${book.image2}" class="card-img-top">
                                    <div class="card-body">
                                        <div class="card-title pt-1 fw-bold fs-4">${book.Title}</div>
                                        <a href="bookloc.html?bookId=${book.bookId}" class="text-decoration-none stretched-link text-black fw-semibold">${book.Author}</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        bookList.innerHTML += bookCard;
                    });
                }
            }
        });

    </script>
</body>

</html>