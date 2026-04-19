# DSSM - Daily Sales and Stock-In Management System

A production-ready Laravel web application for managing thrift shop operations.

## Features

- **Stock-In Module**: Record bale purchases, break into items, assign categories and prices
- **Sales Module**: Create transactions, add multiple items, auto-compute totals
- **Inventory Module**: Track item availability (Available, Sold, Reserved)
- **Reports**: Daily sales summary, inventory status, transaction receipts

## Tech Stack

- Backend: Laravel 12
- Authentication: Laravel Fortify
- Frontend: Bootstrap 5 (Blade templates)
- Database: MySQL

## Setup Instructions

1. **Database Setup**

   Create the database:
   ```sql
   CREATE DATABASE dssmsystem;
   ```

   Or use the provided SQL schema:
   ```bash
   mysql -u root -p dssmsystem < database/dssm_schema.sql
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Seed Sample Data**
   ```bash
   php artisan db:seed
   ```

6. **Start Server**
   ```bash
   php artisan serve
   ```

## Login Credentials

- **Employee ID**: Select any from dropdown (EMP001, EMP002, EMP003, EMP004)
- **Password**: password123

## Demo Employees

| Employee ID | Name | Position |
|-----------|------|---------|
| EMP001 | Maria Santos | Cashier |
| EMP002 | John Rivera | Cashier |
| EMP003 | Ana Garcia | Manager |
| EMP004 | Carlos Mendoza | Stock Keeper |

## Key Routes

| Route | Description |
|-------|------------|
| /login | Login page |
| /dashboard | Main dashboard |
| /stock-in | Stock-in management |
| /sales | Sales transactions |
| /inventory | Inventory tracking |
| /reports/daily-sales | Daily sales report |
| /reports/inventory-status | Inventory report |

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── DashboardController.php
│       ├── StockInController.php
│       ├── SalesController.php
│       ├── InventoryController.php
│       └── ReportsController.php
└── Models/
    ├── User.php
    ├── Supplier.php
    ├── Bale.php
    ├── Item.php
    ├── Category.php
    ├── Status.php
    ├── Transaction.php
    └── TransactionItem.php

database/
├── migrations/
│   ├── 2026_04_20_000001_create_suppliers_table.php
│   ├── 2026_04_20_000002_create_categories_table.php
│   ├── 2026_04_20_000003_create_statuses_table.php
│   ├── 2026_04_20_000004_create_bales_table.php
│   ├── 2026_04_20_000005_create_items_table.php
│   ├── 2026_04_20_000006_create_transactions_table.php
│   └── 2026_04_20_000007_create_transaction_items_table.php
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── UserSeeder.php
│   ├── SupplierSeeder.php
│   ├── CategorySeeder.php
│   └── StatusSeeder.php
└── dsssm_schema.sql

resources/views/
├── layouts/app.blade.php
├── auth/login.blade.php
├── dashboard.blade.php
├── stock-in/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── sales/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── show.blade.php
├── inventory/
│   ├── index.blade.php
│   └── show.blade.php
└── reports/
    ├── daily-sales.blade.php
    ├── inventory-status.blade.php
    └── receipt.blade.php
```

## Database Schema (3NF)

- **Suppliers** → many **Bales**
- **Bales** → many **Items**
- **Items** belongs to **Category** & **Status**
- **Transactions** → many **Items** (via TransactionItem pivot table)
- Inventory automatically deducted when items are sold

## UI Specifications

The login page uses the exact two-column split-screen layout:
- Left: Dark blue gradient branding panel (60%)
- Right: Light gray login form (40%)

All views use Bootstrap 5 styling with custom sidebar navigation.