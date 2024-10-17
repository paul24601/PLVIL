<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Status</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<?php
$targetDir = "assets/argraphics/book1info/";
$fileNames = [
    'book1-title' => 'b1title.png',
    'book1-auth' => 'b1auth.png',
    'book1-gen' => 'b1gen.png',
    'book1-syn' => 'b1syn.png',
    'book1-lang' => 'b1lang.png'
];
$allUploaded = true;
$messages = "";

foreach ($fileNames as $inputName => $fileName) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
        $targetFilePath = $targetDir . $fileName;
        $check = getimagesize($_FILES[$inputName]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                $messages .= "The file ". htmlspecialchars(basename($_FILES[$inputName]["name"])) ." has been uploaded and renamed to $fileName.<br>";
            } else {
                $messages .= "Sorry, there was an error uploading the file $inputName.<br>";
                $allUploaded = false;
            }
        } else {
            $messages .= "$inputName is not a valid image file.<br>";
            $allUploaded = false;
        }
    }
}
?>

<!-- Modal Structure -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Status</h5>
            </div>
            <div class="modal-body">
                <?php echo $messages; ?>
            </div>
            <div class="modal-footer">
                <!-- Buttons to redirect to index or admin -->
                <a href="../index.html" class="btn btn-secondary">Go to Home</a>
                <a href="../admin-dashboard/ar-admin.php" class="btn btn-primary">Go to Admin</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    // Show the modal on page load
    $(document).ready(function(){
        $('#uploadModal').modal('show');
        
        // Automatic redirection after 5 seconds
        setTimeout(function(){
            window.location.href = "../admin-dashboard/ar-admin.php";
        }, 5000);
    });
</script>

</body>
</html>
