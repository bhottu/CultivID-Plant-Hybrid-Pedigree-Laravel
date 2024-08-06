# Mingle v1.0.0

### How to Install the Mingle Project

#### Requirements

Ensure that your server meets the following requirements:

- **PHP:** Version 8.2 or higher
- **Database:** MySQL, PostgreSQL, SQLite, or SQL Server
- **Web Server:** Apache or Nginx
- **Composer:** Dependency manager for PHP
- **Node.js & NPM:** For managing front-end assets



### Installation Steps for Your Project

1. **Download and Extract the Project:**
   Download the zip file of the project and extract it to your chosen directory.

2. **Navigate to the Project Directory:**
   Change to the project directory:

   ```bash
   cd name-of-project-directory
   ```

3. **Install PHP Dependencies:**
   Install the PHP dependencies defined in `composer.json`:

   ```bash
   composer install
   ```

4. **Install Node.js Dependencies:**
   Install the Node.js dependencies defined in `package.json`:

   ```bash
   npm install
   ```

5. **Run Database Migrations:**
   Apply the database migrations to set up the database schema:

   ```bash
   php artisan migrate
   ```

6. **Seed the Database:**
   Populate the database with initial data using database seeding:

   ```bash
   php artisan db:seed
   ```

7. **Generate Application Key:**
   Generate a new application key for your Laravel application:

   ```bash
   php artisan key:generate
   ```

8. **Create Storage Symbolic Link:**
   Create a symbolic link for the storage directory to make storage files accessible:

   ```bash
   php artisan storage:link
   ```

9. **Modify the Service Provider:**
   Go to `app/Providers/AppServiceProvider.php` and remove the comments by deleting `//`:

   - Open `app/Providers/AppServiceProvider.php` in your code editor.
   - Locate the lines of code with `//` and remove these comments.

10. **Compile Assets:**
    Compile your assets for development or production:

    - For development:

      ```bash
      npm run dev
      ```

    - For production:

      ```bash
      npm run prod
      ```

11. **Serve the Application:**
    Start the Laravel development server to serve your application:

    ```bash
    php artisan serve
    ```

12. **Reload Your Website:**
    Open your web browser and reload your website at `http://localhost:8000` (or the URL provided by the `php artisan serve` command) to see your application in action.

---

These steps should help you set up and run your Laravel project smoothly. Let me know if you need any more help!
Support :
mingleteam777@gmail.com

---
### OTHER SETTINGS FOR WEBSITE
---
### Google Login Setup

- **Open Google Cloud Console.**
- In the left menu, navigate to **APIs & Services > Credentials**.
- Select an existing **OAuth 2.0 Client ID** or create a new one.
- In the **Authorized redirect URIs** section, add:
  ```
  http://your-website.com/auth/google/callback
  ```
- Copy the **Client ID** and **Client Secret**.
- Go to the admin page, select the **Google Settings** menu, and paste the **Client ID** and **Client Secret** you just copied.

---
### Email Configuration 

- **Open the `.env` file.**
- Locate the section:

  ```dotenv
  MAIL_MAILER=log
  MAIL_HOST=127.0.0.1
  MAIL_PORT=2525
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS="hello@example.com"
  MAIL_FROM_NAME="${APP_NAME}"
  ```

- **Update it with your email configuration:**

  ```dotenv
  MAIL_MAILER=smtp
  MAIL_HOST=your-mail-host
  MAIL_PORT=your-mail-port
  MAIL_USERNAME=your-mail-username
  MAIL_PASSWORD=your-mail-password
  MAIL_ENCRYPTION=tls  # or 'ssl' if required
  MAIL_FROM_ADDRESS="your-email@example.com"
  MAIL_FROM_NAME="Your Name or Company"
  ```

Replace `your-mail-host`, `your-mail-port`, `your-mail-username`, `your-mail-password`, and other placeholders with your actual email configuration details.
