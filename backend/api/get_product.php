<?php
$prodID = $_GET["prodId"];

// Normally through the search bar
$prodName = "";
if (isset($_GET["prodName"])) {
    $prodName = $_GET["prodName"];
}

// Loads XML Product file
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Gets specific product
foreach ($xml->children() as $category) {
    foreach ($category->children() as $prod) {
        if ($prod["id"] == $prodID || $prod->name == $prodName) {
            $res = $prod;
            $res->addChild("category", $category["name"]);

            header("Content-Type: application/xml; charset=utf-8");
            echo $res->asXML();
            exit;
        }
    }
}

// Not found
// ...
?>