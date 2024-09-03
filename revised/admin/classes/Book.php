<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/utility/DBConnection.php';

class Book {
    public $conn;

    public function __construct() {
        $db = new DBConnection();
        $this->conn = $db->conn;
    }

    // Method to save a book (add or update)
public function saveBook($post) {
    // Check if bookId is provided for an update operation
    $bookId = isset($post['bookId']) ? $post['bookId'] : '';

    // Extract book details from POST data
    $bookCategory = $post['bookCategory'];
    $Title = $post['Title'];
    $Author = $post['Author'];
    $columnNumber = $post['columnNumber'];
    $Accession = $post['Accession'];
    $bookEdition = $post['bookEdition'];
    $bookYear = $post['bookYear'];
    $Property = $post['Property'];
    $CallNumber = $post['CallNumber'];
    $isbn = $post['isbn'];

    // Determine if updating an existing record or adding a new one
    if (!empty($bookId)) {
        // Existing book, check if new images are provided
        $image1Name = '';
        $image2Name = '';
        if (isset($_FILES['image1']) && $_FILES['image1']['size'] > 0 && isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
            // Handle file uploads for images
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/uploads/';
            $image1Name = basename($_FILES["image1"]["name"]);
            $image2Name = basename($_FILES["image2"]["name"]);
            $image1Path = $targetDir . $image1Name;
            $image2Path = $targetDir . $image2Name;

            // Move uploaded files to the upload directory
            if (move_uploaded_file($_FILES["image1"]["tmp_name"], $image1Path) &&
                move_uploaded_file($_FILES["image2"]["tmp_name"], $image2Path)) {
                // Files uploaded successfully, continue with database update
            } else {
                return json_encode(array('type' => 'fail', 'message' => 'Failed to upload images.'));
            }
        }

        // Update existing book record, including image paths if provided
        $sql = "UPDATE book SET bookCategory='$bookCategory', Title='$Title', Author='$Author', columnNumber='$columnNumber', Accession='$Accession', bookEdition='$bookEdition', bookYear='$bookYear', Property='$Property', CallNumber='$CallNumber', ISBN='$isbn'";
        if (!empty($image1Name) && !empty($image2Name)) {
            $sql .= ", image1='$image1Name', image2='$image2Name'";
        }
        $sql .= " WHERE bookId=$bookId";
        $result = $this->conn->query($sql);

        // Determine if the update was successful
        if ($result) {
            return json_encode(array('type' => 'success', 'message' => 'Book successfully updated.'));
        } else {
            return json_encode(array('type' => 'fail', 'message' => 'Unable to update book details.'));
        }
    } else {
        // Insert new book record
        // Handle file uploads for images if they exist
        $image1Name = '';
        $image2Name = '';
        if (isset($_FILES['image1']) && $_FILES['image1']['size'] > 0 && isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/uploads/';
            $image1Name = basename($_FILES["image1"]["name"]);
            $image2Name = basename($_FILES["image2"]["name"]);
            $image1Path = $targetDir . $image1Name;
            $image2Path = $targetDir . $image2Name;

            // Move uploaded files to the upload directory
            if (move_uploaded_file($_FILES["image1"]["tmp_name"], $image1Path) &&
                move_uploaded_file($_FILES["image2"]["tmp_name"], $image2Path)) {
                // Files uploaded successfully, continue with database insertion
            } else {
                return json_encode(array('type' => 'fail', 'message' => 'Failed to upload images.'));
            }
        }

        // Insert new book record
        $sql = "INSERT INTO book (bookCategory, Title, Author, columnNumber, Accession, bookEdition, bookYear, Property, CallNumber, ISBN, image1, image2) VALUES ('$bookCategory', '$Title', '$Author', '$columnNumber', '$Accession', '$bookEdition', '$bookYear', '$Property', '$CallNumber', '$isbn', '$image1Name', '$image2Name')";
        $result = $this->conn->query($sql);

        // Determine if the insertion was successful
        if ($result) {
            return json_encode(array('type' => 'success', 'message' => 'Book successfully added.'));
        } else {
            return json_encode(array('type' => 'fail', 'message' => 'Unable to add book details.'));
        }
    }
}

            // Method to retrieve all books
        public function getAllBooks() {
            $sql = "SELECT * FROM book ORDER BY Title"; // Order by Title alphabetically
            $result = $this->conn->query($sql);
            $books = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $books[] = $row;
                }
            }
            return $books;
        }

    // Method to delete a book
public function deleteBook($deleteId) {
    // Get the book details before deleting
    $bookDetails = $this->getBookById($deleteId);
    if ($bookDetails) {
        $image1Path = $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/uploads/' . $bookDetails['image1'];
        $image2Path = $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/uploads/' . $bookDetails['image2'];
        
        // Delete the image files from the server
        if (file_exists($image1Path)) {
            unlink($image1Path);
        }
        if (file_exists($image2Path)) {
            unlink($image2Path);
        }
    }

    $sql = "DELETE FROM book WHERE bookId = $deleteId";
    $result = $this->conn->query($sql);

    if ($result) {
        return json_encode(array('type' => 'success', 'message' => 'Book deleted successfully.'));
    } else {
        return json_encode(array('type' => 'fail', 'message' => 'Unable to delete book.'));
    }
}

    // Method to get book details by ID
    public function getBookById($bookId) {
        $sql = "SELECT * FROM book WHERE bookId = $bookId";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}


$book = new Book();

// Save book details
if (isset($_POST['Title'])) {
    $saveBook = $book->saveBook($_POST);
    echo $saveBook;
}

// Delete book
if (isset($_POST['deleteId'])) {
    $deleteBook = $book->deleteBook($_POST['deleteId']);
    echo $deleteBook;
}

// Fetch book details by ID
if (isset($_POST['getBookById'])) {
    $bookId = $_POST['getBookById'];
    $bookDetails = $book->getBookById($bookId);
    echo json_encode($bookDetails);
}


?>
