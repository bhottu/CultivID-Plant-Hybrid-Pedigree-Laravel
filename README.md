
# CultivID — Plant Hybrid Pedigree Platform

<a href="https://saweria.co/natenasution" target="_blank">
    <img src="https://github.com/bhottu/nate-social-media/assets/35356275/b0a6053d-4033-467f-8578-e99abed81710" alt="Saweria" width="200" />
</a>

**CultivID** is a Laravel-based plant database and community platform designed for ornamental plant enthusiasts, collectors, breeders, and hybrid plant developers.

The platform provides a centralized environment to document plant information, record hybrid pedigrees, submit plant data for review, discover plants, interact with other enthusiasts, and participate in a plant-focused marketplace.

CultivID aims to make plant identification, hybrid documentation, and plant community collaboration more accessible through a single digital platform.

---

## Overview

Plant hybridization and ornamental plant collecting often involve scattered information, undocumented parentage, and limited access to reliable plant records.

CultivID was developed to help address these challenges by providing tools for:

- Plant database management.
- Hybrid plant pedigree documentation.
- Plant submission and verification workflows.
- Community interaction and knowledge sharing.
- Plant discovery and marketplace activities.
- Digital pedigree documentation.

The platform combines plant data management with social and marketplace functionality, creating an ecosystem for the ornamental plant community.

## Key Features

### 1. Plant Database

A centralized database for discovering and documenting plants.

Features include:

- Browse plant records.
- View individual plant details.
- Submit new plant information.
- Edit and manage submitted plant records.
- Browse plant collections.
- Search and discover plants.
- Public plant detail pages.

### 2. Plant Hybrid Pedigree

Documentation and management of plant hybrid information.

The platform includes:

- Plant submission workflows.
- Parentage and hybrid documentation.
- Submission review and approval.
- Pedigree preview.
- Downloadable pedigree PDF documentation.
- Submission status management.

This functionality helps preserve plant lineage information and provides a structured way to document hybrid plants.

### 3. Plant Submission & Verification

A submission workflow for community-contributed plant information.

Features include:

- Member plant submissions.
- Submission management.
- Administrative review.
- Approval and rejection workflows.
- Rejection reason documentation.
- Submission appeals.
- Administrative submission management.

The review process helps maintain the quality and consistency of information stored in the database.

### 4. Community & Social Features

CultivID also provides community functionality for plant enthusiasts.

Features include:

- User profiles.
- Community posts and discussions.
- Create and manage posts.
- Like posts.
- Comment on posts.
- Share posts.
- Follow other users.
- User-specific discussion feeds.
- Search functionality.

### 5. Plant Marketplace

A marketplace for discovering and listing ornamental plants.

Features include:

- Product listings.
- Product categories.
- Product detail pages.
- User-based product listings.
- Product management.
- Discounted products.
- Sold-out status management.
- Shopping cart.
- Checkout workflow.

### 6. User Accounts & Authentication

Account management and authentication functionality.

Features include:

- User registration.
- Login and logout.
- Google authentication.
- Password recovery.
- Password reset.
- User profiles.
- Profile management.

### 7. Wallet & Transactions

The application includes transaction-related functionality.

Features include:

- User wallet.
- Withdrawal requests.
- Transaction records.
- Certificate purchases.
- Payment-related workflows.
- Administrative transaction management.
- Withdrawal administration.

### 8. Admin Dashboard

Administrative functionality for managing the platform.

Features include:

- Dashboard statistics.
- User management.
- Plant submission management.
- Plant submission review.
- Product management.
- Category management.
- Community post moderation.
- Payment and transaction management.
- Withdrawal management.
- Currency management.
- Platform settings.
- Google integration settings.
- Google AdSense settings.
- API and license settings.

### 9. SEO & Sitemap

The application includes sitemap generation using Spatie Laravel Sitemap.

Available sitemap endpoints:

- `/sitemap.xml`
- `/sitemap-plants.xml`
- `/sitemap-discuss.xml`
- `/sitemap-market.xml`
- `/sitemap-pages.xml`

Plant sitemap generation includes approved plant submissions.

---

## Technology Stack

### Backend

- PHP 8.2+
- Laravel 11
- MySQL
- Laravel Sanctum
- Laravel Socialite

### Frontend

- Blade Templates
- Tailwind CSS 3
- Laravel Mix 6
- JavaScript
- Axios
- Font Awesome 6

### Additional Libraries

