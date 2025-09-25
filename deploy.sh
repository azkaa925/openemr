#!/bin/bash

# TeletonicMD One-Command Deployment Script
# This script pulls changes and fixes everything automatically

echo "================================================"
echo "TeletonicMD Automatic Deployment & Fix"
echo "================================================"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to check if command succeeded
check_status() {
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ $1 successful${NC}"
    else
        echo -e "${RED}✗ $1 failed${NC}"
        exit 1
    fi
}

# Step 1: Pull latest changes
echo -e "${YELLOW}Step 1: Pulling latest changes from GitHub...${NC}"
git fetch origin
git pull origin master
check_status "Git pull"
echo ""

# Step 2: Check if critical files exist
echo -e "${YELLOW}Step 2: Verifying files...${NC}"
if [ -f "templates/login/layouts/teletonicmd_custom.html.twig" ]; then
    echo -e "${GREEN}✓ Template file exists${NC}"
else
    echo -e "${RED}✗ Template file missing${NC}"
fi

if [ -f "interface/themes/teletonic_custom/main.css" ]; then
    echo -e "${GREEN}✓ CSS file exists${NC}"
else
    echo -e "${RED}✗ CSS file missing${NC}"
fi
echo ""

# Step 3: Run PHP fix script
echo -e "${YELLOW}Step 3: Updating database configuration...${NC}"
php fix_login_now.php
check_status "Database update"
echo ""

# Step 4: Set permissions
echo -e "${YELLOW}Step 4: Setting correct permissions...${NC}"
chown -R www-data:www-data .
chmod -R 755 .
check_status "Permission update"
echo ""

# Step 5: Clear caches and restart services
echo -e "${YELLOW}Step 5: Restarting services...${NC}"

# Restart PHP-FPM (try different versions)
if systemctl is-active --quiet php8.0-fpm; then
    systemctl restart php8.0-fpm
    echo -e "${GREEN}✓ Restarted PHP 8.0${NC}"
elif systemctl is-active --quiet php7.4-fpm; then
    systemctl restart php7.4-fpm
    echo -e "${GREEN}✓ Restarted PHP 7.4${NC}"
elif systemctl is-active --quiet php7.3-fpm; then
    systemctl restart php7.3-fpm
    echo -e "${GREEN}✓ Restarted PHP 7.3${NC}"
fi

# Restart web server
if systemctl is-active --quiet apache2; then
    systemctl restart apache2
    echo -e "${GREEN}✓ Restarted Apache${NC}"
elif systemctl is-active --quiet nginx; then
    systemctl restart nginx
    echo -e "${GREEN}✓ Restarted Nginx${NC}"
fi
echo ""

# Step 6: Final verification
echo -e "${YELLOW}Step 6: Running final verification...${NC}"
php check_login_config.php | grep -E "✓|✗"
echo ""

echo "================================================"
echo -e "${GREEN}DEPLOYMENT COMPLETE!${NC}"
echo "================================================"
echo ""
echo "Please visit: https://157.173.212.240"
echo "Clear browser cache: Ctrl+Shift+R"
echo ""
echo "You should see:"
echo "  • 'Welcome to TeleTonicMD Secure Telemedicine Portal'"
echo "  • Pastel blue and lavender colors"
echo "  • Modern medical interface"
echo ""
echo "If issues persist, check:"
echo "  • /var/log/apache2/error.log"
echo "  • Run: php check_login_config.php"
echo ""