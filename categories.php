<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/utility/DBConnection.php';

class BookCategory {
    public $conn;

    public function __construct() {
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    public function getCategories() {
        $sql = "SELECT DISTINCT bookCategory FROM book";
        $result = $this->conn->query($sql);
        $categories = array();
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['bookCategory'];
        }
        return $categories;
    }

    public function getBooksByCategory($category) {
        $sql = "SELECT * FROM book WHERE bookCategory = ? ORDER BY bookId DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $category);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = array();
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }
}

$bookCategory = new BookCategory();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['category'])) {
        $books = $bookCategory->getBooksByCategory($_GET['category']);
        echo json_encode($books);
    } else {
        $categories = $bookCategory->getCategories();
        echo json_encode($categories);
    }
}
?>