<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/utility/DBConnection.php');
include $_SERVER['DOCUMENT_ROOT'].'/PLVIL/Admin/classes/Book.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $bookId = $data['bookId'];

    if ($bookId) {
        $book = new Book();
        $bookDetails = $book->getBookById($bookId);

        if ($bookDetails) {
            echo json_encode($bookDetails);
        } else {
            echo json_encode(['error' => 'Book not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid book ID']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
