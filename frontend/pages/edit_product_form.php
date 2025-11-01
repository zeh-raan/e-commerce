<?php
// session_start();
$prodId = $GLOBALS["prodId"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Edit Product</title>
    <link rel="stylesheet" href="/css/output.css">
</head>

<body class="">
    <?php include("components/header.php"); ?>

    <!-- Modal to show success/failure feedback -->
    <button id="toggle-modal-btn" data-target="status-modal" class="hidden" onclick="document.getElementById(this.dataset.target).classList.toggle('hidden')"></button>
    <div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
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

    <section id="edit-product-section" class="mt-30 w-screen h-fit mb-16">
        <h1 class="w-fit m-auto text-center text-4xl font-bold px-4 pb-2 border-b-2 border-gray-200">Edit Product</h1>

        <form name="editProdForm" method="post" class="w-full grid grid-rows-1 grid-cols-2 px-8 py-8">

            <!-- Image-related inputs -->
            <div id="edit-product-images-container" class="m-4 flex flex-col gap-4">
                <div id="product-image-preview" class="w-full h-128 bg-white border-4 border-gray-200 border-dashed rounded-lg">
                    <!-- Images will be populated by JavaScript -->
                </div>
                <input type="file" name="prodImg" id="prodImg" hidden multiple accept="image/jpeg,image/avif">

                <div id="edit-product-images-btn-container" class="w-full flex gap-4">
                    <button type="button" onclick="clickToAddImages();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-blue-700 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-blue-700 transition-all duration-300 cursor-pointer active:scale-95">Add Image</button>
                    <button type="button" onclick="clearImages();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-red-600 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-red-600 transition-all duration-300 cursor-pointer active:scale-95">Clear Images</button>
                </div>
            </div>

            <!-- "Regular" inputs -->
            <div id="edit-product-text-container" class="p-4 h-full relative">
                
                <label for="prodCategory" class="sr-only">Underline select</label>
                <select id="prodCategory" name="prodCategory" class="mb-6 block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option value="" hidden>Choose a Category</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Perfume">Perfume</option>
                    <option value="Others">Others</option>
                </select>

                <div class="relative z-0">
                    <input type="text" id="prodNameInForm" name="prodNameInForm" class="mb-6 block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="prodNameInForm" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                </div>

                <div class="relative z-0">
                    <input oninput="this.value = this.value.replace(/[^0-9.]/g, '')" type="text" id="prodPrice" name="prodPrice" class="mb-6 block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="prodPrice" class="absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price in MUR</label>
                </div>

                <label for="prodDesc" class="block mb-2 text-sm font-medium text-gray-400">Description</label>
                <textarea id="prodDesc" name="prodDesc" rows="4" class="mb-10 resize-none block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400" placeholder="Describe the product here..."></textarea>

                <h3 class="text-gray-600 text-lg pb-2 border-gray-200 border-b-2">Details</h3>
                <div id="edit-details-container" class="pt-4 mb-4 flex flex-col gap-4">
                    <!-- Details will be populated by JavaScript -->
                </div>

                <div id="edit-details-btn-container" class="flex gap-4 mb-6">
                    <button type="button" onclick="addDetail();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-blue-700 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-blue-700 transition-all duration-300 cursor-pointer active:scale-95">Add Detail</button>
                    <button type="button" onclick="removeDetail();" class="w-full font-semibold py-3 px-6 bg-transparent hover:bg-red-600 text-gray-400 hover:text-white border-2 border-solid border-gray-400 rounded-lg hover:border-red-600 transition-all duration-300 cursor-pointer active:scale-95">Remove Detail</button>
                </div>

                <div class="flex gap-4">
                    <input type="submit" value="Save Changes" class="flex-1 bg-green-500 border-2 border-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 hover:border-green-600 transition-all cursor-pointer font-semibold active:scale-95">
                    <button type="button" onclick="loadProductData()" class="flex-1 bg-red-500 border-2 border-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 hover:border-red-600 transition-all cursor-pointer font-semibold active:scale-95">Reset Changes</button>
                </div>
            </div>
        </form>
    </section>

    <?php include("components/footer.php"); ?>

    <script>
        const editProdForm = document.forms.editProdForm;
        const showModalBtn = document.getElementById("toggle-modal-btn");
        const modalStatusMessage = document.getElementById("status-message");
        
        // Store initial form state for comparison
        let initialState = {};
        let productImages = [];

        // Load product data on page load
        window.onload = () => {
            loadProductData();
        };

        // Retrieves the product's XML
        function loadProductData() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "/api/get_product.php?prodId=<?php echo $prodId; ?>", true);
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    populateForm(xhr.responseXML); // Fills form
                    // storeInitialState();
                }
            };

            xhr.send();
        }

        // Fills in form with retrieved values
        function populateForm(xml) {

            // Clear variables
            initialState = {};
            productImages = [];

            let product = xml.getElementsByTagName("product")[0];

            // Gets XML values
            let id = product["id"];

            let category = product.getElementsByTagName("category")[0].childNodes[0].nodeValue;
            let name = product.getElementsByTagName("name")[0].childNodes[0].nodeValue;
            let desc = product.getElementsByTagName("desc")[0].childNodes[0].nodeValue;
            let price = product.getElementsByTagName("price")[0].childNodes[0].nodeValue;

            // Fills in inputs
            document.getElementById("prodCategory").value = category;
            document.getElementById("prodNameInForm").value = name; // NOTE: "prodName" is conflicting with "prodName" in search bar
            document.getElementById("prodPrice").value = price;
            document.getElementById("prodDesc").value = desc;

            // Fills in images (Populates with image previews)
            let allProductImages = product.getElementsByTagName("img");
            for (let i = 0; i < allProductImages.length; i++) {
                productImages.push(allProductImages[i].childNodes[0].nodeValue);
            }

            populateImages();

            // Fills in details
            let details = product.getElementsByTagName("dt");
            let allDetails = [];

            for (let i = 0; i < details.length; i++) {
                let detailName = details[i].getAttribute("name");
                let detailValue = details[i].childNodes[0].nodeValue;

                allDetails.push({ name: detailName, value: detailValue });
            }

            populateDetails(allDetails);

            // Stores initial state (declared globally)
            initialState = {
                category: category,
                name: name,
                desc: desc,
                price: price,
                details: allDetails,
                images: [...productImages] // Copies to avoid mutations
            };
        }

        function populateImages() {
            const previewContainer = document.getElementById("product-image-preview");
            previewContainer.innerHTML = ""; // Clears container
            
            // Creates a preview for each image
            productImages.forEach((image) => {
                const imgWrapper = document.createElement("div");
                imgWrapper.className = "relative inline-block m-2";
                
                const img = document.createElement("img");
                img.src = `/api/get_image.php?imgName=${image}`;
                img.className = "w-32 h-32 object-cover rounded-lg shadow-md";
                
                const removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.className = "cursor-pointer absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors";
                removeBtn.innerHTML = "X";
                removeBtn.onclick = function() {
                    removeExistingImage(image, imgWrapper);
                };
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(removeBtn);
                previewContainer.appendChild(imgWrapper);
            });
        }

        function removeExistingImage(src, el) {
            el.remove();
            productImages = productImages.filter(img => img !== src); // Removes image name from array of images for that product
        }

        // Fills in details (Starts empty)
        function populateDetails(details) {
            const detailsContainer = document.getElementById("edit-details-container");
            detailsContainer.innerHTML = "";
            
            details.forEach(detail => {
                const detailWrapper = document.createElement("div");
                detailWrapper.className = "detail-wrapper flex gap-4";
                detailWrapper.innerHTML = `
                    <label class="text-nowrap text-gray-400">Detail Name</label>
                    <input type="text" value="${detail.name}" class="w-[30%] detail-name-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    
                    <label class="text-nowrap text-gray-400">Detail Value</label>
                    <input type="text" value="${detail.value}" class="w-[30%] detail-val-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                `;

                detailsContainer.appendChild(detailWrapper);
            });
        }

        // Compares changes against initial state and returns differences
        function compareChanges() {
            const currentState = {
                category: document.getElementById("prodCategory").value,
                name: document.getElementById("prodNameInForm").value.trim(),
                desc: document.getElementById("prodDesc").value.trim(),
                price: document.getElementById("prodPrice").value.trim(),
                details: extractDetailKeyValues(),
                images: [...productImages]
            };

            // Finds differences
            let differencePayload = {};
            const fields = ["category", "name", "desc", "price"];

            // Compares fields (Details and Images are handled seperately)
            fields.forEach(i => {
                if (currentState[i] !== initialState[i]) {
                    differencePayload[i] = currentState[i];
                }
            });

            // Handling images
            // Converts to JSON string for easier comparison
            if (JSON.stringify(currentState.images) != JSON.stringify(initialState.images)) {
                differencePayload.images = currentState.images.filter(img => !initialState.images.includes(img));
            } 

            // Handling details
            if (JSON.stringify(currentState.details) !== JSON.stringify(initialState.details)) {
                differencePayload.details = currentState.details;
            }

            return differencePayload;
        }

        function clickToAddImages() {
            editProdForm.prodImg.click();
        }

        editProdForm.prodImg.addEventListener("change", function(e) {
            handleImageUpload(e.target.files);
        });

        function handleImageUpload(files) {
            const previewContainer = document.getElementById("product-image-preview");
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                productImages.push(file.name);
                
                const imgWrapper = document.createElement("div");
                imgWrapper.className = "relative inline-block m-2";
                
                const img = document.createElement("img");
                img.className = "w-32 h-32 object-cover rounded-lg shadow-md";
                img.file = file;
                
                const removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.className = "cursor-pointer absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors";
                removeBtn.innerHTML = "X";
                removeBtn.onclick = function() {
                    removeImagePreview(imgWrapper, file);
                };
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(removeBtn);
                previewContainer.appendChild(imgWrapper);
                
                const reader = new FileReader();
                reader.onload = (function(aImg) {
                    return function(e) {
                        aImg.src = e.target.result;
                    };
                })(img); // Calls function immediately
                
                reader.readAsDataURL(file);
            }
        }

        function removeImagePreview(imgElement, file) {
            imgElement.remove();
            
            const dt = new DataTransfer();
            const input = editProdForm.prodImg;
            
            for (let i = 0; i < input.files.length; i++) {
                if (input.files[i] !== file) {
                    dt.items.add(input.files[i]);
                }
            }
            
            input.files = dt.files;
        }

        function clearImages() {
            const previewContainer = document.getElementById("product-image-preview");
            previewContainer.innerHTML = "";

            editProdForm.prodImg.value = "";
            productImages = [];
        }

        function addDetail() {
            const detailsContainer = document.getElementById("edit-details-container");
            const newDetailWrapper = document.createElement("div");
            newDetailWrapper.className = "detail-wrapper flex gap-4 mt-4";
            newDetailWrapper.innerHTML = `
                <label class="text-nowrap text-gray-400">Detail Name</label>
                <input type="text" class="flex-1 detail-name-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Detail name">
                
                <label class="text-nowrap text-gray-400">Detail Value</label>
                <input type="text" class="flex-1 detail-val-input border-b-2 border-solid border-gray-400 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Detail value">
            `;
            detailsContainer.appendChild(newDetailWrapper);
        }

        function removeDetail() {
            const detailsContainer = document.getElementById("edit-details-container");
            const detailWrappers = detailsContainer.querySelectorAll(".detail-wrapper");
            
            if (detailWrappers.length > 1) {
                const lastDetailWrapper = detailWrappers[detailWrappers.length - 1];
                lastDetailWrapper.remove();
            }
        }

        function extractDetailKeyValues() {
            const detailNames = document.getElementsByClassName("detail-name-input");
            const detailValues = document.getElementsByClassName("detail-val-input");

            let keyValPairs = [];
            for (let i = 0; i < detailNames.length; i++) {
                if (detailNames[i].value.trim() && detailValues[i].value.trim()) {
                    keyValPairs.push({
                        name: detailNames[i].value.trim(),
                        value: detailValues[i].value.trim(),
                    });
                }
            }
            return keyValPairs;
        }

        function validateForm() {
            let category = editProdForm.prodCategory.value;
            if (!category) {
                return "Please choose a category!";
            }

            let name = editProdForm.prodNameInForm.value.trim();
            if (name.length < 10) {
                return "Name must be at least 10 characters long!";
            }

            let desc = editProdForm.prodDesc.value.trim();
            if (desc.length < 50) {
                return "Description must be at least 50 characters long!";
            }

            let price = editProdForm.prodPrice.value.trim();
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

            const uploadedImages = editProdForm.prodImg.files;
            const allowedTypes = ["image/jpeg", "image/avif"];
            const maxSize = 5 * 1024 * 1024;
            const maxImages = 5;

            // Check total images (existing + new)
            const totalImages = productImages.length + uploadedImages.length;
            if (totalImages === 0) {
                return "Please upload at least one image!";
            }

            if (totalImages > maxImages) {
                return `You can only have a maximum of ${maxImages} images!`;
            }

            for (let i = 0; i < uploadedImages.length; i++) {
                const img = uploadedImages[i];
                if (!allowedTypes.includes(img.type) || !img.type.startsWith("image/")) {
                    return `Type of Image #${i + 1} is unsupported!`;
                }
                if (img.size > maxSize) {
                    return `Size of Image #${i + 1} exceeds limit (${maxSize / (1024 * 1024)} MB)!`;
                }
            }

            return "";
        }

        editProdForm.addEventListener("submit", (e) => {
            e.preventDefault();

            const differencePayload = compareChanges();
            if (Object.keys(differencePayload).length == 0) {
                modalStatusMessage.innerHTML = `<h1>No Changes</h1><p>No changes were made to the product.</p>`;
                showModalBtn.click();
                return;
            }

            let err = validateForm();
            if (err) {
                modalStatusMessage.innerHTML = `<h1>Error!</h1><p>${err}</p>`;
                showModalBtn.click();
                return;
            }

            // Prepares to send
            differencePayload.product_id = "<?php echo $prodId; ?>";

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/api/update_product.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.onreadystatechange = () => {
                if ((xhr.readyState == 4) && (xhr.status == 200)) {
                    let res = JSON.parse(xhr.responseText);

                    // Handle image upload
                    const uploadedImages = editProdForm.prodImg.files;
                    uploadImagesAjax("<?php echo $prodId; ?>");
                }
            };
            
            xhr.send(JSON.stringify(differencePayload));
        });

        function uploadImagesAjax(prodId) {
            const imageUploads = editProdForm.prodImg.files;
            const imagesToDelete = initialState.images.filter(img => !productImages.includes(img));

            // Delete images
            if (imagesToDelete.length > 0) {
                const deletePayload = {
                    prodId: prodId,
                    imagesToDelete: imagesToDelete
                };

                const deleteXhr = new XMLHttpRequest();
                deleteXhr.open("POST", "/api/delete_image.php", true);
                deleteXhr.setRequestHeader("Content-type", "application/json");
                deleteXhr.onreadystatechange = () => {

                    // Proceed with uploading new images
                    if ((deleteXhr.readyState == 4) && (deleteXhr.status == 200)) {
                        uploadNewImages(prodId, imageUploads);
                    }
                };

                deleteXhr.send(JSON.stringify(deletePayload));
            } 
            
            // No images to delete, just add new ones
            else {
                uploadNewImages(prodId, imageUploads);
            }
        }

        function uploadNewImages(prodId, imageUploads) {
            if (imageUploads.length === 0) {
                modalStatusMessage.innerHTML = `<h1>Success!</h1><p>Images updated successfully!</p><a href="/product/${prodId}">View updated product</a>`;
                showModalBtn.click();
                loadProductData();
                return;
            }

            const formData = new FormData();
            formData.append("prodId", prodId);

            for (let i = 0; i < imageUploads.length; i++) {
                formData.append("images[]", imageUploads[i]);
            }

            const uploadXhr = new XMLHttpRequest();
            uploadXhr.open("POST", "/api/add_image.php", true);
            uploadXhr.onreadystatechange = () => {
                if ((uploadXhr.readyState == 4) && (uploadXhr.status == 200)) {
                    let res = JSON.parse(uploadXhr.responseText);
                    modalStatusMessage.innerHTML = `<h1>Success!</h1><p>Images updated successfully!</p><a href="/product/${prodId}" class="font-medium text-md text-blue-600 hover:underline">View updated product</a>`;
                    showModalBtn.click();
                    loadProductData();
                }
            };
            uploadXhr.send(formData);
        }
    </script>
</body>
</html>