# Digital Services

## Introduction

This repo contains the code for Buisness Listing Services.

## Installation

* Clone Repository:

```bash
git clone git@github.com:markowitz/business-directory-service.git
```

* Change directory to the repository folder

```bash
cd business-directory-services
```

* Install Packages

```bash
composer install
```

* Duplicate `.env.example`

```bash
cp .env.example .env
```

* Configure your database in the `.env`

* Run Migrations and seeder

```php
php artisan migrate --seed
```
* Run npm install

```npm
npm install
```

* link your storage folder to show uploaded images
```php
php artisan storage:link
```

# Reports a platform owner should see
- Total number of listings
- Total number of approved listings and pending listings
- Total number of approved categories and pending categories
- chart of daily visitors
- Total number of all reviews

# Other relevant features includes
- make it possible for vistiors to add listings based on categories
- On the listing page add filter by categories
- Add option to verify listing

# Website link
* https://business-listings-app.herokuapp.com/

# NOTE
- images won't show up as it's a free plan i used. But if tested locally it'll work perfectly fine.