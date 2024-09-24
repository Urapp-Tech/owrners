
# Owrners Freelancer Setup

## Requirements
- **PHP Version:** 8.0.2 and above
- **Composer Version:** 2.4.1
- **Updated Branch:** `main`

## Installation Steps

1. **Clone the Repository**  
   Clone the project from GitHub to your local machine:
   ```bash
   git clone "https://github.com/Laundrez/owrners.git"
   cd <project-directory>
   ```

2. **Vendor Directory**  
   No need to run `composer install` as the `vendor` folder is already committed.

3. **Database Setup**  
   Import the database from the `install` folder:
   ```bash
   mysql -u your_username -p your_database_name < install/database-[latest-date-of-export].sql
   ```

4. **Configure Environment**  
   Set up the `.env` file by copying from `.env.example`:
   ```bash
   cp .env.example .env
   ```

   Update the `.env` file with your environment settings:
   - **Database Configuration:**
     ```env
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```
   - **Pusher Settings (if used):**
     ```env
     PUSHER_APP_ID=your_pusher_app_id
     PUSHER_APP_KEY=your_pusher_app_key
     PUSHER_APP_SECRET=your_pusher_app_secret
     PUSHER_APP_CLUSTER=your_pusher_app_cluster
     ```

5. **Cache Clearing (if needed)**  
   If you encounter any issues related to caching, run the following commands to clear the cache:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Composer Autoload**  
   If you run into issues with missing classes, run:
   ```bash
   composer dumpautoload
   ```
   `Make Sure to connect database before running above command as if it was giving any database errors.`

7. **Database Migrations**  
   If you notice missing database fields, run the migrations:
   ```bash
   php artisan migrate
   ```

## Live Environment Setup

1. **Robots.txt**  
   For live deployments, make sure the `robots.txt` is correctly configured for SEO. If the file is blocking search engines, either remove it or adjust the rules:
   ```plaintext
   User-agent: *
   Allow: /
   ```

---

## Common Issues and Solutions

1. **Clear Cache**  
   If you're facing unexpected behavior, clearing the cache often resolves the issue:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. **Composer Issues**  
   If classes are missing or you encounter errors with autoloading, try running:
   ```bash
   composer dumpautoload
   ```
    `Make Sure to connect database before running above command as if it was giving any database errors.`
3. **Database Field Missing**  
   If you notice missing fields in the database, run the migration:
   ```bash
   php artisan migrate
   ```

---


