# TOGA Racing - Team Website

Official WordPress site for the TOGA Racing esports team.

## Tech Stack

- **WordPress 6.x** with custom theme
- **PHP 8.1** (Apache)
- **MySQL 5.7**
- **Docker & Docker Compose**

## Quick Start (Development)

1. Clone the repo:
   ```bash
   git clone https://github.com/theCowBoiCoder/toga_racing.git
   cd toga_racing
   ```

2. Copy and configure environment:
   ```bash
   cp .env.example .env
   # Edit .env with your credentials
   ```

3. Start the containers:
   ```bash
   docker-compose up -d
   ```

4. Visit:
   - **WordPress**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081

5. Complete the WordPress install wizard, then activate the **TOGA Racing** theme under Appearance > Themes.

## Deployment (Ubuntu Server)

1. Install Docker and Docker Compose on your Ubuntu server.
2. Clone this repo to the server.
3. Copy `.env.example` to `.env` and set **strong passwords**.
4. Run `docker-compose up -d`.
5. Point your domain's DNS to the server IP.
6. (Recommended) Set up a reverse proxy (Nginx/Traefik) with SSL via Let's Encrypt.

## Theme Features

- **Driver Profiles** — Custom post type for managing team drivers with photos, bios, stats, and social links.
- **Image Gallery** — Showcase race screenshots, liveries, and team events with lightbox viewing.
- **Social Media Integration** — Team-wide social links configurable via the WordPress Customizer.
- **Responsive Design** — Mobile-first, dark esports aesthetic with TOGA Racing branding.

## Colour Scheme

- Green: `#00ff0a`
- Black: `#000000`
