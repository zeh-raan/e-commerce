<?php

// Handler function to edit/modify product in XML
header("Content-Type: application/json; charset=utf-8");

// Catches JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Validate JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON payload"]);
    exit;
}

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
$currentCategory = null;

foreach ($xml->children() as $category) {
    foreach ($category->children() as $p) {
        if ((string)$p["id"] === $prodId) {
            $prodFound = $p;
            $currentCategory = $category;
            $categoryFound = true;
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
if (isset($data["category"]) && (string)$currentCategory["name"] !== $data["category"]) {
    // Find new category
    $newCategory = null;
    foreach ($xml->children() as $category) {
        if ((string)$category["name"] === $data["category"]) {
            $newCategory = $category;
            break;
        }
    }
    
    if ($newCategory) {
        // Remove from old category using DOM
        $dom = dom_import_simplexml($prodFound);
        $dom->parentNode->removeChild($dom);
        
        // Add to new category
        $newProduct = $newCategory->addChild('product');
        $newProduct->addAttribute('id', $prodId);
        $newProduct->addChild('name', (string)$prodFound->name);
        $newProduct->addChild('desc', (string)$prodFound->desc);
        $newProduct->addChild('price', (string)$prodFound->price);
        
        // Copy details if they exist
        if ($prodFound->details) {
            $newDetails = $newProduct->addChild('details');
            foreach ($prodFound->details->dt as $detail) {
                $newDetail = $newDetails->addChild('dt', (string)$detail);
                $newDetail->addAttribute('name', (string)$detail['name']);
            }
        }
        
        // Copy images if they exist
        if ($prodFound->images) {
            $newImages = $newProduct->addChild('images');
            foreach ($prodFound->images->img as $image) {
                $newImages->addChild('img', (string)$image);
            }
        }
        
        $prodFound = $newProduct;
    } else {
        http_response_code(400);
        echo json_encode(["error" => "New category not found"]);
        exit;
    }
}

// Handles details changes - unset and repopulate
if (isset($data["details"]) && is_array($data["details"])) {
    // Remove existing details
    if (isset($prodFound->details)) {
        unset($prodFound->details);
    }
    
    // Add new details if there are any
    if (!empty($data["details"])) {
        $details = $prodFound->addChild('details');
        foreach ($data["details"] as $detailObj) {
            if (isset($detailObj['name']) && isset($detailObj['value'])) {
                $dt = $details->addChild('dt', htmlspecialchars(trim($detailObj['value'])));
                $dt->addAttribute('name', htmlspecialchars(trim($detailObj['name'])));
            }
        }
    }
}

// Save XML
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode(["message" => "Product updated successfully"]);
    exit;
}

http_response_code(500);
echo json_encode(["error" => "Failed to update product"]);
?>