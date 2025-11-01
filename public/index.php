<?php
// Router setup

// TODO: Block access to manually using /backend/...
// TODO: Block access to manually using /frontend/pages/...
// TODO: Clean up this file

$frontendRoutes = [
    "" => "index.php",
    "product/add" => "add_product_form.php",
    "cart" => "cart.php",
    "catalog" => "catalog.php",
    "checkout" => "checkout.php",
];

$DIR = substr(__DIR__, 0, strpos(__DIR__, "public"));

// Tries to route to backend, else return a JSON containing error message
function routeToBackend(string $path) {
    // ...
}

// Tries to route to frontend, else redirects to an error page
function routeToFrontend(string $path) {
    // ...
}

function routePath(string $path) {
    global $DIR;
    global $frontendRoutes;

    // Set up API routes (i.e. api/product/1234)
    if (strpos($path, "api/") === 0) {
        $apiBackendFilepath = $DIR . "/backend/api/" . substr($path, 4);
        if (!(file_exists($apiBackendFilepath) && is_file($apiBackendFilepath))) {
            http_response_code(404);
            header("Content-Type: application/json");
            echo json_encode([ "error" => "API Endpoint does not exist!" ]);
            return;
        }

        // Serves file
        include $apiBackendFilepath;
        return;
    }

    // Serve static files
    if (strpos($path, "frontend/") === 0) {
        $staticFile = __DIR__ . "/../" . $path;
        
        if (file_exists($staticFile) && is_file($staticFile)) {
            $extension = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
            
            // Set appropriate Content-Type headers
            $contentTypes = [
                "css" => "text/css",
                "js" => "application/javascript",
                "png" => "image/png",
                "jpg" => "image/jpeg",
                "jpeg" => "image/jpeg",
                "avif" => "image/avif",
                "svg" => "image/svg+xml",
            ];
            
            if (isset($contentTypes[$extension])) {
                header("Content-Type: " . $contentTypes[$extension]);
            }
            
            readfile($staticFile);
            return;
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Static file not found: " . $path]);
            return;
        }
    }

    // Set up Frontend routes
    // Handles routes with URL params/ids first (i.e. /product/123)

    // Path to edit product (i.e. /product/123/edit)
    if (preg_match("#^product/(prod_[a-f0-9]+)/edit$#", $path, $matches)) {
        $prodID = $matches[1];
        $frontendFilepath = $DIR . "/frontend/pages/edit_product_form.php";

        if (!(file_exists($frontendFilepath) && is_file($frontendFilepath))) {
            http_response_code(404);
            header("Content-Type: application/json");
            echo json_encode([ "error" => "Edit Product Page does not exist!" ]);
            return;
        }

        $GLOBALS["prodId"] = $prodID;
        include($frontendFilepath);
        return;
    }

    // Path to view product
    if (preg_match("#^product/(prod_[a-f0-9]+)$#", $path, $matches)) {
        $prodID = $matches[1];
        $frontendFilepath = $DIR . "/frontend/pages/view_product.php";

        if (!(file_exists($frontendFilepath) && is_file($frontendFilepath))) {
            http_response_code(404);
            header("Content-Type: application/json");
            echo json_encode([ "error" => "Product Page does not exist!" ]);
            return;
        }

        $GLOBALS["prodId"] = $prodID;
        include($frontendFilepath);
        return;
    }

    // Other frontend files
    if (!isset($frontendRoutes[$path])) {
        http_response_code(404);
        header("Content-Type: application/json");
        echo json_encode([ "error" => $path ]);
        return;
    }

    $frontendFilepath = $DIR . "/frontend/pages/" . $frontendRoutes[$path];
    if (!(file_exists($frontendFilepath) && is_file($frontendFilepath))) {
        http_response_code(404);
        header("Content-Type: application/json");
        echo json_encode([ "error" => "File does not exist!" ]);
        return;
    }

    // Serves file
    else {
        include($frontendFilepath);
        return;
    }

    // Code below runs if all else fails
    http_response_code(404);
    $errorFilepath = $DIR . "/frontend/pages/error.php";
    include($errorFilepath);
}

// Main function 👇
$URI = $_SERVER["REQUEST_URI"];
$path = trim(parse_url($URI, PHP_URL_PATH), "/"); // Gets path (without trailing '/')
$query = parse_url($URI, PHP_URL_QUERY);
routePath($path);
?>