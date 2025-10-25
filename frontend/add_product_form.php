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
    
    <title>Add Your Product</title>

    <link rel="stylesheet" href="/frontend/css/output.css">
</head>

<body class="bg-slate-900 p-4">
    <form name="addProdForm" method="post" class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md h-full">
        <div class="grid grid-cols-2 gap-8 h-full">
            
            <!-- Left Column - Main Fields -->
            <div class="flex flex-col h-full">
                <div class="space-y-4 flex-1">
                    <div>
                        <label for="prodCategory" class="block text-sm font-semibold text-gray-800 mb-2">Category</label>
                        <select name="prodCategory" id="prodCategory" class="w-full p-3 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                            <option value="Electronics">Electronics</option>
                        </select>
                    </div>

                    <div>
                        <label for="prodName" class="block text-sm font-semibold text-gray-800 mb-2">Name</label>
                        <input type="text" name="prodName" id="prodName" placeholder="Product Name" class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                    </div>

                    <div>
                        <label for="prodDesc" class="block text-sm font-semibold text-gray-800 mb-2">Description</label>
                        <textarea name="prodDesc" id="prodDesc" cols="30" rows="3" placeholder="Describe your product here..." class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors"></textarea>
                    </div>

                    <div>
                        <label for="prodPrice" class="block text-sm font-semibold text-gray-800 mb-2">Price</label>
                        <input type="text" name="prodPrice" id="prodPrice" class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors" oninput="this.value = this.value.replace(/[^0-9.-]/g, '')">
                    </div>
                </div>

                <!-- Images moved below details -->
                <div id="prod-img-main-container" class="mt-6">
                    <input type="file" name="prodImg" id="prodImg" accept="image/jpeg" class="w-full p-3 border-2 border-gray-300 border-dashed rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors cursor-pointer">
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="flex flex-col h-full">
                <div id="prod-details-main-container" class="flex-1">
                    <label class="block text-sm font-semibold text-gray-800 mb-3">Product Details</label>
                    
                    <div id="prod-details-list-container" class="border border-gray-300 rounded-lg p-4 h-64 overflow-y-auto bg-gray-50">
                        <div class="mb-4 p-3 bg-white rounded border border-gray-200">
                            <label for="prodDetailName1" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                            <input type="text" name="prodDetailName1" id="prodDetailName1" class="detail-name-input w-full p-2 border border-gray-300 rounded mb-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-200">

                            <label for="prodDetailValue1" class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                            <input type="text" name="prodDetailValue1" id="prodDetailValue1" class="detail-val-input w-full p-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-200">
                        </div>
                    </div>

                    <button type="button" id="add-detail-btn" class="w-full mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-200 transition-colors font-medium">
                        Add detail
                    </button>
                </div>

                <div class="flex gap-3 pt-6 mt-auto">
                    <input type="submit" value="Add Product" class="flex-1 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-200 transition-colors font-semibold">
                    <input type="reset" value="Clear Form" class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-200 transition-colors font-semibold">
                </div>
            </div>
        </div>
    </form>

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
            detailsContainer.innerHTML += `
                <div class="mb-4 border-dotted border-t-2 border-gray-400"></div>
                <div class="mb-4 p-3 bg-white rounded border border-gray-200">
                    <label for="" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                    <input type="text" name="" class="detail-name-input w-full p-2 border border-gray-300 rounded mb-2">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                    <input type="text" name="" class="detail-val-input w-full p-2 border border-gray-300 rounded">
                </div>
            `;
        });

        function uploadImagesAjax(prodId) {
            const imageUploads = addProdForm.prodImg.files;
            const formData = new FormData();

            // Appends data
            formData.append("prodId", prodId);
            for (let i = 0; i < imageUploads.length; i++) {
                formData.append("images[]", imageUploads[i]);
            }

            console.log(formData);

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
            // ...

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

        window.onload = () => {};
    </script>
</body>
</html>