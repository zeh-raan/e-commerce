<?php
$prodId = $GLOBALS["prodId"];
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Product Page</title>
    <link rel="stylesheet" href="/frontend/css/output.css">
</head>

<body>
    <?php include("frontend/pages/components/header.php"); ?>

    <section id="product-here"></section>

    <?php include("frontend/pages/components/footer.php"); ?>

    <script>
        const displayProduct = (xml) => {
            const displaySection = document.getElementById("product-here");
            displaySection.innerHTML = "";

            // Getting node values (Just the basics for testing right now)
            let product = xml.getElementsByTagName("product")[0]; // Normally should be just one
            
            let name = product.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let desc = product.getElementsByTagName("desc")[0].childNodes[0].nodeValue;
            let price = product.getElementsByTagName("price")[0].childNodes[0].nodeValue;
            let img = product.getElementsByTagName("img")[0].childNodes[0].nodeValue; 

            displaySection.innerHTML += `<p>${name}</p>`;
            displaySection.innerHTML += `<p>${desc}</p>`;
            displaySection.innerHTML += `<p>${price}</p>`;
            displaySection.innerHTML += `<img src="/api/get_image.php?imgName=${img}" alt="" class="w-full h-full object-cover" />`;
        };

        const getProductAjax = () => {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    displayProduct(xhr.responseXML);
                }
            };

            xhr.open("GET", "/api/get_product.php?prodId=<?php echo $prodId ?>", true);
            xhr.send();
        };

        window.onload = () => {
            getProductAjax();
        };
    </script>
</body>
</html>