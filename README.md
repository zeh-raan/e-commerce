# A full-fledged dynamic E-commerce website

## Authors
Boodun Abdur-Rahmaan - 2415832 
Azimekhan Zehraan    - 2413539

Module: Internet Technologies and Web Services

## Project Overview
This is a full-fledged dynamic e-commerce website.

The website includes basic e-commerce features such as:
- Product listing and search
- Shopping cart
- User login and signup

## Folder Structure

www/e-commerce/
│── assets/
│   ├── images/
│   └── icons/
│
│── backend/          # (PHP)
│
│── data/             # (JSON/XML)
│
│── frontend/         # (HTML, TailwindCSS, TypeScript)
│   ├── index.html
│   ├── css/
│   │   └── input.css
│   │   └── output.css
│   └── ts/
│   
│── README.md

## Tech Stack

- **Frontend  :** HTML, Tailwindcss CLI, TypeScript, AJAX, DOM
- **Backend   :** PHP
- **Database  :** MySQL
- **Data Files:** XML, JSON

## Setup instructions

### Front-End

1. cd to `frontend` folder:
npm init -y                                                        # initialize package.json
npm install tailwindcss @tailwindcss/cli                           # install tailwindcss CLI
npx @tailwindcss/cli -i ./css/input.css -o ./css/output.css --watch # build tailwindcss
<link rel="stylesheet" href="./css/output.css"> include in relevant HTML pages