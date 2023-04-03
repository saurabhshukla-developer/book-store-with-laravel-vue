
# Book Store With Laravel and Vue

This is a simple book store, built with Laravel, Vue.js, and Bootstrap 5. The store provides customers to search and filter through a collection of books based on multiple attributes, such as title, author, publication date, ISBN, and genre.

## Features:

- Browse a comprehensive list of books
- Search for specific books using various criteria
- Filter books based on multiple attributes
- View detailed book information, including cover image, description, author, genre, etc.
- Logged-in users can perform CRUD operations on books, including adding new books, updating book information, and deleting books from the store.

## Project Videos:
- [Project Setup Video](https://drive.google.com/file/d/134hZQHAVH6ji4P2ou61wQwc-H2ZmdODk/view?usp=drivesdk)
- [Project Demo Video](https://drive.google.com/file/d/13D-TLSrH_6_7OWB8ntSqi7RNGSXzwoNf/view?usp=drivesdk)

## Installation Steps

#### STEP 1: Clone Repository from Github.
Clone the repository from GitHub to your local machine.

#### STEP 2: Create a New Database
Create a new database for the Book Store project on your system.

#### STEP 3: Set Up Environment Variables
Copy the .env.example file to .env and modify the following lines in the .env file:

```bash
APP_URL=YOUR_APP_URL (without trailing slash)
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD
```

#### STEP 4: Install Dependencies
Run the following commands in the Laravel project folder 
```bash
composer install
php artisan key:generate
php artisan migrate
npm install
npm run build
```

#### Step 5: Start the Server
Start the development server by running the following command:
```bash
php artisan serve
```

You should now be able to access the Book Store at http://localhost:8000 in your web browser.
