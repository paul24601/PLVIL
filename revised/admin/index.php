<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/PLVIL/Admin/classes/book.php';
    $db = new DBConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Inventory</title>

    <link rel="stylesheet" type="text/css" href="css/inventory.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <script src="https://kit.fontawesome.com/12b70d5e20.js" crossorigin="anonymous"></script>    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="card-body">
        <div class="content">
            <div class="add-book">
                <button class="btn btn-success btn-md" data-toggle="modal" data-target="#addBook"><i class="fa-solid fa-plus"></i>Add New Book</button>
            <div class="filter">
                <label for="categoryFilter">Filter by Category:</label>
                <select class="form-select" id="categoryFilter">
                    <option value="all">All Categories</option>
                    <option value="Literature">Literature</option>
                    <option value="Education">Education</option>
                    <option value="Novel">Novel</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Technology">Technology</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Laws">Laws</option>
                    <option value="Architecture">Architecture</option>
                    <option value="Fiction">Fiction</option>
                </select>
            </div>
            </div>
            <div class="search">
                <div class="input-group">
                    <select id="searchType" class="form-select">
                    <option value="title">Title</option>
                    <option value="author">Author</option>
                    <option value="year">Year</option>
                    <option value="category">Category</option>
                </select>
        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
    </div>
</div>
    </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">Category</th>
                    <th width="10%">Book Stem</th>
                    <th width="10%">Front Cover</th>
                    <th width="10%">Title</th>
                    <th width="10%">Author</th>
                    <th width="10%">Shelves Number</th>
                    <th width="10%">Accession</th>
                    <th width="10%">Edition</th>
                    <th width="10%">Year</th>
                    <th width="10%">Property</th>
                    <th width="10%">Call Number</th>
                    <th width="10%">ISBN/ISSN</th>
                    <th width="10%">Manage Book</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    //getting all books list
                    $bookObj = new book();
                    $books = $bookObj->getAllBooks();
                    $no = 0; 
                    foreach ($books as $book): 
                        $no++;
                ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $book['bookCategory']; ?></td>
                        <td><img src="/PLVIL/Admin/uploads/<?php echo $book['image1']; ?>" alt="Book Stem" style="width: 100px; height: 100px; border-radius: 0%"></td>
                        <td><img src="/PLVIL/Admin/uploads/<?php echo $book['image2']; ?>" alt="Front Cover" style="width: 100px; height: 100px; border-radius: 0%"></td>
                        <td><?php echo $book['Title']; ?></td>
                        <td><?php echo $book['Author']; ?></td>
                        <td><?php echo $book['columnNumber']; ?></td>
                        <td><?php echo $book['Accession']; ?></td>
                        <td><?php echo $book['bookEdition']; ?></td>
                        <td><?php echo $book['bookYear']; ?></td>
                        <td><?php echo $book['Property']; ?></td>
                        <td><?php echo $book['CallNumber']; ?></td>
                        <td><?php echo $book['isbn']; ?></td>
                        <td>
                            <button style="width: 80px;" class="btn btn-primary btn-sm editButton" id="<?php echo $book['bookId']?>"><i class="fa-regular fa-pen-to-square"></i>Edit</button>
                            <button style="width: 80px;" class="btn btn-danger btn-sm deleteButton" id="<?php echo $book['bookId']?>"><i class="fa-regular fa-trash-can"></i>Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>        
    </div>               

    <!-- Modal for adding new book -->
