<?php
    // Returning JSON
    header("Content-Type: application/json");  

    $xmlFile = __DIR__ . "/../data/users.xml";
    
    if ( $_SERVER["REQUEST_METHOD"] === "POST" ) {
        $firstName = trim($_POST["firstName"]);
        $lastName  = trim($_POST["lastName"]);
        $email     = trim($_POST["email"]);
        $phone     = trim($_POST["phone"]);
        // Stored password as hashed
        $password  = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    if ( file_exists($xmlFile) ) {
        $xml = simplexml_load_file($xmlFile);

    } else {
        // Start inside root element
        $xml = new SimpleXMLElement("<users></users>");
    }

    // Prevent duplicate email
    foreach ( $xml->user as $user) {
        if ( (string)$user -> email === $email ) {
            echo json_encode( ["success" => false, "message" => "Email already exists." ] );
            exit;
        }
    }

    // Adds new user
    $newUser = $xml->addChild("user");

    $newUser->addChild("firstName", $firstName);
    $newUser->addChild("lastName", $lastName);
    $newUser->addChild("email", $email);
    $newUser->addChild("phone", $phone);
    $newUser->addChild("password", $password);

    // Saves the xml file
    $xml -> asXML($xmlFile);

    echo json_encode(["success" => true, "message" => "Account created successfully!"]);
    exit;
?>