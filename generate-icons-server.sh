#!/bin/bash
# Run this on the server: bash generate-icons-server.sh
# Requires: php with GD (already installed via php8.3-gd)

apt install -y php8.3-gd 2>/dev/null
php /var/www/ubarter/generate-icons.php
