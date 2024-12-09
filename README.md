# Larasonic 🚀

![Larasonic](public/images/og.webp)


Larasonic is a modern, open-source AI chat platform built with Laravel, Vue.js, and Inertia. It provides a powerful foundation for building AI-powered chat applications with features like team collaboration, multiple AI models support, and real-time communication.

[![GitHub stars](https://img.shields.io/github/stars/pushpak1300/Larasonic)](https://github.com/pushpak1300/Larasonic/stargazers)
[![License](https://img.shields.io/github/license/pushpak1300/Larasonic)](https://opensource.org/licenses/MIT)

## ✨ Features

- 🤖 Multiple AI Model Support (OpenAI, Anthropic, etc.)
- 👥 Team Collaboration
- 💬 Real-time Chat
- 🎨 Beautiful UI with TailwindCSS
- 🚀 High Performance with Laravel Octane & FrankenPHP
- 🔒 Enterprise-grade Security

## Quick Start

```bash
# Clone the repo
git clone git@github.com:pushpak1300/Larasonic.git
cd Larasonic

# Install dependencies
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Setup environment
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer run setup
```

For detailed installation instructions and documentation, visit [docs.larasonic.com](https://docs.larasonic.com).

## Tech Stack

- PHP 8.3+ with Laravel Octane & FrankenPHP
- Vue 3.4 + Inertia.js
- TailwindCSS 3.4+
- PostgreSQL 17
- Redis
- Bun Package Manager

## Hosting

Proudly hosted and sponsored by [Sevalla.com](https://sevalla.com/?ref=larasonic).

## Security

Report vulnerabilities to pushpak1300@gmail.com

## License

[MIT](https://opensource.org/licenses/MIT)
