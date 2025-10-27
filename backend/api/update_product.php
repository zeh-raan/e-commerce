<?php

// Handler function to delete product from XML
header("Content-Type: application/json; charset=utf-8");

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
$categoryFound = false;
$prodFound = false;

foreach ($xml->children() as $category) {
    foreach ($category->children() as $p) {
        if ((string)$p["id"] === $prodId) {
            
            // Found the product to make changes to
            $prodFound = $p;
            $categoryFound = $category;

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

// Updates provided fields
if (isset($data["name"])) {
    $prodFound->name = htmlspecialchars(trim($data["name"]));
}

if (isset($data["desc"])) {
    $prodFound->desc = htmlspecialchars(trim($data["desc"]));
}

if (isset($data["price"])) {
    $prodFound->price = htmlspecialchars(trim($data["price"]));
}

// Handles category changes (Moving product to another category)
// ...

// Handles details changes (Iterative process)
// ...

// Image updates are handled by another endpoint

// Or we can just have gone the lazy way:
// - Delete the product
// - Add it again with the same ID
?>