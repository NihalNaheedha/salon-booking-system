<div align="center">

# 💈 The Puttalam Men's Salon
### Web-Based Appointment Booking System

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

> A full-stack web application that allows customers to register, log in, and book grooming appointments online at The Puttalam Men's Salon — eliminating manual booking and reducing wait times.

</div>

---

## 📌 Table of Contents

- [About the Project](#-about-the-project)
- [Features](#-features)
- [Screenshots](#-screenshots)
- [Tech Stack](#-tech-stack)
- [Database Structure](#-database-structure)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
- [How to Use](#-how-to-use)
- [Developer](#-developer)

---

## 📖 About the Project

**The Puttalam Men's Salon Appointment Booking System** is a web-based platform developed as a final-year project for the Diploma in Information Technology at **Wayamba University of Sri Lanka**.

The system was built to replace manual appointment scheduling at a real local salon — *The Puttalam Men's Salon*, founded by Mr. Nasrulla in Puttalam, Sri Lanka. Customers can book appointments online, choose services, and manage their bookings — while the admin manages services and availability through a dedicated dashboard.

---

## ✨ Features

### 👤 Customer Side
- ✅ Register and log in securely (session-based)
- ✅ Browse available grooming services and prices
- ✅ Book appointments by selecting service, date, and time slot
- ✅ View all personal booked appointments
- ✅ Prevents double-booking (max 3 per slot)

### 🛠️ Admin Side
- ✅ Secure admin login with role-based access control
- ✅ Add, edit, and delete services (name, price, type)
- ✅ View all customer details and their appointments
- ✅ Block time slots to manage salon availability
- ✅ Auto-delete appointments when a slot is blocked
- ✅ Delete customer records

### 🌐 General
- ✅ Responsive design with background imagery
- ✅ Glassmorphism UI style
- ✅ Fixed navigation bar with login/logout toggle
- ✅ About Us and Contact pages

---

## 📸 Screenshots

> *(Add screenshots of your pages here after uploading to GitHub)*

| Page | Description |
|------|-------------|
| 🏠 Home | Welcome banner with Book Now button (logged-in users) |
| 🔐 Login / Register | Clean auth forms with validation |
| 📅 Booking | Service selector + date + time slot picker |
| 📋 My Appointments | Table of all bookings for logged-in customer |
| ⚙️ Admin Dashboard | Central hub for all admin actions |
| 🗂️ Manage Services | Add / Edit / Delete salon services |
| 👥 Customer Details | Full customer & appointment overview |
| 🕐 Manage Availability | Block specific time slots |

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Frontend | HTML5, CSS3, JavaScript |
| Backend | PHP (Procedural & OOP) |
| Database | MySQL (via MySQLi) |
| Server | Apache (XAMPP / WAMP) |
| Session | PHP Sessions |
| Styling | Custom CSS, Glassmorphism |

---

## 🗄️ Database Structure

**Database name:** `puttalamsalon`

### Tables

#### `customer`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Customer ID |
| name | VARCHAR | Full name |
| email | VARCHAR | Email (unique) |
| phone | VARCHAR | Phone number |
| password | VARCHAR | Plain text password |
| role | ENUM | `customer` or `admin` |

#### `services`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Service ID |
| service_name | VARCHAR | Name of the service |
| price | DECIMAL | Service price (Rs.) |
| service_type | VARCHAR | Category (e.g. Haircut, Beard) |

#### `appointments`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Appointment ID |
| customer_id | INT (FK) | References `customer.id` |
| service_id | INT (FK) | References `services.id` |
| booking_date | DATE | Appointment date |
| booking_time | TIME | Appointment time |

#### `availability`
| Column | Type | Description |
|--------|------|-------------|
| id | INT (PK, AI) | Slot ID |
| day | DATE | Date to block |
| start_time | TIME | Block start |
| end_time | TIME | Block end |
| status | VARCHAR | Always `closed` |

---

## 📁 Project Structure

```
puttalamsalon/
│
├── index.php               # Home page with booking button
├── about.php               # About the salon
├── contact.php             # Contact info
├── services.php            # Public services listing
│
├── login.php               # Login form (customer + admin)
├── register.php            # Customer registration
├── logout.php              # Session destroy + redirect
│
├── booking.php             # Appointment booking form (customer)
├── myappointments.php      # View own appointments (customer)
│
├── admindashboard.php      # Admin control panel
├── addservices.php         # Add / Edit / Delete services (admin)
├── cdetails.php            # View all customer + booking data (admin)
├── manageavailability.php  # Block/manage time slots (admin)
├── delete.php              # Delete customer record (admin)
│
├── db.php                  # Database connection file
│
├── f.png                   # Salon favicon / logo
└── n.jpg                   # Background image
```

---

## 🚀 Getting Started

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/) installed
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Edge)

### Installation Steps

**1. Clone the repository**
```bash
git clone https://github.com/YOUR-USERNAME/puttalamsalon.git
```

**2. Move to your server's web root**
```bash
# For XAMPP (Windows)
C:/xampp/htdocs/puttalamsalon/

# For XAMPP (Linux/Mac)
/opt/lampp/htdocs/puttalamsalon/
```

**3. Create the database**
- Open [phpMyAdmin](http://localhost/phpmyadmin)
- Create a new database named `puttalamsalon`
- Import the SQL file (if provided) **OR** create tables manually using the structure above

**4. Configure database connection**

Open `db.php` and confirm your settings:
```php
$dbserver   = 'localhost';
$dbuser     = 'root';
$dbuserpass = '';        // Add your MySQL password if set
$dbname     = 'puttalamsalon';
```

**5. Create an admin account**

Insert an admin record directly into the `customer` table via phpMyAdmin:
```sql
INSERT INTO customer (name, email, phone, password, role)
VALUES ('Admin', 'admin@salon.com', '0771234567', 'admin123', 'admin');
```

**6. Run the project**

Open your browser and go to:
```
http://localhost/puttalamsalon/
```

---

## 🧭 How to Use

### As a Customer
1. Go to the home page and click **Login** → **Register here**
2. Fill in your name, email, phone and password
3. Log in with your credentials
4. Click **Book Now** → choose service, date, and time
5. Click **My Appointments** to see all your bookings

### As an Admin
1. Log in using the admin credentials you inserted
2. You will be redirected to the **Admin Dashboard**
3. From there you can:
   - **Add / Edit / Delete Services**
   - **View Customer & Appointment Details**
   - **Block Time Slots** to manage availability

---

## 👩‍💻 Developer

<div align="center">

**Naheedha Nihal**
*Diploma in Information Technology (2025)*
*BSc in Information Technology — Wayamba University of Sri Lanka (In Progress)*

📧 mnfnaheedha@gmail.com
📞 +94 75 249 7973
📍 Puttalam, Sri Lanka

</div>

---

## 📄 License

This project was developed as an academic final-year project.
Feel free to use it for learning purposes with credit to the author.

---

<div align="center">

Made with ❤️ by **Naheedha Nihal** | Wayamba University of Sri Lanka

</div>
