<?php

// Handler function for insertion in XML
header("Content-Type: application/json; charset=utf-8");

// Catching JSON payload
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Validate again
$err = validateJsonPayload($data);
if ($err) {
    http_response_code(400);
    echo json_encode(["error" => $err]);
    exit;
}

// Inserts data
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Finds associated category
$categoryFound = false;

foreach ($xml->children() as $category) {
    if ((string)$category["name"] == $data["category"]) {
        $categoryFound = $category;
        break; // Stops early, taking less time to add a product
    }
}

if (!$categoryFound) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(["error" => "Category not found"]); // This normally shouldn"t happen
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

function validateJsonPayload($data) {

    // Checks for fields that are required first
    $required = ["category", "name", "desc", "price", "details"];
    foreach ($required as $i) {
        if (!isset($data[$i]) || $data[$i] === "") {
            return "Missing field " . $i;
        }
    }

    // Basically same validation as frontend
    // Is it lazy? Probably...

    // Validates name
    if (strlen(trim($data["name"])) < 10) {
        return "Name must be at least 10 characters long!";
    }

    // Validates desc
    if (strlen(trim($data["desc"])) < 50) {
        return "Description must be at least 50 characters long!";
    }

    // Validates price
    $price = preg_replace("/[^\d.]/", "", trim($data["price"]));
    if (!is_numeric($price) || floatval($price) <= 0) {
        return "Please enter a valid price!";
    }

    // Validates details (Details is an array of Objects)
    foreach ($data["details"] as $detailObj) {
        if (strlen(trim($detailObj["name"])) < 3) {
            return "Please enter a valid detail name for Detail #${i + 1}";
        }

        if (strlen(trim($detailObj["value"])) < 3) {
            return "Please enter a valid detail value for Detail #${i + 1}";
        }
    }

    return ""; // All good 👍
}
?>