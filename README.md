# Courier Service API

## Setup
- composer install
- cp .env.example .env
- php artisan key:generate
- setup database
- php artisan migrate
- php artisan serve

## API Endpoint

GET /api/couriers
POST /api/couriers
GET /api/couriers/{id}
PUT /api/couriers/{id}
DELETE /api/couriers/{id}

## Filtering

?search=budi+agung
?level=2,3
?sort_by=joined_at