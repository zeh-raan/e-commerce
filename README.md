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
├───index.php # Router
│
├───backend/
│   ├───api/  # Holds function handers
│   └───data/ # Holds data files
│
└───frontend/
    ├───assets/
    │   ├───icons/
    │   └───images/
    │
    ├───style/ # Holds CSS files (will be used to make css/)
    └───ts/    # TypeScript files here!
```

## 🔌 Tech Stack
Below are the technologies used for this project!

Tech Stack| &nbsp;
---|---
**Frontend** | HTML5
&nbsp; | TailwindCSS *(through CLI)*
&nbsp; | TypeScript *(includes AJAX)*
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
    cd frontend
    npm install
    ```

3. **Build JS Files**  
   *This can be done either from root or within `frontend/`*

    ```bash
    cd ..
    tsc -p frontend
    ```

4. **Starts PHP Server**  
   *This should be done from root!*

   ```bash
   php -S localhost:8000
   ```

## ➕ Other Instructions
*We should consider how to implement the instructions below with the instructions above!*

5. cd to `frontend` folder:
6. npm init -y # initialize package.json
7. npm install tailwindcss @tailwindcss/cli # install tailwindcss CLI
8. npx @tailwindcss/cli -i ./style/input.css -o ./css/output.css --watch # build tailwindcss
9.  ```<link rel="stylesheet" href="./css/output.css">``` # include in relevant HTML pages
