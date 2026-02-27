#!/bin/bash
# ============================================================
# TOGA Racing - Ubuntu Server Setup
# Nginx + MySQL + PHP 8.1 + WordPress
#
# Usage: sudo bash setup-server.sh
#
# BEFORE RUNNING: Update these variables below
# ============================================================

set -e

# ------- EDIT THESE -------
DOMAIN="your-domain.com"
DB_NAME="toga_racing"
DB_USER="toga_user"
DB_PASS="CHANGE_ME_STRONG_PASSWORD"
WP_DIR="/var/www/toga_racing"
# --------------------------

echo "=== TOGA Racing Server Setup ==="
echo "Domain: $DOMAIN"
echo "Install dir: $WP_DIR"
echo ""

# 1. Update system
echo ">>> Updating system..."
apt update && apt upgrade -y

# 2. Install Nginx, MySQL, PHP 8.1
echo ">>> Installing Nginx, MySQL, PHP 8.1..."
apt install -y nginx mysql-server php8.1-fpm php8.1-mysql php8.1-curl \
    php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip php8.1-intl \
    php8.1-imagick php8.1-bcmath unzip curl

# 3. Start and enable services
echo ">>> Starting services..."
systemctl enable nginx
systemctl enable mysql
systemctl enable php8.1-fpm
systemctl start nginx
systemctl start mysql
systemctl start php8.1-fpm

# 4. Create MySQL database and user
echo ">>> Setting up MySQL database..."
mysql -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME} DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';"
mysql -e "GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

# 5. Download WordPress
echo ">>> Downloading WordPress..."
mkdir -p $WP_DIR
curl -sL https://wordpress.org/latest.tar.gz | tar xz --strip-components=1 -C $WP_DIR

# 6. Copy theme from repo
echo ">>> Installing TOGA Racing theme..."
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
cp -r "$SCRIPT_DIR/wp-content/themes/toga-racing" "$WP_DIR/wp-content/themes/"

# 7. Set up wp-config.php
echo ">>> Configuring WordPress..."
cp "$WP_DIR/wp-config-sample.php" "$WP_DIR/wp-config.php"

# Set database credentials
sed -i "s/database_name_here/${DB_NAME}/" "$WP_DIR/wp-config.php"
sed -i "s/username_here/${DB_USER}/" "$WP_DIR/wp-config.php"
sed -i "s/password_here/${DB_PASS}/" "$WP_DIR/wp-config.php"

# Generate unique salts
echo ">>> Generating security keys..."
SALTS=$(curl -s https://api.wordpress.org/secret-key/1.1/salt/)
# Remove existing salt lines and add new ones
sed -i '/AUTH_KEY/d' "$WP_DIR/wp-config.php"
sed -i '/SECURE_AUTH_KEY/d' "$WP_DIR/wp-config.php"
sed -i '/LOGGED_IN_KEY/d' "$WP_DIR/wp-config.php"
sed -i '/NONCE_KEY/d' "$WP_DIR/wp-config.php"
sed -i '/AUTH_SALT/d' "$WP_DIR/wp-config.php"
sed -i '/SECURE_AUTH_SALT/d' "$WP_DIR/wp-config.php"
sed -i '/LOGGED_IN_SALT/d' "$WP_DIR/wp-config.php"
sed -i '/NONCE_SALT/d' "$WP_DIR/wp-config.php"
# Insert salts before "That's all" comment
sed -i "/That's all/i\\${SALTS}" "$WP_DIR/wp-config.php"

# 8. Set file permissions
echo ">>> Setting permissions..."
chown -R www-data:www-data $WP_DIR
find $WP_DIR -type d -exec chmod 755 {} \;
find $WP_DIR -type f -exec chmod 644 {} \;

# 9. Configure Nginx
echo ">>> Configuring Nginx..."
cp "$SCRIPT_DIR/nginx/toga-racing.conf" /etc/nginx/sites-available/toga-racing

# Replace domain placeholder
sed -i "s/your-domain.com/${DOMAIN}/g" /etc/nginx/sites-available/toga-racing

# Enable site and disable default
ln -sf /etc/nginx/sites-available/toga-racing /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and reload Nginx
nginx -t && systemctl reload nginx

# 10. Configure PHP upload limits
echo ">>> Configuring PHP limits..."
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 64M/' /etc/php/8.1/fpm/php.ini
sed -i 's/post_max_size = .*/post_max_size = 64M/' /etc/php/8.1/fpm/php.ini
sed -i 's/max_execution_time = .*/max_execution_time = 300/' /etc/php/8.1/fpm/php.ini
sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php/8.1/fpm/php.ini
systemctl restart php8.1-fpm

echo ""
echo "=== Setup Complete! ==="
echo ""
echo "Next steps:"
echo "  1. Point your domain DNS (A record) to this server's IP"
echo "  2. Visit http://${DOMAIN} to complete WordPress setup"
echo "  3. Activate the 'TOGA Racing' theme in Appearance > Themes"
echo "  4. (Recommended) Install SSL with: sudo certbot --nginx -d ${DOMAIN} -d www.${DOMAIN}"
echo ""
echo "To install Certbot for SSL:"
echo "  sudo apt install certbot python3-certbot-nginx"
echo "  sudo certbot --nginx -d ${DOMAIN} -d www.${DOMAIN}"
