<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/PLVIL-main/classes/book.php';
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
                <input type="text" class="form-control" id="searchInput" placeholder="Search by Title...">
            </div>
    </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="10%">Category</th>
                    <th width="20%">Book Stem</th>
                    <th width="20%">Front Cover</th>
                    <th width="10%">Title</th>
                    <th width="10%">Author</th>
                    <th width="10%">Column Number</th>
                    <th width="10%">Accession</th>
                    <th width="10%">Edition</th>
                    <th width="10%">Year</th>
                    <th width="10%">Property</th>
                    <th width="10%">ISBN</th>
                    <th width="50%">Manage Book</th>
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
                        <td><?php echo $book['image1']; ?></td>
                        <td><?php echo $book['image2']; ?></td>
                        <td><?php echo $book['Title']; ?></td>
                        <td><?php echo $book['Author']; ?></td>
                        <td><?php echo $book['columnNumber']; ?></td>
                        <td><?php echo $book['Accession']; ?></td>
                        <td><?php echo $book['bookEdition']; ?></td>
                        <td><?php echo $book['bookYear']; ?></td>
                        <td><?php echo $book['Property']; ?></td>
                        <td><?php echo $book['isbn']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm editButton" id="<?php echo $book['bookId']?>"><i class="fa-regular fa-pen-to-square"></i>Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" id="<?php echo $book['bookId']?>"><i class="fa-regular fa-trash-can"></i>Delete</button>
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
                <label class="input-group-text" for="inputGroupSelect01">Book Category</label>
                    <select class="form-select" id="bookCategory" name= "bookCategory">
                        <option selected>Choose Category...</option>
                        <option value="Literature">Literature</option>
                        <option value="Fantasy">Education</option>
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
                <span class="input-group-text">Title</span>
                <input type="text"name="Title" class="form-control" required placeholder="Enter Book Title">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Author</span>
                <input type="text"name="Author" class="form-control" required placeholder="Enter Book Author">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">column Number</span>
                <input type="text"name="columnNumber" class="form-control" required placeholder="Enter Column Number">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Accession</span>
                <input type="text"name="Accession" class="form-control" required placeholder="Enter Book Accession">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Edition</span>
                <input type="text"name="bookEdition" class="form-control" required placeholder="Enter Edition">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Year</span>
                <input type="text"name="bookYear" class="form-control" required placeholder="Enter Year">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Property</span>
                <input type="text"name="Property" class="form-control" required placeholder="Enter Property">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">ISBN/ISN</span>
                <input type="text"name="isbn" class="form-control" required placeholder="Enter ISBN">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Image Front Cover</label>
                <input type="file" class="form-control" id="inputGroupFile01" name="image1" accept= "jpg, png, svg" required>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile02">Image Book Stem</label>
                <input type="file" class="form-control" id="inputGroupFile02" name="image2" accept= "jpg, png, svg" required>
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

<script type="text/javascript">
    $(document).ready(function(){ 
        $('#addBookBtn').on('click', function(){
            $.post('classes/Book.php', $('form#addBookForm').serialize(), function(data){
                var data = JSON.parse(data);
                
                if(data.type == 'success'){
                    $('#addBook').modal('hide');
                    $('#alert').modal('show');
                    $('#alert .alert').addClass('alert-success').append(data.message).delay(1500).fadeOut('slow', function(){
                        location.reload();
                    });
                }
            });
        });

        $(document).ready(function() {
    // Add event listener to search input field
    $('#searchInput').on('input', function() {
        var searchText = $(this).val().toLowerCase();
        var rows = $('tbody tr');
        var matchedRows = [];

        // Filter rows based on search input
        rows.each(function(index, row) {
            var title = $(row).find('td:eq(4)').text().toLowerCase(); // Index 4 corresponds to the Title column
            if (title.includes(searchText)) {
                matchedRows.push(row);
            }
            // Move matched rows to the top of the table
        matchedRows.forEach(function(row) {
            $(row).detach().prependTo('tbody');
        });

        // Reset table order to original if search input is empty
        if (searchText === '') {
            $('tbody tr').appendTo('tbody');
        }
    });
});

    //edit books  
    $('.editButton').on('click', function(e) {
                $('#editBook').modal('show'); 
                $.post('classes/Book.php', {editId: e.target.id}, function(data) {
                    var data = JSON.parse(data);
                    $('#editTitle').val(data.Title);
                    $('#Author').val(data.Author);
                    $('#columnNumber').val(data.columnNumber);
                    $('#Accession').val(data.Accession);
                    $('#bookEdition').val(data.bookEdition);
                    $('#bookYear').val(data.bookYear);
                    $('#Property').val(data.Property);
                    $('#isbn').val(data.isbn);
                    $('#bookId').val(data.bookId);
                });
            });
            
            // Updating Books
            $('#updateBook').on('click', function() {
                $.post('classes/Book.php', $('form#editBookForm').serialize(), function(data) {
                    var data = JSON.parse(data);
                    if (data.type == 'success') {
                        $('#editBook').modal('hide');
                        $('#alert').modal('show');
                        $('#alert .alert').addClass('alert-success').append(data.message).delay(1500).fadeOut('slow', function() {
                            $.get('classes/Book.php', function(data) {
                                $('tbody').html(data); 
                            });
                        });
                    } else {
                        $('#editBook').modal('hide');
                        $('#alert').modal('show');
                        $('#alert .alert').addClass('alert-danger').append(data.message).delay(1500).fadeOut('slow', function() {
                            location.reload();
                    });
                }
            });
        });

        //Deleting Books
        $('.deleteButton').on('click', function(e) {
            var confirmDelete = confirm("Are you sure you want to delete this book?");
            if (confirmDelete){
                $.post('classes/Book.php', {deleteId: e.target.id}, function(data) {
                    var data = JSON.parse(data);
                    if(data.type == 'success'){
                        $('#alert').modal('show');
                        $('#alert .alert').addClass('alert-success').append(data.message).delay(1500).fadeOut('slow', function(){
                            location.reload();
                        });
                    } else {
                        $('#alert').modal('show');
                        $('#alert .alert').addClass('alert-danger').append(data.message).delay(1500).fadeOut('slow', function(){
                            location.reload();
                        });
                    }
                });
            }else{
                return false;
            }   
            });
        });

        //FUNCTION FOR SORT

        $(document).ready(function() {
        // Add event listener to category filter dropdown
        $('#categoryFilter').on('change', function() {
            var selectedCategory = $(this).val();
            filterBooks(selectedCategory);
        });
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