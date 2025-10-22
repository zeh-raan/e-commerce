<?php
$prodID = $_GET["prodId"];

// Loads XML Product file
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

// Gets specific product
foreach ($xml->children() as $category) {
    foreach ($category->children() as $prod) {
        if ($prod["id"] == $prodID) {
            header("Content-Type: application/xml; charset=utf-8");
            echo $prod->asXML();
            exit;
        }
    }
}

// Not found
// ...
?>