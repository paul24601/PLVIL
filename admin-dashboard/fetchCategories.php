<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/classes/Book.php';

$book = new Book();

if (isset($_GET['term'])) {
    $term = $_GET['term'];
    $categories = $book->getCategories($term);
    echo json_encode($categories);
}
?>
