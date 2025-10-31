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
│   ├───assets/
│   │   ├───icons/
│   │   └───images/
│   │
│   ├───css/ # Holds CSS files
│   │   └───input.css 
│   │
│   │
│   └───index.php # main
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