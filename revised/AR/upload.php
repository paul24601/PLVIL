<?php
// Define the directory where you want to save the images
$targetDir = "assets/argraphics/book1info/";

// Define the filenames for each image
$fileNames = [
    'book1-title' => 'b1title.png',
    'book1-auth' => 'b1auth.png',
    'book1-gen' => 'b1gen.png',
    'book1-syn' => 'b1syn.png',
    'book1-lang' => 'b1lang.png'
];

// Flag to check if all uploads are successful
$allUploaded = true;

foreach ($fileNames as $inputName => $fileName) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
        $targetFilePath = $targetDir . $fileName;

        // Check if the file is an image
        $check = getimagesize($_FILES[$inputName]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                echo "The file ". htmlspecialchars(basename($_FILES[$inputName]["name"])) ." has been uploaded and renamed to $fileName.<br>";
            } else {
                echo "Sorry, there was an error uploading the file $inputName.<br>";
                $allUploaded = false;
            }
        } else {
            echo "$inputName is not a valid image file.<br>";
            $allUploaded = false;
        }
    }
}
?>

<!-- Add a button that redirects to the AR Scan page -->
<?php if ($allUploaded): ?>
    <div style="margin-top: 20px;">
        <form action="../index.html" method="GET">
            <button type="submit" class="btn btn-primary">Go to Home</button>
        </form>
    </div>
<?php endif; ?>
