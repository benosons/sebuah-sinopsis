# Core Laravel Project

This is a core Laravel project with user management, roles, admin CRUD, user registration, and password reset using SHA256.

## Prerequisites

- PHP (version compatible with Laravel 8, e.g., PHP 7.4 or PHP 8.0)
- Composer
- Node.js & npm
- MySQL

## Installation

1.  **Clone the repository:**

    ```bash
    git clone <your-repository-url>
    cd core-laravel
    ```

2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4.  **Copy the environment file:**

    ```bash
    cp .env.example .env
    ```

5.  **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Configure your database:**

    Open the `.env` file and update the database credentials:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=core_laravel_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Create the database:**

    Ensure you have a MySQL database named `core_laravel_db`. You can create it manually or via the MySQL client:

    ```bash
    mysql -u your_username -p -e "CREATE DATABASE IF NOT EXISTS core_laravel_db;"
    ```

8.  **Run database migrations and seed the admin user:**

    ```bash
    php artisan migrate --seed
    ```
    This will create all necessary tables and an initial admin user with:
    -   **Email:** `admin@example.com`
    -   **Password:** `password`

9.  **Compile assets:**

    ```bash
    npm run dev
    ```

## Running the application

1.  **Start the Laravel development server:**

    ```bash
    php artisan serve
    ```

2.  **Access the application:**

    Open your web browser and navigate to `http://127.0.0.1:8000` (or the address shown in your terminal).

## Admin Panel Access

-   Log in with the admin credentials provided in step 8.
-   You can access user and role management from the navigation links.

## Password Reset (SHA256)

The password reset functionality uses SHA256 for hashing tokens. If you trigger a password reset for a user, the email will contain a link with an SHA256 hashed token.

