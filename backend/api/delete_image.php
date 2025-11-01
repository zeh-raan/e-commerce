<?php

// Handler function to delete images associated to a given Product ID and
// Image name
header("Content-Type: application/json; charset=utf-8");

// Catching inputs from JSON payload
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$prodId = trim($data["prodId"]);
$imagesToDelete = $data["imagesToDelete"]; // Array of image names
$imageDirPath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/images";

// Delete images
foreach ($imagesToDelete as $img) {
    $filePath = $imageDirPath . "/" . $img;
    
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete respective tags from XML
$xmlFpath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($xmlFpath);
$productUpdated = false;

foreach ($xml->children() as $category) {
    foreach ($category->children() as $prod) {
        if ((string)$prod["id"] == $prodId) {
            $productUpdated = true;
            
            if (isset($prod->images)) {
                foreach ($prod->images->img as $index => $img) {
                    $imgName = (string)$img;

                    // Image set to delete
                    if (in_array($imgName, $imagesToDelete)) {
                        $dom = dom_import_simplexml($img);
                        $dom->parentNode->removeChild($dom);
                    }
                }
            }

            break 2;
        }
    }
}

// Writes XML file
if ($xml->asXML($xmlFpath)) {
    http_response_code(200);
    echo json_encode(["message" => "Images deleted successfully"]);
    exit;
}

http_response_code(500);
echo json_encode(["error" => "Failed to update product XML"]);
?>