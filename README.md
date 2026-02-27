# TOGA Racing - Team Website

Official WordPress site for the TOGA Racing esports team.

## Tech Stack

- **WordPress 6.x** with custom theme
- **PHP 8.1-FPM**
- **MySQL 8.x**
- **Nginx**

## Local Development (Docker)

Docker files are included for local development:

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

## Deployment (Ubuntu Server — Nginx + MySQL)

### Automated Setup

1. Clone this repo on your Ubuntu server:
   ```bash
   git clone https://github.com/theCowBoiCoder/toga_racing.git
   cd toga_racing
   ```

2. Edit the variables at the top of `setup-server.sh`:
   - `DOMAIN` — your domain name
   - `DB_PASS` — a strong database password

3. Run the setup script:
   ```bash
   sudo bash setup-server.sh
   ```

4. Point your domain's DNS A record to the server IP.

5. Visit your domain to complete the WordPress install wizard.

6. Activate the **TOGA Racing** theme under Appearance > Themes.

7. (Recommended) Install SSL:
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d your-domain.com -d www.your-domain.com
   ```

### Manual Setup

If you prefer to set things up manually, the key files are:
- `nginx/toga-racing.conf` — Nginx server block config
- `wp-content/themes/toga-racing/` — the custom theme to copy into your WordPress installation

## Theme Features

- **Driver Profiles** — Custom post type for managing team drivers with photos, bios, stats, and social links.
- **Image Gallery** — Showcase race screenshots, liveries, and team events with lightbox viewing.
- **Social Media Integration** — Team-wide social links configurable via the WordPress Customizer.
- **Responsive Design** — Mobile-first, dark esports aesthetic with TOGA Racing branding.

## Colour Scheme

- Green: `#00ff0a`
- Black: `#000000`
