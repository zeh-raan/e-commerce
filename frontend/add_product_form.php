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
    <form method="post" class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <div class="flex gap-6">
            
            <!-- Image Preview -->
            <div class="w-1/3">
                <div id="prod-img-main-container" class="mb-4">
                    <input type="file" name="prodImg" id="prodImg" accept="image/jpeg" class="w-full p-2 border border-gray-300 rounded mb-4">
                    <!-- Image preview area -->
                    <div class="w-full h-64 border-2 border-dashed border-gray-300 rounded flex items-center justify-center bg-gray-50">
                        <p class="text-gray-500">Image preview will appear here</p>
                    </div>
                </div>
            </div>

            <!-- Form Inputs -->
            <div class="w-2/3">
                <select name="prodCategory" id="prodCategory" class="w-full p-2 border border-gray-300 rounded mb-4">
                    <option value="el">Electronics</option>
                </select>

                <label for="prodName" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="prodName" id="prodName" placeholder="Product Name" class="w-full p-2 border border-gray-300 rounded mb-4">

                <label for="prodDesc" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="prodDesc" id="prodDesc" cols="30" rows="3" placeholder="Describe your product here..." class="w-full p-2 border border-gray-300 rounded mb-4"></textarea>

                <label for="prodPrice" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                <input type="number" name="prodPrice" id="prodPrice" class="w-full p-2 border border-gray-300 rounded mb-4">

                <div id="prod-details-main-container" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Details</label>
                    <div id="prod-details-list-container" class="border border-gray-300 rounded p-4 max-h-40 overflow-y-auto">
                        <div class="mb-4">
                            <label for="prodDetailName" class="block text-sm font-medium text-gray-700 mb-1">Detail Name</label>
                            <input type="text" name="prodDetailName" id="prodDetailName" class="w-full p-2 border border-gray-300 rounded mb-2">

                            <label for="prodDetailValue" class="block text-sm font-medium text-gray-700 mb-1">Detail Desc</label>
                            <input type="text" name="prodDetailValue" id="prodDetailValue" class="w-full p-2 border border-gray-300 rounded">
                        </div>
                    </div>

                    <button type="button" id="add-detail-btn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add detail</button>
                </div>

                <div class="flex gap-2">
                    <input type="submit" value="Add Product" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    <input type="reset" value="Clear Form" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                </div>
            </div>
        </div>
    </form>
</body>
</html>