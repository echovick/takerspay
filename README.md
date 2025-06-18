# Takerspay

Takerspay is a modern web application built with Laravel and Livewire that facilitates cryptocurrency and gift card trading. The platform provides a secure and user-friendly environment for buying and selling digital assets.

## Features

-   **User Authentication & Authorization**

    -   Secure login and registration system
    -   Role-based access control (User and Admin roles)
    -   PIN-based transaction security

-   **Asset Trading**

    -   Cryptocurrency trading (Buy/Sell)
    -   Gift card trading with image upload support
    -   Real-time crypto price ticker
    -   Multiple wallet support (Fiat, Crypto, NUBAN)

-   **Order Management**

    -   Real-time order tracking
    -   Order history and status updates
    -   Automated order processing
    -   Receipt generation for transactions

-   **Admin Dashboard**

    -   User management
    -   Order management
    -   Wallet management
    -   Transaction monitoring
    -   Asset management
    -   Audit trails and reports

-   **Security Features**
    -   Secure file uploads
    -   Transaction verification system
    -   OTP verification
    -   Automated session management

## Technology Stack

-   **Backend Framework**: Laravel
-   **Frontend**: Livewire, Blade Templates
-   **Database**: MySQL
-   **File Storage**: Cloudinary
-   **PDF Generation**: DomPDF
-   **Authentication**: Laravel's built-in auth system

## Installation

1. Clone the repository:

```bash
git clone <repository-url>
cd takerspay-main
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Create and configure your environment file:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Run database migrations:

```bash
php artisan migrate
```

7. Start the development server:

```bash
php artisan serve
```

8. In a separate terminal, compile assets:

```bash
npm run dev
```

## Environment Configuration

Make sure to set up the following environment variables in your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CLOUDINARY_URL=your_cloudinary_url
CLOUDINARY_UPLOAD_PRESET=your_upload_preset
CLOUDINARY_NOTIFICATION_URL=your_notification_url
```

## Directory Structure

-   `app/` - Contains the core code of the application

    -   `Http/Controllers/` - Application controllers
    -   `Http/Livewire/` - Livewire components
    -   `Models/` - Eloquent models
    -   `Services/` - Business logic services
    -   `Policies/` - Authorization policies
    -   `Events/` - Event classes
    -   `Listeners/` - Event listeners

-   `resources/`

    -   `views/` - Blade templates
    -   `css/` - Stylesheets
    -   `js/` - JavaScript files

-   `routes/`

    -   `web.php` - Web routes definition

-   `database/`
    -   `migrations/` - Database migrations
    -   `factories/` - Model factories
    -   `seeders/` - Database seeders

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

[MIT License](LICENSE)

## Support

For support, please contact support@takerspay.com or visit our website at [takerspay.com](https://takerspay.com).
