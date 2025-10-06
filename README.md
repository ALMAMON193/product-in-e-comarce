<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="E-commerce Logo">
  </a>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Platform-Laravel%2010-red" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/Frontend-Livewire%20%26%20Tailwind-blue" alt="Frontend"></a>
  <a href="#"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>
</p>

---

## **About This Project**

This project is a **simplified e-commerce platform** built using **Laravel 10**, **Livewire**, and **Tailwind CSS**.  
It provides an **admin dashboard** to manage categories, subcategories, and products dynamically with **full CRUD operations**.  

Key highlights:

- Dynamic management of **Categories, Subcategories, and Products**  
- Real-time updates with **Livewire components**  
- Responsive and modern design with **Tailwind CSS**  
- Product filtering and search with **tags and categories**  
- Supports multiple product images and stock management  

---

## **Features**

### **1. Dashboard**
- Central hub for all platform operations  
- Provides **overview of categories, subcategories, and products**  
- Quick links to create, edit, or delete entities  

### **2. Category Management**
- Create, edit, and delete categories  
- Add **images, description, featured option, and sort order**  
- Categories act as a **parent for subcategories**  

### **3. Subcategory Management**
- Create, edit, and delete subcategories  
- Assign subcategories to **parent categories**  
- Organizes products under categories for better navigation  

### **4. Product Management**
- Create, edit, and delete products  
- Add **SKU, price, sale price, cost price, stock, status, images, and tags**  
- Assign products to **one or more subcategories**  
- Filter and search products by **category, subcategory, price, stock, or tags**  

### **5. CRUD & Workflow**
- Hierarchical structure: **Category → Subcategory → Product**  
- Livewire ensures **real-time updates** without page reload  
- Changes reflected immediately across dashboard and product views  

---

## **Working Flow**

1. **Admin logs in** → Access the **Dashboard**  
2. **Create Category** → Stored in `categories` table  
3. **Create Subcategory** → Assigned to category, stored in `sub_categories` table  
4. **Create Product** → Assigned to one or more subcategories, stored in `products` table  
5. **Manage Products** → Update, delete, or filter products; all updates are real-time  
6. **Frontend Display** → Products are accessible under assigned categories/subcategories  

**Summary:** Hierarchy is **Category → Subcategory → Product**, managed efficiently through a Livewire-powered dashboard.

---

## **Requirements**
- PHP >= 8.1  
- Composer  
- Laravel 10  
- MySQL  
- Node.js & npm  
- Git (optional, for cloning)  

---

## **Setup Instructions**

### **Option 1: Using Git Clone**
```bash
git clone <repository-url>
cd <repository-folder>
composer install
npm install
npm run dev
cp .env.example .env   # Linux/Mac
copy .env.example .env # Windows
php artisan key:generate
# Update .env with your database credentials
php artisan migrate
php artisan db:seed
php artisan serve
