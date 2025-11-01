<?php

// Handler for storing uploaded images
// This file just handles writing and deleting images

header("Content-Type: application/json; charset=utf-8");

if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
    http_response_code(400);
    echo json_encode([
        "error" => "No images uploaded",
        "debug_files" => $_FILES,
        "debug_post" => $_POST
    ]);    
    exit;
}

// Catching data
$prodId = $_POST["prodId"];
$imageDirPath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/images";

// Deleting old images
$deletedImages = [];
$imagesToDelete = $_POST["toDelete"];

foreach ($imagesToDelete as $imageName) {
    $filePath = $imageDirPath . "/" . $imageName;
    if (file_exists($filePath) && unlink($filePath)) {
        $deletedImages[] = $imageName;
    }
}

$uploadedImageNames = [];
foreach ($_FILES["images"]["name"] as $index => $name) {
    
    // Validation
    // ...

    // Generating a unique filename for the new image
    $fname = uniqid("prod_{$prodId}_", true) . '.jpg';
    $fpath = $imageDirPath . "/" . $fname;

    // Stores file
    $tmpName = $_FILES["images"]["tmp_name"][$index];
    if (move_uploaded_file($tmpName, $fpath)) {
        $uploadedImageNames[] = $fname;
    }
}

// Updates Product in XML
$xmlFpath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($xmlFpath);

foreach ($xml->children() as $category) {
    foreach ($category->children() as $prod) {
        if ((string)$prod["id"] == $prodId) {

            // Get current images before deleting the node
            $oldImagesToKeep = [];
            if (isset($prod->images)) {
                foreach ($prod->images->img as $oldImg) {
                    $imgName = (string)$oldImg;

                    // Image is not set to be deleted
                    if (!in_array($imgName, $imagesToDelete)) {
                        $oldImagesToKeep[] = $imgName;
                    }
                }
            }

            // Deletes entire <images> tag
            if (isset($prod->images)) {
                unset($prod->images);
            }

            // Proceeds with adding back old images and new images
            $prodXmlImages = $prod->addChild("images");

            /*
            // Adds old images that are meant to be kept (not deleted)
            foreach ($uploadedImageNames as $imgName) {
                $prodXmlImages->addChild("img", $imgName);
            }
            */

            // Adds new images
            foreach ($uploadedImageNames as $imgName) {
                $prodXmlImages->addChild("img", $imgName);
            }
        }
    }
}

// Writes file
if ($xml->asXML($xmlFpath)) {
    http_response_code(200);
    echo json_encode([
        "message" => "Uploaded " . count($uploadedImageNames) . " images!",
        "product_id" => $prodId
    ]);
    exit;
}

http_response_code(400);
echo json_encode(["error" => "Failed to add product"]);
?>