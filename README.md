# 🛒 Laravel Product & Invoice Management System

This is a backend-focused web application built with Laravel that features two user roles: **Admin** and **User**.

Admins can manage product data including categories, prices, stock, and images. Users can browse products, add items to an invoice (cart), and generate a printable invoice with auto-generated numbers and total price calculations.

---

## ✨ Features

- Authentication & registration with role-based access control
- Middleware to restrict access based on user roles (Admin/User)
- Admin:
  - Manage product data (CRUD): name, category, price, stock, image
- User:
  - Browse and view product listings
  - Add products to invoice (cart system)
  - Generate printable invoice with auto-generated invoice number, subtotal, and total price
- Validation based on business rules
- Stock checking to prevent purchasing out-of-stock items
- Seeder and factory for initial data (users, admins, categories, products)
