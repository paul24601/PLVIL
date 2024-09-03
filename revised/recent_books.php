<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/revised/admin/utility/DBConnection.php';

class Book {
    public $conn;

    public function __construct() {
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    public function getRecentBooks($limit = 6) {
        $sql = "SELECT * FROM book ORDER BY bookId DESC, bookId DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $limit);
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
    $books = $book->getRecentBooks();
    echo json_encode($books);
}
?>
