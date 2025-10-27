<?php
session_start();

/*
if (!isset($_SESSION["username"])) {
    header("Location: /");
}
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Add a Product</title>

    <link rel="stylesheet" href="/frontend/css/output.css">
</head>

<body class="">
    <?php include("frontend/pages/components/header.php"); ?>

    <!-- TODO: Rework Form UI -->
    <section id="add-product-section" class="mt-30 w-screen h-fit mb-16">
        <form name="addProdForm" method="post" class="w-full grid grid-rows-1 grid-cols-2 px-8 py-8">

            <!-- Image-related inputs -->
            <div id="add-product-images-container" class="m-4 flex flex-col gap-4">
                <div id="product-image-preview" class="w-full h-128 bg-white border-4 border-gray-200 border-dashed rounded-lg"></div>
                <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer active:scale-95">Add Image</button>
            </div>

            <!-- "Regular" inputs -->
            <div id="add-product-text-container" class="p-4 h-full relative">

                <!-- This code snippet is taken from https://flowbite.com/docs/forms/floating-label/ and iterated over -->
                <div class="relative z-0">
                    <input type="text" id="floating_standard" class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="floating_standard" class="absolute text-sm text-black dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Name</label>
                </div>
            </div>
        </form>
    </section>

    <form name="addProdForm" method="post" class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md h-full">
        <div class="grid grid-cols-2 gap-8 h-full">
            <div class="flex flex-col h-full">
                <div class="space-y-4 flex-1">
                    <div>
                        <label for="prodCategory" class="block text-sm font-semibold text-gray-800 mb-2">Category</label>
                        <select name="prodCategory" id="prodCategory" class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                            <option value="Electronics">Electronics</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Perfume">Perfume</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div>
                        <label for="prodName" class="block text-sm font-semibold text-gray-800 mb-2">Name</label>
                        <input required type="text" name="prodName" id="prodName" placeholder="Product Name" class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                    </div>

                    <div>
                        <label for="prodDesc" class="block text-sm font-semibold text-gray-800 mb-2">Description</label>
                        <textarea required name="prodDesc" id="prodDesc" cols="30" rows="3" placeholder="Describe your product here..." class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors"></textarea>
                    </div>

                    <div>
                        <label for="prodPrice" class="block text-sm font-semibold text-gray-800 mb-2">Price</label>
                        <input required type="text" name="prodPrice" id="prodPrice" class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors" oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                    </div>
                </div>

                <div id="prod-img-main-container" class="mt-6">
                    <input required type="file" name="prodImg" id="prodImg" accept="image/jpeg,image/avif" class="w-full p-3 border-2 border-gray-300 border-dashed rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors cursor-pointer">
                </div>
            </div>

            <!-- Product Details -->
            <div class="flex flex-col h-full">
                <div id="prod-details-main-container" class="flex-1">
                    <label class="block text-sm font-semibold text-gray-800 mb-3">Product Details</label>
                    
                    <div id="prod-details-list-container" class="border border-gray-300 rounded-lg p-4 h-fit max-h-56 overflow-y-auto bg-gray-50">
                        <div class="mb-4 p-3 bg-white rounded border border-gray-200">
                            <label for="prodDetailName1" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                            <input required type="text" name="prodDetailName1" id="prodDetailName1" class="detail-name-input w-full p-2 border border-gray-300 rounded mb-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-200">

                            <label for="prodDetailValue1" class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                            <input required type="text" name="prodDetailValue1" id="prodDetailValue1" class="detail-val-input w-full p-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-200">
                        </div>
                    </div>

                    <button type="button" id="add-detail-btn" class="w-full mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-200 transition-colors font-medium">
                        Add detail
                    </button>
                </div>

                <!-- <div><p>Error message</p></div> -->

                <div class="flex gap-3 pt-6 mt-auto">
                    <input type="submit" value="Add Product" class="flex-1 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-200 transition-colors font-semibold">
                    <input type="reset" value="Clear Form" class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-200 transition-colors font-semibold">
                </div>
            </div>
        </div>
    </form>

    <?php include("frontend/pages/components/footer.php"); ?>

    <script>
        const addProdForm = document.forms.addProdForm;
        const addDetailButton = document.getElementById("add-detail-btn");
        
        function extractDetailKeyValues() {
            const detailNames = document.getElementsByClassName("detail-name-input")
            const detailValues = document.getElementsByClassName("detail-val-input")

            let keyValPairs = [];
            for (let i = 0; i < detailNames.length; i++) {
                keyValPairs.push({
                    name: detailNames[i].value.trim(),
                    value: detailValues[i].value.trim(),
                });
            }

            return keyValPairs
        }

        addDetailButton.addEventListener("click", () => {
            const detailsContainer = document.getElementById("prod-details-list-container");
            const newDetailDiv = document.createElement("div");
            newDetailDiv.innerHTML += `
                <div class="mb-4 border-dotted border-t-2 border-gray-400"></div>
                <div class="mb-4 p-3 bg-white rounded border border-gray-200">
                    <label for="" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                    <input required type="text" name="" class="detail-name-input w-full p-2 border border-gray-300 rounded mb-2">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                    <input required type="text" name="" class="detail-val-input w-full p-2 border border-gray-300 rounded">
                </div>
            `;

            detailsContainer.appendChild(newDetailDiv);
        });

        function validateForm() {
            
            // Validating form inputs
            let name = addProdForm.prodName.value.trim();
            if (name.length < 10) {
                return "Name must be at least 10 characters long!";
            }

            let desc = addProdForm.prodDesc.value.trim();
            if (desc.length < 50) {
                return "Description must be at least 50 characters long!";
            }

            let price = addProdForm.prodPrice.value.trim();
            const priceRegex = /^\d+(\.\d{1,2})?$/;

            if (!priceRegex.test(price) || parseFloat(price) <= 0) {
                return "Please enter a valid price!";
            }

            const details = extractDetailKeyValues();
            for (let i = 0; i < details.length; i++) {
                if (details[i].name.length < 3) {
                    return `Please enter a valid detail name for Detail #${i + 1}`;
                }

                if (details[i].value.length < 3) {
                    return `Please enter a valid detail value for Detail #${i + 1}`;
                }
            }

            // Validating images
            const uploadedImages = addProdForm.prodImg.files;

            const allowedTypes = ["image/jpeg", "image/avif"];
            const maxSize = 5 * 1024 * 1024;
            const maxImages = 5;

            // No images uploaded
            if (uploadImages.length == 0) {
                return "Please upload an image!";
            }

            // Exceeded max limit
            if (uploadImages.length > maxImages) {
                return `You can only upload a maximum of ${maxImages} images!`;
            }

            // Validate wach image size and file extension
            for (let i = 0; i < uploadedImages.length; i++) {
                const img = uploadImages[i];
                if (!allowedTypes.includes(img.type) || !img.type.startsWith("image/")) {
                    return `Type of Image #${i + 1} is unsupported!`;
                }

                if (img.size > maxSize) {
                    return `Size of Image #${i + 1} exceeds limit (${maxSize / (1024 * 1024)} MB)!`;
                }
            }

            return ""; // All good 👍
        }

        function uploadImagesAjax(prodId) {
            const imageUploads = addProdForm.prodImg.files;
            const formData = new FormData();

            // Appends data
            formData.append("prodId", prodId);
            for (let i = 0; i < imageUploads.length; i++) {
                formData.append("images[]", imageUploads[i]);
            }

            // Makes AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/add_image.php", true);
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    let res = JSON.parse(xhr.responseText);
                    console.log(res);
                }
            };

            xhr.send(formData);
        }

        addProdForm.addEventListener("submit", (e) => {
            e.preventDefault();

            // Catching inputs
            let category = addProdForm.prodCategory.value;
            let name = addProdForm.prodName.value.trim();
            let desc = addProdForm.prodDesc.value.trim();
            let price = addProdForm.prodPrice.value;

            // TODO: Validate data
            let err = validateForm();
            if (err) {
                alert(err);
                return;
            }

            // Send JSON body
            let payload = {
                category: category,
                name: name,
                desc: desc,
                price: price,
                details: extractDetailKeyValues(),
            };

            // Making request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/add_product.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    let res = JSON.parse(xhr.responseText);
                    const prodId = res.product_id;
                    
                    // Send images to another endpoint 
                    // Using FormData for built-in file handling

                    uploadImagesAjax(prodId);
                }
            };

            xhr.send(JSON.stringify(payload));
        });

        addProdForm.addEventListener("reset", (e) => {
            const detailsContainer = document.getElementById("prod-details-list-container");
            detailsContainer.innerHTML = `
                <div class="mb-4 p-3 bg-white rounded border border-gray-200">
                    <label for="prodDetailName1" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                    <input required type="text" name="prodDetailName1" id="prodDetailName1" class="detail-name-input w-full p-2 border border-gray-300 rounded mb-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-200">

                    <label for="prodDetailValue1" class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                    <input required type="text" name="prodDetailValue1" id="prodDetailValue1" class="detail-val-input w-full p-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-200">
                </div>
            `;
        });

        window.onload = () => {};
    </script>
</body>
</html>