# Larasonic

## Local Development Setup with Laravel Sail

This project uses Laravel Sail, a light-weight command-line interface for interacting with Laravel's default Docker development environment.

### Prerequisites

- Docker Desktop
- Docker Compose
- Git

### First-time Setup

1. Clone the repository:

```bash
git clone git@github.com:pushpak1300/Larasonic.git
cd Larasonic
```

2. Install Composer dependencies:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

3. Start Laravel Sail:

```bash
./vendor/bin/sail composer run setup
```

### Daily Development Commands

Start environment:

```bash
./vendor/bin/sail up -d
```

Stop environment:

```bash
./vendor/bin/sail down
```


### Optional: Shell Alias

Add to ~/.bashrc or ~/.zshrc:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

### Available Services

- **Application**: http://localhost:8010
- **Vite Dev Server**: http://localhost:5173
- **PostgreSQL**: port 5432
  - Database: ${DB_DATABASE}
  - Username: ${DB_USERNAME}
  - Password: ${DB_PASSWORD}
- **Mailpit**:
  - SMTP: port 1025
  - Dashboard: http://localhost:8025
- **FrankenPHP Admin**: http://localhost:2019

### Tech Stack

- PHP 8.3 +
- Laravel Octane with FrankenPHP
- Bun (Package Manager)
- Inertia.js 2 + Vue 3.4
- TailwindCSS 3.4+
- PostgreSQL 17
- Redis (Alpine)
- Mailpit for local email testing

## Security

If you discover a security vulnerability, please email pushpak1300@gmail.com.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
