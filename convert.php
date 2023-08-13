<?php
if (isset($_POST['submit'])) {
    $allowedFormats = ['image/jpeg', 'image/png', 'image/jpg'];
    $imageFile = $_FILES['image'];

    if (in_array($imageFile['type'], $allowedFormats)) {
        $sourceImagePath = $imageFile['tmp_name'];

        $image = imagecreatefromstring(file_get_contents($sourceImagePath));
        $destinationImagePath = 'converted_image.webp';

        imagewebp($image, $destinationImagePath);

        imagedestroy($image);

        // Send the converted image to the browser for download
        header('Content-Type: image/webp');
        header('Content-Disposition: attachment; filename="converted_image.webp"');
        readfile($destinationImagePath);

        // Clean up temporary files
        unlink($destinationImagePath);
        exit();
    } else {
        echo 'Invalid image format. Only JPEG, JPG, and PNG images are allowed.';
    }
}
?>
