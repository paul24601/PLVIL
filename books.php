<?php
include $_SERVER['DOCUMENT_ROOT'] . '/PLVIL/Admin/classes/book.php';
$db = new DBConnection();

// Get all books list (modify if needed)
$bookObj = new book();
$books = $bookObj->getAllBooks();

// Flag to track if any matches are found (optional, based on your implementation)
$matchesFound = false; // Change this if you have a search functionality

// Loop through and display books in HTML format (modify as needed)
echo "  <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Category</th>
              <th>Book Stem</th>
              <th>Front Cover</th>
              <th>Title</th>
              <th>Author</th>
              <th class='d-none d-lg-table-cell'>Column Number</th>
              <th cl  ass='d-none d-lg-table-cell'>Accession</th>
              <th class='d-none d-lg-table-cell'>Edition</th>
              <th class='d-none d-lg-table-cell'>Year</th>
              <th class='d-none d-lg-table-cell'>Property</th>
              <th class='d-none d-lg-table-cell'>ISBN/ISSN</th>
            </tr>
          </thead>
          <tbody>";
          $no = 0;
foreach ($books as $book) {
  $no++;
  $matchesFound = true; // Assuming at least one book found (optional)

  echo "<tr>
          <td>$no</td>
          <td>{$book['bookCategory']}</td>
          <td><img src='/PLVIL/Admin/uploads/{$book['image1']}' alt='Book Stem' style='width: 100px; height: 100px; border-radius: 0%'></td>
          <td><img src='/PLVIL/Admin/uploads/{$book['image2']}' alt='Front Cover' style='width: 100px; height: 100px; border-radius: 0%'></td>
          <td>{$book['Title']}</td>
          <td>{$book['Author']}</td>
          <td class='d-none d-lg-table-cell'>{$book['columnNumber']}</td>
          <td class='d-none d-lg-table-cell'>{$book['Accession']}</td>
          <td class='d-none d-lg-table-cell'>{$book['bookEdition']}</td>
          <td class='d-none d-lg-table-cell'>{$book['bookYear']}</td>
          <td class='d-none d-lg-table-cell'>{$book['Property']}</td>
          <td class='d-none d-lg-table-cell'>{$book['isbn']}</td>
        </tr>";
}

echo "</tbody>
      </table>";
?>