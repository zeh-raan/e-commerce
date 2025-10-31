<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Catalog</title>

    <link href="/css/output.css" rel="stylesheet">
</head>
<body>
    
    <!-- Navigation Bar -->
    <?php include("components/header.php"); ?>

    <section class="section-layout">
        <!-- Sidebar -->
        <div class="bg-white w-64 p-6 rounded-2xl border border-gray-200 shadow-sm">

            <div class="mb-4 p-2 border-b-2 border-gray-200">
                <h1 class="text-lg font-semibold">Filter</h1>
            </div>

            <form id="filter-form">
                <ul class="space-y-4">

                    <!-- Category -->
                    <li class="rounded-2xl border border-gray-200">

                        <div class="catalog-drop category-toggle">
                            <span class="font-medium">Category</span>
                            <img class="icon transition-transform duration-300"
                                src="/assets/icons/right.svg" alt="toggle">
                        </div>

                        <ul class="filter hidden pl-6 pb-3 space-y-2">
                            <li class="catalog-box"><input type="checkbox" name="category" value="Electronics" class="accent-black"><span>Electronics</span></li>
                            <li class="catalog-box"><input type="checkbox" name="category" value="Fashion" class="accent-black"><span>Fashion</span></li>
                            <li class="catalog-box"><input type="checkbox" name="category" value="Perfume" class="accent-black"><span>Perfume</span></li>
                            <li class="catalog-box"><input type="checkbox" name="category" value="Others" class="accent-black"><span>Others</span></li>
                        </ul>

                    </li>

                </ul>

                <button type="button" id="apply-filter" class="mt-4 buttons">Apply Filter</button>

            </form>
        </div>

        <!-- Product Grid -->
        <div class="w-full h-full p-2 border border-gray-200 rounded-2xl shadow-sm">

            <!-- Filter Bar -->
            <div id="filter-bar" class="flex gap-2 items-center w-full p-2 border-b-2 border-gray-200">
                <p class="text-gray-500">Applied Filters:</p>
                <div id="applied-filters" class="flex flex-wrap gap-2"></div>
            </div>

            <!-- Products Section -->
            <div id="products" class="grid grid-cols-3 gap-4 mt-4"></div>

        </div>

    </section>

    <!-- Footer -->
    <?php include("components/footer.php"); ?>

    <script>
        // Sidebar toggle open and close
        document.querySelectorAll(".category-toggle").forEach(toggle => {
            toggle.addEventListener("click", () => {
                const filterList = toggle.nextElementSibling;
                const icon = toggle.querySelector("img");
                filterList.classList.toggle("hidden");
                icon.src = filterList.classList.contains("hidden")
                    ? "/assets/icons/right.svg"
                    : "/assets/icons/down.svg";
            });
        });

        const productsContainer = document.getElementById("products");

        // Fetch all products from backend
        async function loadProducts() {
            const res     = await fetch("/api/get_all_products.php");
            const xmlText = await res.text();
            const parser  = new DOMParser();
            const xml     = parser.parseFromString(xmlText, "application/xml");

            const categories = xml.querySelectorAll("category");
            let cardsHtml = "";

            categories.forEach(category => {

                const categoryName = category.getAttribute("name");

                category.querySelectorAll("product").forEach(prod => {
                    const id = prod.getAttribute("id");
                    const name  = prod.querySelector("name").textContent;
                    const price = prod.querySelector("price").textContent;
                    const img   = prod.querySelector("img").textContent;

                    cardsHtml += `
                    <div class="product-card rounded-2xl shadow-md border border-gray-200 hover:shadow-lg transition duration-200 p-4 flex flex-col items-center" data-category="${categoryName}">
                        <div class="w-full h-48 bg-gray-100 rounded-xl overflow-hidden flex justify-center items-center">
                            <img src="/api/get_image.php?imgName=${img}" alt="${name}" class="object-cover h-full rounded-2xl">
                        </div>
                        <div class="mt-3 text-center">
                            <h2 class="text-md font-semibold">${name}</h2>
                            <p class="text-gray-600 text-sm">MUR ${price}</p>
                        </div>

                        <a href="/product/${id}" class="mt-2 font-medium text-xs text-blue-600 hover:underline">View</a>
                    </div>
                    `;
                });
            });

            productsContainer.innerHTML = cardsHtml;
        }

        // Call it initially
        loadProducts();

        // Filter logic
        document.getElementById("apply-filter").addEventListener("click", () => {
            const selected = Array.from(document.querySelectorAll("input[name='category']:checked")).map(el => el.value);
            const applied = document.getElementById("applied-filters");

            // Clear old filter tags
            applied.innerHTML = "";

            if (selected.length === 0) {
                applied.innerHTML = `<span class='text-gray-400'>None</span>`;
                
            } else {
                selected.forEach(filter => {
                    const tag = document.createElement("div");
                    tag.className = "flex items-center gap-2 border rounded-2xl px-3 py-1 text-sm border-gray-200 bg-gray-100";
                    tag.innerHTML = `<span>${filter}</span>
                                    <img src="/assets/icons/close.svg" alt="remove" class="w-4 h-4 cursor-pointer remove-filter">`;

                    tag.querySelector(".remove-filter").addEventListener("click", () => {
                        document.querySelector(`input[value='${filter}']`).checked = false;
                        tag.remove();
                        document.getElementById("apply-filter").click();
                    });

                    applied.appendChild(tag);
                });
            }

            // Show/hide products
            document.querySelectorAll(".product-card").forEach(card => {
                const cat = card.getAttribute("data-category");
                card.style.display = selected.length === 0 || selected.includes(cat) ? "flex" : "none";
            });

        });
    </script>


</body>
</html>