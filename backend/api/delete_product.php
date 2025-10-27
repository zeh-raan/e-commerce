<?php

// Handler function to delete product from XML
header("Content-Type: application/json; charset=utf-8");
session_start();

// Lock behind auth (Only admins can delete)
// ...

// Catches JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Validate again
// TODO: Write better validation later

if (!isset($data["product_id"]) || empty(trim($data["product_id"]))) {
    http_response_code(400);
    echo json_encode(["error" => "Missing Product ID"]);
    exit;
}

// Loads products
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Searches for products
$prodId = trim($data["product_id"]);
$prodFound = false;

foreach ($xml->children() as $category) {
    foreach ($category->children() as $p) {
        if ((string)$p["id"] === $prodId) {
            
            // Delete the images as well
            foreach ($p->images->children() as $img) {
                $fpath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/images/" . (string)$img;
                if (file_exists($fpath)) {
                    unlink($fpath);
                }
            }

            // Deleting product
            $dom = dom_import_simplexml($p);
            $dom->parentNode->removeChild($dom);
            
            $prodFound = true;
            break 2;
        }
    }
}

// No products found
if (!$prodFound) {
    http_response_code(404);
    echo json_encode(["error" => "Product not found"]);
    exit;
}

// Rewrites XML
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode([
        "message" => "Product " . $prodId . " deleted!",
        "product_id" => $prodId
    ]);
    exit;
}

http_response_code(400);
echo json_encode(["error" => "Failed to delete product"]);
?>