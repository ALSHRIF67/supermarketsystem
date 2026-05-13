# Supermarket Management System (MarketOS) 🛒

A comprehensive, high-fidelity ERP solution built with **Laravel 11**, designed for modern supermarket and pharmacy management. This system features the **MarketOS** UI design, providing a premium, responsive experience across all devices.

---

## 🌟 Key Features

- **🚀 Advanced POS System**: Real-time point of sale with multi-payment support (Cash, Card, Credit).
- **📦 Inventory & Logistics**: Multi-warehouse stock tracking, replenishment, and internal transfers.
- **📊 Strategic Analytics**: Real-time reports for revenue, expenses, profit, and top-selling products.
- **👥 CRM & SRM**: Comprehensive database for Customers and Suppliers with historical tracking.
- **💸 Expense Management**: Detailed tracking of operational costs with category-based filtering.
- **🛡️ Security**: Role-based access control and secure transaction logging.

---

## 🎨 MarketOS UI Modernization

The system has been fully refactored to follow the **MarketOS** design philosophy:

- **📱 Dual-Layout Responsive System**: All management tables automatically convert into sleek data cards on mobile devices, ensuring **Zero Horizontal Scrolling**.
- **💎 Premium Aesthetics**: A refined **Emerald/Slate/Rose** color palette optimized for business readability and visual hierarchy.
- **👆 Touch-Optimized**: High-density typography and large touch targets designed for tablets and smartphones.
- **⚡ Micro-Animations**: Smooth transitions and interactive elements for a superior user experience.

---

## 🛠 Tech Stack

- **Framework**: [Laravel 11](https://laravel.com)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com), [Livewire](https://livewire.laravel.com)
- **Database**: MySQL / PostgreSQL
- **Design System**: MarketOS Premium UI

---

## 🚀 Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/ALSHRIF67/supermarketsystem.git
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**:
   Update your `.env` with your database credentials, then run:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**:
   ```bash
   npm run dev
   ```

6. **Serve the Application**:
   ```bash
   php artisan serve
   ```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---
*Built with ❤️ for advanced business management.*
