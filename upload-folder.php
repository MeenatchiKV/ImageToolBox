<?php
/* Create Upload Directory */
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* Process Multiple Files */
foreach ($_FILES['file']['name'] as $key => $filename) {
    $location = $uploadDir . basename($filename);
    $uploadOk = 1;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);

    /* Valid Extensions */
    $valid_extensions = array("jpg", "jpeg", "png", "pdf", "heic", "svg");

    /* Check File Extension */
    if (!in_array(strtolower($imageFileType), $valid_extensions)) {
        $uploadOk = 0;
    }

    /* Upload File */
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $location)) {
            echo "Uploaded: " . $location . "<br>";
        } else {
            echo "Failed to upload: " . $filename . "<br>";
        }
    } else {
        echo "Invalid file format: " . $filename . "<br>";
    }
}
?>
