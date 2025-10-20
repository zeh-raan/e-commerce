<?php
$filepath = substr(__DIR__, 0, strpos(__DIR__, "api")) . "data/products.xml";
$xml = simplexml_load_file($filepath);

header("Content-Type: application/xml; charset=utf-8");
echo $xml->asXML();
?>