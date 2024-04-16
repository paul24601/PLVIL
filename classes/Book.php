<?php 
    include $_SERVER['DOCUMENT_ROOT'] . '/PLVIL-main/utility/DBConnection.php';

    class Book{
        public $conn;

        public function __construct(){
            $db = new DBConnection();
            $this->conn = $db->conn;
        }

        public function saveBook($post){
            $bookCategory = $post['bookCategory'];
            $Title = $post['Title'];
            $Author = $post['Author'];
            $columnNumber = $post['columnNumber'];
            $Accession = $post['Accession'];
            $bookEdition = $post['bookEdition'];
            $bookYear = $post['bookYear'];
            $Property = $post['Property'];
            $isbn = $post['isbn'];

            $sql = "INSERT INTO book (bookCategory, Title, Author, columnNumber, Accession, bookEdition, bookYear, Property, ISBN) VALUES ('$bookCategory', '$Title', '$Author', '$columnNumber', '$Accession', '$bookEdition', '$bookYear', '$Property', '$isbn')";
            $result = $this->conn->query($sql);

            if($result){
                return json_encode(array('type' => 'success', 'message' => 'Book detail saved Successfully.'));
            }else{
                return json_encode(array('type' => 'fail', 'message' => 'Unable to save book details.'));
            }
        }

        public function getAllBooks(){
            $sql = "SELECT * FROM book";
            $result = $this->conn->query($sql);
            $book = array();
            if($result->num_rows > 0){
                while($rows = $result->fetch_assoc()){
                    $book[] = $rows;
                }
                return $book;
            }
        }

        public function editBook($editId){
            $sql = "SELECT * FROM book WHERE bookId = $editId";
            $result = $this->conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data['bookId'] = $row['bookId'];
                    $data['Title'] = $row['Title'];
                    $data['Author'] = $row['Author'];
                    $data['columnNumber'] = $row['columnNumber'];
                    $data['Accession'] = $row['Accession'];
                    $data['bookEdition'] = $row['bookEdition'];
                    $data['bookYear'] = $row['bookYear'];
                    $data['Property'] = $row['Property'];
                    $data['isbn'] = $row['isbn'];
                }
                return json_encode($data);
            }
        }

        public function updateBook($post){
            $bookId = $post['bookId'];
            $Title = $post['Title'];
            $Author = $post['Author'];
            $columnNumber = $post['columnNumber'];
            $Accession = $post['Accession'];
            $bookEdition = $post['bookEdition'];
            $bookYear = $post['bookYear'];
            $Property = $post['Property'];
            $isbn = $post['isbn'];

            $sql = "UPDATE book SET Title = '$Title', Author = '$Author', columnNumber = '$columnNumber', Accession = '$Accession', bookEdition = '$bookEdition', bookYear = '$bookYear', Property = '$Property', isbn = '$isbn' WHERE bookId = $bookId";
            $result = $this->conn->query($sql);

            if($result){
                return json_encode(array('type' => 'success', 'message' => 'Book details Updated'));
            }else{
                return json_encode(array('type' => 'fail', 'message' => 'Unable update book details '));
            }
        }

        public function deleteBook($deleteId){
            $sql = "DELETE FROM book WHERE bookId = $deleteId";
            $execute = $this->conn->query($sql);

            if($execute){
                return json_encode(array('type' => 'success', 'message' => 'Book details deleted'));
            }else{
                return json_encode(array('type' => 'fail', 'message' => 'Unable delete book details '));
            }
        }
        
    }


    $book = new Book();

    if(isset($_POST['Title'])){
        $saveBook = $book->saveBook($_POST);
        echo $saveBook;
    }

    if(isset($_POST['editId'])){
        $editBook = $book->editBook($_POST['editId']);
        echo $editBook;
    }

    if(isset($_POST['updateBtn'])){
        $updateBook = $book->updateBook($_POST);
        echo $updateBook;
    }

    if(isset($_POST['deleteId'])){
        $deleteBook = $book->deleteBook($_POST['deleteId']);
        echo $deleteBook;
    }
?> 
