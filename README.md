# Project Management System

This is the repository for the machine test code submission. Below are the steps to set up the project locally.

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository:**

   ```bash
   git clone <repository_url>
Replace <repository_url> with the actual URL of your Git repository (e.g., https://github.com/your-username/your-repo.git).

Navigate to the project directory:

Bash

cd <project_directory>
Replace <project_directory> with the name of the directory created after cloning (usually the same as the repository name).

Install Composer dependencies:

Bash

composer install
This command will install all the required PHP packages defined in the composer.json file.

Copy the .env file:

Bash

cp .env.example .env
This creates a copy of the example environment file.

Generate an application key:

Bash

php artisan key:generate
This command generates a unique application key and sets it in your .env file.

Configure the database:

Open the .env file and configure your database connection details:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
Replace the placeholders with your actual database credentials.

Run database migrations:

Bash

php artisan migrate
This command will create the database tables based on your migrations.

Seed the database (if necessary):

If you have seeders to populate the database with initial data, run:

Bash

php artisan db:seed
Start the development server (optional):

If your project is a web application, you can start the development server:

Bash

php artisan serve
This will start a local development server, usually accessible at http://127.0.0.1:8000.
