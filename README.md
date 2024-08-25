# Visitor Management System

    Visitor Management System is a web application built with Laravel Breeze and Inertia.js.

## Introduction

    This is implemented by using Laravel Breeze and Inertia.js.
    This README provides instructions on setting up and running the project using Docker.

## Prerequisites

-   [Docker](https://www.docker.com/get-started)
-   [Docker Compose](https://docs.docker.com/compose/install/)

## Development Environment Setup

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/YeeNweWynn/visitor-management-system.git
    cd visitor-management-system
    ```

2. **Create a .env File:**
   Copy the `.env.example` file to `.env` and modify it according to your environment:

    ```bash
    cp .env.example .env

    ```

    If you use the docker environment which contains together with app, set the database configuration as follows.

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=visitor_management
    DB_USERNAME=root
    DB_PASSWORD=root

3. **Build and Start Docker Containers:**

    ```bash
    docker-compose up -d
    ```

4. **Setup Laravel:**

    ```bash
    docker-compose exec laravel bash
    composer install
    php artisan migrate
    php artisan db:seed
    php artisan key:generate

    ```

5. **Install Node.js Dependencies:**

    ```bash
    docker-compose exec node bash
    npm install
    npm run dev
    ```

6. **Accessing the Application:**

    Open [http://localhost:8080](http://localhost:8080) in your web browser.

## Troubleshooting

-   **Database Connection:**

    Verify `.env` file settings.

-   **Rebuild Containers:**

    ```bash
    docker-compose down
    docker-compose up -d
    ```

## Implemented Scenarios

 - **Visitor Creation**:  
  Staff can create new visitor records with details such as name, email, phone, address, and postal code.

- **Visitor Editing**:  
  Staff can edit existing visitor records to update information including name, email, phone, address, and postal code.

- **Visitor Check-In**:  
  Staff can check in visitors by providing check-in type, purpose, and vehicle number (if applicable). If a visitor is already checked in and has not checked out, they cannot check in again.

- **Visitor Check-Out**:  
  Staff can process the check-out of visitors.

- **Visitor Search**:  
  Staff can search for specific visitors using various criteria such as name, email, or phone number, allowing for efficient access to visitor records.

- **Check-In Search**:  
  Staff can search for specific check-ins using criteria such as email, phone number, check-in date, check-out date, or status, enabling quick retrieval of check-in records.

- **Dashboard**:  
  The dashboard displays all check-in data and includes filtering options by check-in date, check-out date, status, email, phone, and purpose of visit. It also allows staff to check out visitors directly from the dashboard.
