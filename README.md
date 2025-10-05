# 🛒 E-Commerce Inventory & Invoice Management System (Laravel 9)

A role-based back-end web application developed as part of the **LnT Final Project**, designed to manage product inventory, handle customer orders, and generate automated invoices.  
The system supports two main roles — **Admin** and **User** — with distinct permissions and secure access control through Laravel middleware.

---

## 📌 Problem Definition

Businesses that manage product inventories and sales often face challenges in maintaining organized data, ensuring accurate stock tracking, and generating consistent invoices. Manual processes can result in data redundancy, inconsistent pricing, and limited control over user access.

To address these issues, a **role-based back-end system** was developed to handle product management, order processing, and invoice generation efficiently, while maintaining secure authentication and authorization between administrators and users.

---

## 💡 Solutions

- Developed a **role-based web application** using **Laravel 9** and **MySQL**.  
- Implemented **middleware** to separate access between Admin (CRUD operations) and User (catalog & invoices).  
- Added **validation rules** for product data, user registration, and order processing.  
- Designed **invoice generation** including auto-generated invoice numbers, subtotal & total calculation, and shipping details.  
- Implemented **seeder & factory** for populating dummy data for users, admins, categories, and products.

---

## ⚙️ Features

### 🔐 Authentication & Authorization
- User registration and login system.
- Manual admin registration via database.
- Middleware protection for restricted pages (Admin CRUD access only).

### 📦 Product Management
- Full **CRUD operations** for Admin.
- Product–Category relationship.
- Image upload and validation for product data.
- Automatic stock validation when items are out of stock.

### 🧾 Invoice System
- Add items to cart and generate invoices automatically.
- Auto-generated invoice numbers.
- Quantity adjustment, subtotal, and total calculation.
- Shipping details (address, postal code validation).
- Data persistence in database.

### ✅ Validation Rules
- Name, email, password, and phone number validation.
- Product and stock input validation.
- Redirect unauthorized users from restricted routes.

### 🗃️ Database Design
Structured relational schema including:
- `users`
- `admins`
- `categories`
- `products`
- `invoices`

---

## 🧰 Tech Stack

| Component | Technology |
|------------|-------------|
| **Framework** | Laravel 9 |
| **Database** | MySQL |
| **Frontend Scaffolding** | Blade Templates |
| **Data Generation** | Seeder & Factory |
| **Version Control** | GitHub |

---

## 🧪 Development Process

**Timeline:** 2 Weeks  
**Development Steps:**
1. Database design and migration setup.  
2. Implementation of authentication and role-based middleware.  
3. CRUD functionality for product and category management.  
4. Invoice generation and validation logic.  
5. Seeder and factory setup for dummy data.  
6. Manual and feature testing for all modules.

---

## 🚀 Installation & Setup

1. **Clone Repository**
   ```bash
   git clone https://github.com/jazzlynamelia/BackendFinalProject
   cd BackendFinalProject
   ```
2. **Install Dependencies**
   ```bash
   composer install
   npm install
   npm run dev
   ```
3. **Set Environment Variables**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **Configure Database**

   Update your `.env` file with database credentials:
   ```ini
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```
6. **Start the Development Server**
   ```bash
   php artisan serve
   ```

---

## 👤 Roles Overview

| **Role** | **Access Level** | **Description** |
|-----------|------------------|-----------------|
| **Admin** | Full Access | Manage CRUD operations for products, categories, and stock. |
| **User**  | Limited Access | View product catalog, add items to cart, and generate invoices. |
