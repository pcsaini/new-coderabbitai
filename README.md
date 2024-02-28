# Small Banking Application

---

## Table of contents

- [Introduction](#introduction)
- [Installation & Configuration](#installation--configuration)

## Introduction

`Small Banking Application` is a Banking Application Assignment, Some Features like deposit, withdraw and transfer amount.

## Installation & Configuration
To setup and run project please follow below steps
```shell
# Clone the project repo
git clone https://github.com/pcsaini/small-banking-application.git

cd small-banking-application


# Install Composer Dependencies
composer install

# Add .env file
cp .env.example .env

# Clear config cache
php artisan config:cache

# Migrate Database
php artisan migrate

# Run the application
php artisan serve
```

Now you can run the application on the url http://localhost:8000

Note: Please add database configuration in the `.env` file
