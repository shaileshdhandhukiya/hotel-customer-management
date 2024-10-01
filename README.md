# Customer Management System

## Overview

This project is a Customer Management System built using **Laravel 10** for the backend and **React** for the frontend. The system allows for the management of customer data, including creating, reading, updating, and deleting customer records, while providing role-based access control for admin users.

## Features

- User authentication with role-based access (Admin and User)
- CRUD operations for managing customers
- Subscription management
- User dashboard with analytics
- File upload for customer ID cards
- Responsive UI built with Tailwind CSS
- Notification alerts for actions (success/error)

## Technologies Used

- **Backend:** Laravel 10
- **Frontend:** React
- **Database:** MySQL
- **Authentication:** Laravel Passport
- **CSS Framework:** Tailwind CSS

## Requirements

- PHP >= 8.1
- Composer
- Node.js and npm
- MySQL

## Installation

1. **Clone the repository:**

   <code>git clone https://github.com/yourusername/customer-management-system.git</code>

2. **Navigate to the project directory:**

   <code>cd customer-management-system</code>

3. **Install backend dependencies:**

   <code>composer install</code>

4. **Set up your `.env` file:**

   Copy the `.env.example` file to `.env` and configure your database and application settings.

   <code>cp .env.example .env</code>

5. **Generate the application key:**

   <code>php artisan key:generate</code>

6. **Run migrations:**

   <code>php artisan migrate</code>

7. **Install frontend dependencies:**

   Navigate to the frontend directory (if separate) and run:

   <code>npm install</code>

8. **Start the development server:**

   For Laravel:

   <code>php artisan serve</code>

   For React:

   <code>npm start</code>