| Package | Purpose |
|---|---|
| barryvdh/laravel-dompdf | PDF generation |
| consoletvs/charts | Data visualization |
| guzzlehttp/guzzle | HTTP requests |
| intervention/image | Image processing |
| laravel/sanctum | API authentication |
| laravel/socialite | Social authentication |
| simple-html-dom | HTML parsing |
| spatie/laravel-sitemap | Sitemap generation |

### Development Tools

- Composer
- Node.js
- NPM
- Laravel Mix
- Pest PHP

---

## Requirements

Before installing CultivID, make sure your environment has:

- PHP 8.2 or newer.
- Composer.
- MySQL 8.0+ or a compatible MySQL/MariaDB server.
- Node.js and NPM.
- PHP extensions required by Laravel.
- PHP GD extension for image processing where required.

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/bhottu/CultivID-Plant-Hybrid-Pedigree-Laravel.git

cd CultivID-Plant-Hybrid-Pedigree-Laravel
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

For Windows:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 5. Configure Database

Create a MySQL database for CultivID.

Update the following values in your `.env` file:

```env
APP_NAME=CultivID
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cultivid
DB_USERNAME=root
DB_PASSWORD=
```

Make sure the database credentials match your local environment.

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Create Storage Symlink

```bash
php artisan storage:link
```

### 8. Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run prod
```

### 9. Start the Development Server

```bash
php artisan serve
```

Open the application:

```text
http://127.0.0.1:8000
```

---

## Google Authentication Configuration

CultivID includes Google authentication through Laravel Socialite.

Configure your Google OAuth credentials in `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT=https://your-domain.com/auth/google/callback
```

Register the callback URL in your Google Cloud Console OAuth configuration.

The callback route is:

```text
/auth/google/callback
```

---

## Environment Configuration

Some additional environment variables are available in `.env.example`.

These include:

- Session configuration.
- Queue configuration.
- Cache configuration.
- Mail configuration.
- Redis configuration.
- Filesystem configuration.
- AWS-compatible storage configuration.

Configure these services according to your deployment environment.

---

## Project Structure

The application follows the standard Laravel project structure.

```text
CultivID/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   └── Auth/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
│
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

---

## Main Application Routes

The following are some of the main application routes.

| Route | Description |
|---|---|
| `/` | Main application page |
| `/plants` | Plant database |
| `/plant-submissions` | Plant submissions |
| `/plant-submissions/{id}` | Public submission detail |
| `/discuss` | Community discussions |
| `/profile/{user}` | User profile |
| `/market` | Plant marketplace |
| `/products` | Product listings |
| `/categories` | Product categories |
| `/wallet` | User wallet |
| `/notifications` | User notifications |
| `/admin` | Administration dashboard |

Some routes require authentication or administrator privileges.

---

## Testing

The project uses Pest PHP for automated testing.

Run the test suite:

```bash
php artisan test
```

Or:

```bash
./vendor/bin/pest
```

---

## Development Notes

A few things to consider when working with this repository:

1. Always review existing migrations before introducing database changes.
2. Preserve existing plant submission and review workflows.
3. Make sure changes to plant pedigree data do not break PDF generation.
4. Validate uploaded images and files.
5. Protect administrative routes with appropriate authorization.
6. Keep sensitive credentials inside environment variables.
7. Test authentication, marketplace, and transaction workflows after significant changes.

---

## Security

If you discover a security vulnerability, avoid publishing sensitive exploit details in public issues.

Please contact the repository maintainer privately.

Never commit:

- `.env` files.
- API keys.
- OAuth client secrets.
- Database credentials.
- Private payment credentials.
- Production access credentials.

---

## Contributing

Contributions, bug reports, and suggestions are welcome.

A suggested contribution workflow:

1. Fork the repository.
2. Create a feature branch.
3. Implement your changes.
4. Test your changes.
5. Submit a pull request with a clear description.

For significant changes, please discuss the proposed implementation before submitting a pull request.

---

## Project Status

CultivID is an evolving project.

The repository contains an established Laravel application with plant database, hybrid pedigree, community, marketplace, and administrative functionality.

Some integrations and workflows may require additional configuration depending on the deployment environment.

---

## License

No explicit project license has been confirmed in this repository.

Please contact the repository maintainer before redistributing or using the project commercially.

---

## Acknowledgements

CultivID is built for the ornamental plant community, plant collectors, breeders, and enthusiasts who believe that plant knowledge and hybrid documentation deserve to be preserved and shared.

**CultivID — Growing Plant Knowledge Together.**
