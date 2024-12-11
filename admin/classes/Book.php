<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/utility/DBConnection.php';

class Book
{
    public $conn;

    public function __construct()
    {
        $db = new DBConnection();
        $this->conn = $db->conn;
    }

    // Method to save a book (add or update)
    public function saveBook($post)
    {
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

        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/';
        $dateInputted = date('Y-m-d'); // Current date for naming

        if (!empty($bookId)) {
            // Existing book logic
            $image1Name = '';
            $image2Name = '';
            if (isset($_FILES['image1']) && $_FILES['image1']['size'] > 0) {
                $image1Name = $this->generateFileName($Title, 'cover', $dateInputted, $_FILES['image1']['name']);
                $image1Path = $targetDir . $image1Name;
                move_uploaded_file($_FILES["image1"]["tmp_name"], $image1Path);
            }
            if (isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
                $image2Name = $this->generateFileName($Title, 'stem', $dateInputted, $_FILES['image2']['name']);
                $image2Path = $targetDir . $image2Name;
                move_uploaded_file($_FILES["image2"]["tmp_name"], $image2Path);
            }

            $sql = "UPDATE book SET bookCategory='$bookCategory', Title='$Title', Author='$Author', columnNumber='$columnNumber', Accession='$Accession', bookEdition='$bookEdition', bookYear='$bookYear', Property='$Property', CallNumber='$CallNumber', ISBN='$isbn'";
            if (!empty($image1Name))
                $sql .= ", image1='$image1Name'";
            if (!empty($image2Name))
                $sql .= ", image2='$image2Name'";
            $sql .= " WHERE bookId=$bookId";

            $result = $this->conn->query($sql);
            return $result ? json_encode(['type' => 'success', 'message' => 'Book successfully updated.']) : json_encode(['type' => 'fail', 'message' => 'Unable to update book details.']);
        } else {
            // New book logic
            $image1Name = '';
            $image2Name = '';
            if (isset($_FILES['image1']) && $_FILES['image1']['size'] > 0) {
                $image1Name = $this->generateFileName($Title, 'cover', $dateInputted, $_FILES['image1']['name']);
                $image1Path = $targetDir . $image1Name;
                move_uploaded_file($_FILES["image1"]["tmp_name"], $image1Path);
            }
            if (isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
                $image2Name = $this->generateFileName($Title, 'stem', $dateInputted, $_FILES['image2']['name']);
                $image2Path = $targetDir . $image2Name;
                move_uploaded_file($_FILES["image2"]["tmp_name"], $image2Path);
            }

            $sql = "INSERT INTO book (bookCategory, Title, Author, columnNumber, Accession, bookEdition, bookYear, Property, CallNumber, ISBN, image1, image2) VALUES ('$bookCategory', '$Title', '$Author', '$columnNumber', '$Accession', '$bookEdition', '$bookYear', '$Property', '$CallNumber', '$isbn', '$image1Name', '$image2Name')";
            $result = $this->conn->query($sql);
            return $result ? json_encode(['type' => 'success', 'message' => 'Book successfully added.']) : json_encode(['type' => 'fail', 'message' => 'Unable to add book details.']);
        }
    }

    private function generateFileName($title, $type, $date, $originalName)
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $sanitizedTitle = preg_replace('/[^a-zA-Z0-9_-]/', '_', $title); // Sanitize title
        return $sanitizedTitle . '_' . $type . '_' . $date . '.' . $extension;
    }

    // Method to retrieve all books
    public function getAllBooks()
    {
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
    public function deleteBook($deleteId)
    {
        // Get the book details before deleting
        $bookDetails = $this->getBookById($deleteId);
        if ($bookDetails) {
            $image1Path = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/' . $bookDetails['image1'];
            $image2Path = $_SERVER['DOCUMENT_ROOT'] . '/admin/uploads/' . $bookDetails['image2'];

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
    public function getBookById($bookId)
    {
        $sql = "SELECT * FROM book WHERE bookId = $bookId";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function archiveBook($bookId)
    {
        // Fetch book details by ID
        $bookDetails = $this->getBookById($bookId);

        if ($bookDetails) {
            // Insert book details into archived_books
            $sql = "INSERT INTO archived_books (bookId, bookCategory, Title, Author, columnNumber, Accession, bookEdition, bookYear, Property, CallNumber, isbn, image1, image2, archivedAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "isssisiiissss",
                $bookDetails['bookId'],
                $bookDetails['bookCategory'],
                $bookDetails['Title'],
                $bookDetails['Author'],
                $bookDetails['columnNumber'],
                $bookDetails['Accession'],
                $bookDetails['bookEdition'],
                $bookDetails['bookYear'],
                $bookDetails['Property'],
                $bookDetails['CallNumber'],
                $bookDetails['isbn'],
                $bookDetails['image1'],
                $bookDetails['image2']
            );

            if ($stmt->execute()) {
                // Delete book from the main table
                $this->deleteBook($bookId);
                return json_encode(['type' => 'success', 'message' => 'Book successfully archived.']);
            } else {
                return json_encode(['type' => 'fail', 'message' => 'Failed to archive the book.']);
            }
        } else {
            return json_encode(['type' => 'fail', 'message' => 'Book not found.']);
        }
    }

    // Method to retrieve all archived books
    public function getAllArchivedBooks()
    {
        $sql = "SELECT * FROM archived_books ORDER BY archivedAt DESC"; // Fetch all archived books ordered by archived date
        $result = $this->conn->query($sql);
        $books = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        return $books;
    }

    public function restoreBook($archivedBookId)
{
    // Fetch the archived book details
    $sql = "SELECT * FROM archived_books WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $archivedBookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bookDetails = $result->fetch_assoc();

        // Insert book back into the main book table
        $restoreSql = "INSERT INTO book (bookId, bookCategory, Title, Author, columnNumber, Accession, bookEdition, bookYear, Property, CallNumber, ISBN, image1, image2) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $restoreStmt = $this->conn->prepare($restoreSql);
        $restoreStmt->bind_param(
            "isssisiiissss",
            $bookDetails['bookId'],
            $bookDetails['bookCategory'],
            $bookDetails['Title'],
            $bookDetails['Author'],
            $bookDetails['columnNumber'],
            $bookDetails['Accession'],
            $bookDetails['bookEdition'],
            $bookDetails['bookYear'],
            $bookDetails['Property'],
            $bookDetails['CallNumber'],
            $bookDetails['isbn'],
            $bookDetails['image1'],
            $bookDetails['image2']
        );

        if ($restoreStmt->execute()) {
            // Delete the book from archived_books
            $deleteSql = "DELETE FROM archived_books WHERE id = ?";
            $deleteStmt = $this->conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $archivedBookId);
            $deleteStmt->execute();

            return json_encode(['type' => 'success', 'message' => 'Book successfully restored.']);
        } else {
            return json_encode(['type' => 'fail', 'message' => 'Failed to restore the book.']);
        }
    } else {
        return json_encode(['type' => 'fail', 'message' => 'Archived book not found.']);
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

// Archive book
if (isset($_POST['archiveId'])) {
    $archiveBook = $book->archiveBook($_POST['archiveId']);
    echo $archiveBook;
}

// Restore book
if (isset($_POST['restoreId'])) {
    $restoreBook = $book->restoreBook($_POST['restoreId']);
    echo $restoreBook;
}


?>