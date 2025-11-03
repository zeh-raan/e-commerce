# A full-fledged dynamic E-commerce website
Write a small description here!

## 👥 Authors
Below is listed all the people who worked on this project!

Name | Student ID
---|---
Boodun Abdur-Rahmaan | 2415832 
Azimekhan Zehraan | 2413539

## 📄 Project Overview
This is a full-fledged dynamic e-commerce website.
- Module: Internet Technologies and Web Services

The website includes basic e-commerce features such as:
- Product listing and search
- Shopping cart
- User login and signup

## 📦 Prerequisites
- PHP Version `8.2.12` or higher  
[Download PHP Here!](https://www.php.net/downloads.php)

- Node.js Version `22.19` or higher  
[Download Node.js Here!](https://nodejs.org/en/download/)

## 📂 Directory Structure

```text
e-commerce/
│
├───backend/
│   ├───api/  # Holds function handers
│   └───data/ # Holds data files
│
├───frontend/
│   ├───pages/ # Holds all pages
│   │
├───public/
│   ├───assets/       # Holds icons, images, video
│   ├───css/          # Holds CSS files
│   │   └───input.css 
│   ├───js/           # Holds Javascript functions
│   └───index.php     # Router file
```

## 🔌 Tech Stack
Below are the technologies used for this project!

Tech Stack| &nbsp;
---|---
**Frontend** | HTML5
&nbsp; | TailwindCSS *(through CLI)*
&nbsp; | JavaScript *(includes AJAX)*
**Backend**  | PHP
**Data Files** | XML
&nbsp; | JSON

## 💻 Setup & Usage
Follow these steps to get your development environment set up and operational:  

1. **Clone the Repository**
    ```bash
    git clone https://github.com/zeh-raan/e-commerce.git
    cd e-commerce
    ```

2. **Install Dependencies**
    ```bash
    npm install
    ```
3. **Builds CSS files using Tailwind**  
   ```bash
   npx tailwindcss -i public/css/input.css -o public/css/output.css --watch
   ```

4. **Starts PHP Server**  
   ```bash
   php -S localhost:8000 -t public
   ```

## 🗺️ How to Navigate
Below is listed the different links used to navigate the website.

1. Home Page
    * Can be accessed through `/`, `http://localhost:8000` and/or `http://localhost:8000/`

2. Catalog
    * Can be accessed through `/catalog` and/or `http://localhost:8000/catalog`

3. Specific Product Page
    * All products have their unique link, in the format `http://localhost:8000/product/{id}`
    * Buttons and Links are provided across the website to enable users to navigate to these pages

4. Cart Page
    * Can be accessed through `/cart` and/or `http://localhost:8000/cart`
    * This page is used to review your cart before checkout

5. Checkout Page
    * Can be accessed through `/cart` and/or `http://localhost:8000/checkout`  
    ***Note: *** **Users can still add to their cart and checkout without logging in because the system uses `localStorage` to track their cart!**

6. Signup/Login Page
    * Can be accessed through `/signup` and/or `http://localhost:8000/signup`  

7. Add Product Page
    * Can be accessed through `/product/add` and/or `http://localhost:8000/product/add`  
    * This page requires the user to be an **admin** and **logged in**!

8. Edit Product Page
    * Can be accessed through a unique link respective to the product being edited, in the format `http://localhost:8000/product/{id}/edit`
    * This page requires the user to be an **admin** and **logged in**!

9. Admin Dashboard Page
    * Can be accessed through `/dashboard` and/or `http://localhost:8000/dashboard`  
    * This page requires the user to be an **admin** and **logged in**!

10. Error Page
    * Any invalid link is redirected here!
    * All roads lead to Rome. 😃