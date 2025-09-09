<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# SmartTickets 🎟️

AI-powered Help Desk Ticket Classification & Dashboard

## 📦 Requirements

- PHP 8.3+

- Composer

- Laravel 11

- MySQL or PostgreSQL

## ⚙️ Installation

#### 1. Clone the repository

```shell
git clone git@github.com:FernandoB5757/support-iq.git
cd support-iq
```

#### 2. Install PHP dependencies

```shell
composer install
```

#### 3. Copy environment file

```shell
cp .env.example .env
```

#### 4. Generate app key

```shell
php artisan key:generate
```

#### 5. Run migrations

```shell
php artisan migrate
```

#### 6. Seed database with demo data

```shell
php artisan db:seed
```

#### 7. Start queue worker (for AI jobs)

```shell
php artisan queue:work
```

## ⚖️ Assumptions & Trade-offs

Backend focus: The API layer and classification logic were prioritized to meet the core requirements (ticket creation, listing, updates, AI classification, and stats). The frontend will be delivered in a later phase.

AI dependency: Classification currently depends directly on OpenAI. This works for the demo but in production it would be better to introduce an abstraction layer or fallback logic to avoid a hard dependency.

Request building: The system prompt and JSON schema could be refined to improve consistency and reduce parsing errors.

Authentication: The API is public by default, meaning anyone can consume it. A proper authentication layer (e.g., Laravel Sanctum or JWT) should be added in a real-world scenario.

Categories: Categories are stored as plain strings in the tickets table. Dedicated endpoints or a reference table for categories would allow for better validation and management.

#### ⏳ What I’d do with more time

Frontend SPA: Build the Vue 3 Options API single-page app to cover /tickets, /tickets/:id, and /dashboard, including dark/light mode and CSV export.

Authentication & Roles: Add login and role-based access control to restrict endpoints and differentiate between agents/admins.

Category management: Create a categories table with CRUD endpoints and use relationships instead of plain strings.

Improved classification: Enhance the TicketClassifier service with better prompt engineering, retries, and possibly support for multiple AI providers.

Testing: Expand unit and feature test coverage, including edge cases for classification, rate-limiting, and bulk jobs.

CI/CD: Add GitHub Actions for automated linting, testing, and build steps.

Monitoring: Add observability (logs, metrics, error tracking) for production readiness.

Testing: Implement tests in parallel with feature development. Expand unit and feature coverage to include edge cases for classification, rate-limiting, and bulk jobs.


#### 📬 Postman Collection

A Postman collection is included in this repository to simplify API testing and exploration.
**File**: Support QA.postman_collection.json
**Location**: Root of this repository
**Contents**:
    - Full API documentation
    - Ready-to-use request examples for each endpoint
You can import this file directly into Postman to start sending requests and reviewing responses.
