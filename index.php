<?php
// Router setup

$frontendRoutes = [ "" => "index.html", ];

function routePath(string $path) {
    global $frontendRoutes;

    // Set up API routes (i.e. api/product/1234)
    if (strpos($path, "api/") === 0) {
        $apiBackendFilepath = __DIR__ . "/backend/api/" . substr($path, 4);
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

    // Set up Frontend routes
    if (!isset($frontendRoutes[$path])) {
        http_response_code(404);
        header("Content-Type: application/json");
        echo json_encode([ "error" => "Page not found!" ]);
        return;
    }

    $frontendFilepath = __DIR__ . "/frontend/" . $frontendRoutes[$path];
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
    header("Content-Type: application/json");
    echo json_encode([ "error" => "Page not found!" ]);
}

$URI = $_SERVER["REQUEST_URI"];
$path = trim(parse_url($URI, PHP_URL_PATH), "/"); // Gets path (without trailing '/')
$query = parse_url($URI, PHP_URL_QUERY);
routePath($path);
?>