<div class="modal fade" id="addBook" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Book</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addBookForm" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label style= " width: 160px;" class="input-group-text" for="inputGroupSelect01">Book Category</label>
                    <select class="form-select" id="bookCategory" name= "bookCategory" required>
                        <option selected selected disabled>Choose Category...</option>
                        <option value="Literature">Literature</option>
                        <option value="Education">Education</option>
                        <option value="Novel">Novel</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Technology">Technology</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Laws">Laws</option>
                        <option value="Architecture">Architecture</option>
                        <option value="Fiction">Fiction</option>
                    </select>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Title</span>
                <input type="text"name="Title" class="form-control" required placeholder="Enter Book Title" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Author</span>
                <input type="text"name="Author" class="form-control" required placeholder="Enter Book Author" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Shelves Number</span>
                <input type="text"name="columnNumber" class="form-control" required placeholder="Enter Shelves Number" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Accession</span>
                <input type="text"name="Accession" class="form-control" required placeholder="Enter Book Accession" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Edition</span>
                <input type="text"name="bookEdition" class="form-control" required placeholder="Enter Edition" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">Year</span>
                <input type="text"name="bookYear" class="form-control" required placeholder="Enter Year" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px; align-text: center;" class="input-group-text">Property</span>
                <input type="text"name="Property" class="form-control" required placeholder="Enter Property" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px; align-text: center;" class="input-group-text">Call Number</span>
                <input type="text"name="CallNumber" class="form-control" required placeholder="Enter Call Number" required>
            </div>
            <div class="input-group mb-3">
                <span style= " width: 160px;" class="input-group-text">ISBN/ISSN</span>
                <input type="text"name="isbn" class="form-control" required placeholder="Enter ISBN" required>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Image Book Stem</label>
                <input type="file" class="form-control" id="inputGroupFile01" name="image1" accept="image/*" required>            
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Image Front Cover</label>
                <input type="file" class="form-control" id="inputGroupFile02" name="image2" accept="image/*" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="addBookBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- ALERT -->
<div class="modal fade" id="alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Alert!</h1>
      </div>
      <div class="modal-body">
        <div class="alert"></div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" id="editBookId">
