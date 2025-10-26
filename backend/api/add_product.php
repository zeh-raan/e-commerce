<?php

// Handler function for insertion in XML
header("Content-Type: application/json; charset=utf-8");

// Catching JSON payload
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// TODO: Validate again
// ...

// Inserts data
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Finds associated category
$categoryFound = false;

foreach ($xml->children() as $category) {
    if ((string)$category["name"] == $data["category"]) {
        $categoryFound = $category;
    }
}

if (!$categoryFound) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(["error" => "Category not found"]); // This normally shouldn't happen
    exit;
}

// Creates XML tags
$prod = $categoryFound->addChild("product");

$newProdId = uniqid("prod_");
$prod->addAttribute("id", $newProdId);

$prod->addChild("name", htmlspecialchars($data["name"]));
$prod->addChild("desc", htmlspecialchars($data["desc"]));
$prod->addChild("price", htmlspecialchars($data["price"]));

// Skipping details for now
$details = $prod->addChild("details");
foreach ($data["details"] as $detailObj) {
    $dt = $details->addChild("dt", htmlspecialchars($detailObj["value"]));
    $dt->addAttribute("name", htmlspecialchars($detailObj["name"]));
}

// NOTE: Images are handled through another endpoint

// Saves file
if ($xml->asXML($filepath)) {
    http_response_code(200);
    echo json_encode([
        "message" => "Product " . $newProdId . " added!",
        "product_id" => $newProdId
    ]);
    exit;
}

http_response_code(400);
echo json_encode(["error" => "Failed to add product"]);
?>