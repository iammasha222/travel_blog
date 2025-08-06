# travel_blog
A simple blog application built with PHP and MySQL.

## Features

- User authentication (login/logout)
- Add, edit, delete articles
- Articles loaded from CSV and stored in MySQL database
- Tag filtering
- Access control: unpublished articles visible only to logged-in authors

## Requirements

- PHP 7.4 or higher
- MySQL or MariaDB
- Web server (Apache, Nginx, or PHP built-in server)
- Composer (optional, if you add dependencies)

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/your-username/my-blog.git
cd my-blog
````

### 2. Setup database

Create a MySQL database named "blog".

Import the SQL schema and sample data from the blog.sql file:

mysql -u root -p blog < blog.sql

### 3.Configure database connection

Edit the database connection settings in src/lib/functions.php

### 4. Run the project


## Notes

The CSV file (assets/csv/blog-artikel_db.csv) is used to import initial articles.

Only logged-in users can see drafts and unpublished articles.

Use the login page to authenticate. All data you can find in database.
