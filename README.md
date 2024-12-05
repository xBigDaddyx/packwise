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

3. Copy the `.env.example` file to `.env` and update the environment variables:

```bash
cp .env.example .env
```

4. Start Laravel Sail:

```bash
./vendor/bin/sail up -d
```

5. Run setup script:

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

### Tech Stack

- PHP 8.3 +
- Laravel Octane with FrankenPHP
- Bun (Package Manager)
- Inertia.js 2 + Vue 3.4
- TailwindCSS 3.4+
- PostgreSQL 17
- Redis (Alpine)
- Mailpit for local email testing

### Hosting

This project is proudly hosted on [Sevalla.com](https://sevalla.com/?ref=larasonic). Sevalla is our official hosting partner, providing reliable and scalable hosting solutions for Laravel applications.


## Security

If you discover a security vulnerability, please email pushpak1300@gmail.com.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

