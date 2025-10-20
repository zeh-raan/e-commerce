<?php
$imgName = basename($_GET["imgName"]);
$imgPath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/images/" . $imgName;

if (!file_exists($imgPath)) {
    http_response_code(404);
    echo "Image not Found!";
    return;
}

// Sets content type (Allow only jpg images for now)
header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($imgPath));
readfile($imgPath);
?>