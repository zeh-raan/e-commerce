<?php
session_start();

/*
if (!isset($_SESSION["username"])) {
    header("Location: /");
}
*/

// NOTE: "prodName" was changed to "prodNameInForm" because it conflicts
//       with "prodName" in search bar (in header)
// TODO: Fix that!
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Add a Product</title>

    <link rel="stylesheet" href="/css/output.css">
</head>

<body class="">
    <?php include("components/header.php"); ?>

    <!-- Modal to show success/failure feedback -->
    <button id="toggle-modal-btn" data-target="status-modal" class="hidden" onclick="document.getElementById(this.dataset.target).classList.toggle('hidden')"></button>
    <div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">

                <!-- Button to close modal -->
                <div class="flex items-center justify-between p-2 border-b rounded-t border-gray-200 bg-white">
                    <button type="button" class="text-black/50 hover:text-black bg-white cursor-pointer rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-all" onclick="document.getElementById('toggle-modal-btn').click()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4 md:p-5">
                    <div id="status-message"></div>
                </div>
            </div>
        </div>
    </div>

    <section id="add-product-section" class="mt-30 w-screen h-fit mb-16">
        <h1 class="w-fit m-auto text-center text-4xl font-bold px-4 pb-2 border-b-2 border-gray-200">Add a Product!</h1>

        <form name="addProdForm" method="post" class="w-full grid grid-rows-1 grid-cols-2 px-8 py-8">

            <!-- Image-related inputs -->
            <div id="add-product-images-container" class="m-4 flex flex-col gap-4">
                <div id="product-image-preview" class="w-full h-128 bg-white border-4 border-gray-200 border-dashed rounded-lg"></div>
                <input type="file" name="prodImg" id="prodImg" hidden multiple accept="image/jpeg,image/avif" >

                <div id="add-product-images-btn-container" class="w-full flex gap-4">
                    <button type="button" onclick="clickToAddImages();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-blue-700 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-blue-700 transition-all duration-300 cursor-pointer active:scale-95">Add Image</button>
                    <button type="button" onclick="clearImages();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-red-600 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-red-600 transition-all duration-300 cursor-pointer active:scale-95">Clear Images</button>
                </div>
            </div>

            <!-- "Regular" inputs -->
            <div id="add-product-text-container" class="p-4 h-full relative">
                
                <!-- This code snippet is taken from https://flowbite.com/docs/forms/floating-label/ and iterated over -->
                <label for="prodCategory" class="sr-only">Underline select</label>
                <select id="prodCategory" name="prodCategory" class="mb-6 block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option value="" hidden selected>Choose a Category</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Perfume">Perfume</option>
                    <option value="Others">Others</option>
                </select>

                <div class="relative z-0">
                    <input type="text" id="prodNameInForm" name="prodNameInForm" class="mb-6 block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="prodNameInForm" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Name</label>
                </div>

                <div class="relative z-0">
                    <input oninput="this.value = this.value.replace(/[^0-9.]/g, '')" type="text" id="prodPrice" name="prodPrice" class="mb-6 block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="prodPrice" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Price in MUR</label>
                </div>

                <label for="prodDesc" class="block mb-2 text-sm font-medium text-gray-400">Description</label>
                <textarea id="prodDesc" name="prodDesc" rows="4" class="mb-10 resize-none block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Describe the product here..."></textarea>

                <h3 class="text-gray-600 text-lg pb-2 border-gray-200 border-b-2">Details</h3>
                <div id="add-details-container" class="pt-4 mb-4 flex flex-col gap-4">
                    <div class="detail-wrapper flex gap-4">
                        <label class="text-nowrap text-gray-400">Detail Name</label>
                        <input type="text" class="w-[30%] detail-name-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">

                        <label class="text-nowrap text-gray-400">Detail Value</label>
                        <input type="text" class="2-[30%] detail-val-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    </div>

                    <div id="add-details-btn-container" class="flex gap-4">
                        <button id="add-detail-btn" type="button" onclick="addDetail();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-blue-700 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-blue-700 transition-all duration-300 cursor-pointer active:scale-95">Add Detail</button>
                        <button id="remove-detail-btn" type="button" onclick="removeDetail();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-red-600 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-red-600 transition-all duration-300 cursor-pointer active:scale-95">Remove Detail</button>
                    </div>
                </div>

                <div class="flex flex gap-4">
                    <input type="submit" value="Add Product" class="flex-1 bg-green-500 border-2 border-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 hover:border-green-600 transition-all cursor-pointer font-semibold active:scale-95">
                    <input type="reset" value="Clear Form" class="flex-1 bg-red-500 border-2 border-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 hover:border-red-600 transition-all cursor-pointer font-semibold active:scale-95">
                </div>
            </div>
        </form>
    </section>

    <?php include("components/footer.php"); ?>

    <script>
        const addProdForm = document.forms.addProdForm;
        const addImagesForm = document.forms.addImagesForm;
        const showModalBtn = document.getElementById("toggle-modal-btn");
        const modalStatusMessage = document.getElementById("status-message");
        
        function clickToAddImages() {
            addProdForm.prodImg.click();
        }

        // Upload Image Preview logic!!
        addProdForm.prodImg.addEventListener('change', function(e) {
            handleImageUpload(e.target.files);
        });

        function handleImageUpload(files) {
            const previewContainer = document.getElementById('product-image-preview');
            
            // Keep existing images and add new ones
            previewContainer.classList.remove('border-dashed', 'border-gray-200');
            previewContainer.classList.add('border-solid', 'border-blue-300', 'p-2');
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Create image preview
                const imgWrapper = document.createElement('div');
                imgWrapper.className = 'relative inline-block m-2';
                
                const img = document.createElement('img');
                img.className = 'w-32 h-32 object-cover rounded-lg shadow-md';
                img.file = file;
                
                // Create remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors';
                removeBtn.innerHTML = 'X';
                removeBtn.onclick = function() {
                    removeImagePreview(imgWrapper, file);
                };
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(removeBtn);
                previewContainer.appendChild(imgWrapper);
                
                // Read and display the image
                const reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }

        function removeImagePreview(imgElement, file) {
            imgElement.remove();
            
            // Update the file input to remove the file
            const dt = new DataTransfer();
            const input = addProdForm.prodImg;
            
            for (let i = 0; i < input.files.length; i++) {
                if (input.files[i] !== file) {
                    dt.items.add(input.files[i]);
                }
            }
            
            input.files = dt.files;
            
            // If no images left, restore dashed border
            const previewContainer = document.getElementById('product-image-preview');
            if (previewContainer.children.length === 0) {
                previewContainer.classList.add('border-dashed', 'border-gray-200');
                previewContainer.classList.remove('border-solid', 'border-blue-300', 'p-2');
            }
        }

        function clearImages() {
            const previewContainer = document.getElementById('product-image-preview');
            previewContainer.innerHTML = '';
            
            // Reset file input
            addProdForm.prodImg.value = '';
            
            // Restore original styling
            previewContainer.classList.add('border-dashed', 'border-gray-200');
            previewContainer.classList.remove('border-solid', 'border-blue-300', 'p-2');
        }

        // Add more details logic (and remove too!)
        function addDetail() {
            const detailsContainer = document.getElementById('add-details-container');
            const firstDetailWrapper = detailsContainer.querySelector('.detail-wrapper');
            
            // Create a new detail wrapper
            const newDetailWrapper = document.createElement('div');
            newDetailWrapper.className = 'detail-wrapper flex gap-4 mt-4';
            newDetailWrapper.innerHTML = `
                <label class="text-nowrap text-gray-400">Detail Name</label>
                <input type="text" class="flex-1 detail-name-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                
                <label class="text-nowrap text-gray-400">Detail Value</label>
                <input type="text" class="flex-1 detail-val-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            `;
            
            // Insert before the button container
            const buttonContainer = document.getElementById('add-details-btn-container');
            detailsContainer.insertBefore(newDetailWrapper, buttonContainer);
        }

        // Function to remove the last detail field
        function removeDetail() {
            const detailsContainer = document.getElementById('add-details-container');
            const detailWrappers = detailsContainer.querySelectorAll('.detail-wrapper');
            
            // Don't remove the first/default detail field
            if (detailWrappers.length > 1) {
                const lastDetailWrapper = detailWrappers[detailWrappers.length - 1];
                lastDetailWrapper.remove();
            }
        }

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

        /*
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
        */

        function validateForm() {
            
            // Validating form inputs
            let category = addProdForm.prodCategory.value;
            if (!category) {
                return "Please choose a category!";
            }

            let name = addProdForm.prodNameInForm.value.trim();
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
            if (uploadedImages.length == 0) {
                return "Please upload an image!";
            }

            // Exceeded max limit
            if (uploadedImages.length > maxImages) {
                return `You can only upload a maximum of ${maxImages} images!`;
            }

            // Validate wach image size and file extension
            for (let i = 0; i < uploadedImages.length; i++) {
                const img = uploadedImages[i];
                if (!allowedTypes.includes(img.type) || !img.type.startsWith("image/")) {
                    return `Type of Image #${i + 1} is unsupported!`;
                }

                if (img.size > maxSize) {
                    return `Size of Image #${i + 1} exceeds limit (${maxSize / (1024 * 1024)} MB)!`;
                }
            }

            return ""; // All good 👍
        }

        addProdForm.addEventListener("submit", (e) => {
            e.preventDefault();

            // Catching inputs
            let category = addProdForm.prodCategory.value;
            let name = addProdForm.prodNameInForm.value.trim();
            let desc = addProdForm.prodDesc.value.trim();
            let price = addProdForm.prodPrice.value;

            // TODO: Validate data
            let err = validateForm();
            if (err) {
                
                // Show modal
                modalStatusMessage.innerHTML = `<h1>Error!</h1><p>${err}</p>`;
                showModalBtn.click();

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
                    
                    // Product successfully added
                    // Thus, show modal

                    modalStatusMessage.innerHTML = `<h1>Product added successfully!</h1><a href="/product/${res.product_id}">See new product here!</a>`;
                    showModalBtn.click();
                }
            };

            xhr.send(formData);
        }
    </script>
</body>
</html>