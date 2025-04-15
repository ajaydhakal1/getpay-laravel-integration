<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Installation
To install and set up the Laravel GetPay Integration app, follow these steps:

1. Clone the repository to your local machine:
    ```
    git clone https://github.com/ajaydhakal1/getpay-laravel-integration
    ```

2. Navigate to the project directory:
    ```
    cd getpay-laravel-integration
    ```

3. Install the project dependencies using Composer:
    ```
    composer install
    ```

4. Install node packages and build
    ```
    npm install
    npm run build
    ```

5. Create a copy of the `.env.example` file and rename it to `.env`:
    ```
    cp .env.example .env
    ```

6. Generate an application key:
    ```
    php artisan key:generate
    ```

7. Configure the database connection in the `.env` file. Update the following lines with your database credentials:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel12
    DB_USERNAME=your-username
    DB_PASSWORD=your-password
    ```

7. Run the database migrations to create the necessary tables:
    ```
    php artisan migrate
    ```

8. Start the development server:
    ```
    php artisan serve
    ```

9. Open your web browser and visit `http://localhost:8000` to access the Laravel GetPay Integration App.

That's it! You have successfully installed and set up the Laravel GetPay Integration. Happy coding!