<!-- Add an edit modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" role="dialog" aria-labelledby="editBookModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBookModalLabel">Edit Book Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editBookForm">
          <input type="hidden" id="editBookId">
          <div class="input-group mb-3">
          <label style= " width: 160px;" class="input-group-text" for="bookCategoryEdit">Book Category</label>
            <select class="form-select" id="bookCategoryEdit" name="bookCategory">
              <option value="Literature">Literature</option>
              <option value="Education">Education</option>
              <option value="Novel">Novel</option>
              <option value="Entertainment">Entertainment</option>
              <option value="Technology">Technology</option>
              <option value="Engineering">Engineering</option>
              <option value="Laws">Laws</option>
              <option value="Architecture">Architecture</option>
              <option value="Fiction">Fiction</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="TitleEdit">Title</span>
            <input type="text" class="form-control" id="TitleEdit" name="Title" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="AuthorEdit">Author</span>
            <input type="text" class="form-control" id="AuthorEdit" name="Author" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="columnNumberEdit">Shelves Number</span>
            <input type="text" class="form-control" id="columnNumberEdit" name="columnNumber" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="AccessionEdit">Accession</span>
            <input type="text" class="form-control" id="AccessionEdit" name="Accession" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="bookEditionEdit">Book Edition</span>
            <input type="text" class="form-control" id="bookEditionEdit" name="bookEdition" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="bookYearEdit">Year</span>
            <input type="text" class="form-control" id="bookYearEdit" name="bookYear" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="PropertyEdit">Property</span>
            <input type="text" class="form-control" id="PropertyEdit" name="Property" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="callNumberEdit">Call Number</span>
            <input type="text" class="form-control" id="callNumberEdit" name="CallNumber" required>
          </div>
          <div class="input-group mb-3">
            <span style= " width: 160px;" class="input-group-text" for="isbnEdit">ISBN/ISSN</span>
            <input type="text" class="form-control" id="isbnEdit" name="isbn" required>
          </div>
          <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Image Book Stem</label>
                <input type="file" class="form-control" id="inputGroupFile03" name="image1" accept="image/*" >
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Image Front Cover</label>
                <input type="file" class="form-control" id="inputGroupFile04" name="image2" accept="image/*">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveEditBookBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    // Function to display alert
    function showAlert(message, type) {
        // Create an alert element
        var alertElement = $('<div>')
            .addClass('alert alert-' + type)
            .text(message);

        // Show the alert
        $('#alert .alert').replaceWith(alertElement);
        $('#alert').modal('show');

        // Automatically hide the alert after 3 seconds
        setTimeout(function() {
            $('#alert').modal('hide');
        }, 3000);
    }

     // ADD NEW BOOK
     $('#addBookBtn').on('click', function() {
        // Ask for confirmation before adding the new book
        var confirmAdd = confirm("Are you sure you want to add this book?");
        if (!confirmAdd) {
            return; // If the user does not confirm, stop form submission
        }

        // Reference to the form element
        var addBookForm = document.getElementById('addBookForm');

        // Check the form's validity using the HTML5 checkValidity method
        if (!addBookForm.checkValidity()) {
            // Form is not valid; trigger built-in error display
            addBookForm.reportValidity();
            return; // Stop execution to prevent the form from being submitted
        }

        // Prevent duplicate form submissions by disabling the button while the request is ongoing
        $(this).prop('disabled', true);

        // Collect form data using FormData
        var formData = new FormData(addBookForm);

        // Make an AJAX request to add a new book
        $.ajax({
            url: 'classes/Book.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);

                if (data.type === 'success') {
                    // Close the modal and show success alert
                    $('#addBook').modal('hide');
                    showAlert('Book successfully added', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    // Show error alert
                    showAlert('Failed to add book: ' + data.message, 'danger');
                }

                // Re-enable the button
                $('#addBookBtn').prop('disabled', false);
            },
            error: function() {
                // Handle request error
                showAlert('An error occurred while adding the book.', 'danger');
                $('#addBookBtn').prop('disabled', false);
            }
        });
    });



    // Edit button click event
    $('.editButton').on('click', function() {
        var bookId = $(this).attr('id'); // Get the book ID
        $('#editBookId').val(bookId); // Set the book ID in the hidden input field
        
        // Fetch book details by ID
        $.post('classes/Book.php', {getBookById: bookId}, function(data) {
            var bookData = JSON.parse(data);
            // Populate edit modal fields with fetched data
            $('#bookCategoryEdit').val(bookData.bookCategory);
            $('#TitleEdit').val(bookData.Title);
            $('#AuthorEdit').val(bookData.Author);
            $('#columnNumberEdit').val(bookData.columnNumber);
            $('#AccessionEdit').val(bookData.Accession);
            $('#bookEditionEdit').val(bookData.bookEdition);
            $('#bookYearEdit').val(bookData.bookYear);
            $('#PropertyEdit').val(bookData.Property);
            $('#callNumberEdit').val(bookData.callNumber);
            $('#isbnEdit').val(bookData.isbn);
            
            
            // Show the edit modal
            $('#editBookModal').modal('show');
        });
    });

    // Save edit book button click event
    $('#saveEditBookBtn').on('click', function() {
        // Ask for confirmation before updating the book
        var confirmEdit = confirm("Are you sure you want to update this book?");
        if (!confirmEdit) {
            return; // If the user does not confirm, stop form submission
        }

        // Collect form data, including files
        var form = document.getElementById('editBookForm');
        var formData = new FormData(form);

        // Add the book ID to the form data
        formData.append('bookId', $('#editBookId').val());

        // Make AJAX request to update the book details
        $.ajax({
            url: 'classes/Book.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.type === 'success') {
                    // Close the edit modal
                    $('#editBookModal').modal('hide');
                    showAlert('Book successfully updated', 'success');
                    
                    // Reload the page to reflect the updated data
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('Failed to update book: ' + data.message, 'danger');
                }
            },
            error: function() {
                showAlert('An error occurred while updating the book.', 'danger');
            }
        });
    });

    // Deleting books
    $('.deleteButton').on('click', function(e) {
        var confirmDelete = confirm("Are you sure you want to delete this book?");
        if (confirmDelete) {
            $.post('classes/Book.php', {deleteId: e.target.id}, function(data) {
                var data = JSON.parse(data);
                if (data.type === 'success') {
                    showAlert(data.message, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message, 'danger');
                }
            });
        }
    });

    // Function for search
$('#searchInput').on('input', function() {
    var searchType = $('#searchType').val(); // Get the selected search type (e.g. title, author, etc.)
    var searchText = $(this).val().toLowerCase();
    var rows = $('tbody tr');

    rows.each(function() {
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
        } else {
            $(this).hide();
        }
    });
});


    // Function for sorting by category
    $('#categoryFilter').on('change', function() {
        var selectedCategory = $(this).val();
        filterBooks(selectedCategory);
    });

    function filterBooks(category) {
        $('tbody tr').hide(); // Hide all rows initially
        if (category === 'all') {
            $('tbody tr').show(); // Show all rows if 'All Categories' selected
        } else {
            $('tbody tr').each(function() {
                var bookCategory = $(this).find('td:eq(1)').text(); // Index 1 corresponds to the Category column
                if (bookCategory === category) {
                    $(this).show(); // Show rows matching the selected category
                }
            });
        }
    }
});

</script>
</body>
</html>  