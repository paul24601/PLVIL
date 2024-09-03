<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/utility/DBConnection.php';

class Book {
    public $conn;

    public function __construct() {
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    public function getBooksByCategory($category) {
        $sql = "SELECT * FROM book WHERE bookCategory = ?";
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

$book = new Book();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $category = $input['category'];
    $books = $book->getBooksByCategory($category);
    echo json_encode($books);
}

?>
