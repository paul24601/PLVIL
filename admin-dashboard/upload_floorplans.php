<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the directory where you want to save the images
$targetDir = "../assets/floor-plan/";

// Define the filenames for each image
$fileNames = [
    'ground-floor' => 'ground_floor.png',
    'second-floor' => 'second_floor.png'
];

// Flag to check if all uploads are successful
$allUploaded = true;
$uploadResults = "";

foreach ($fileNames as $inputName => $fileName) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
        $targetFilePath = $targetDir . $fileName;

        // Check if the file is an image
        $check = getimagesize($_FILES[$inputName]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory, overwriting the existing file
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                $uploadResults .= "The file ". htmlspecialchars(basename($_FILES[$inputName]["name"])) ." has been uploaded and renamed to $fileName.<br>";
            } else {
                $uploadResults .= "Sorry, there was an error uploading the file $inputName.<br>";
                $allUploaded = false;
            }
        } else {
            $uploadResults .= "$inputName is not a valid image file.<br>";
            $allUploaded = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Loading screen styling */
        #loadingScreen {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>
</head>
<body onload="showModal()">

    <!-- Loading Screen -->
    <div id="loadingScreen" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="uploadResultModal" tabindex="-1" aria-labelledby="uploadResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadResultModalLabel">Upload Result</h5>
                </div>
                <div class="modal-body">
                    <?= $uploadResults ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal() {
            // Show the modal with results
            var myModal = new bootstrap.Modal(document.getElementById('uploadResultModal'), {});
            myModal.show();

            // After 5 seconds, hide the modal, show loading screen, and redirect
            setTimeout(function() {
                document.getElementById('loadingScreen').style.display = 'flex'; // Show loading screen
                myModal.hide();

                // Redirect to chair-admin.html after a short delay
                setTimeout(function() {
                    window.location.href = 'chair-admin.php';
                    sessionStorage.removeItem('pageReloaded');

                }, 1000);
            }, 1500);
        }
    </script>

</body>
</html>
