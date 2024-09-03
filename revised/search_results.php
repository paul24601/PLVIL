<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL
$query = $_GET['query'];

// Sanitize the input
$query = $conn->real_escape_string($query);

// Prepare the SQL statement
$sql = "SELECT * FROM book WHERE title LIKE '%$query%' OR author LIKE '%$query%'";

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Search Results</h1>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>bookId</th>
                        <th>bookCategory</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>columnNumber</th>
                        <th>Accession</th>
                        <th>bookEdition</th>
                        <th>bookYear</th>
                        <th>Property</th>
                        <th>CallNumber</th>
                        <th>isbn</th>
                        <th>image1</th>
                        <th>image2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['bookId']); ?></td>
                            <td><?php echo htmlspecialchars($row['bookCategory']); ?></td>
                            <td><?php echo htmlspecialchars($row['Title']); ?></td>
                            <td><?php echo htmlspecialchars($row['Author']); ?></td>
                            <td><?php echo htmlspecialchars($row['columnNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['Accession']); ?></td>
                            <td><?php echo htmlspecialchars($row['bookEdition']); ?></td>
                            <td><?php echo htmlspecialchars($row['bookYear']); ?></td>
                            <td><?php echo htmlspecialchars($row['Property']); ?></td>
                            <td><?php echo htmlspecialchars($row['callNumber']); ?></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td>
                                <?php if (!empty($row['image1'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image1']); ?>" alt="Image 1" style="max-width: 100px; max-height: 100px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['image2'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['image2']); ?>" alt="Image 2" style="max-width: 100px; max-height: 100px;">
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No results found for "<?php echo htmlspecialchars($query); ?>".</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
