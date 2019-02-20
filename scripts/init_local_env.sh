#!/usr/bin/env bash
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar ./scripts/wp-cli.phar
chmod +x wp-cli.phar
mkdir wp
mkdir wp-content
php wp-cli.phar core download --locale=ja --path=wp --skip-plugins --skip-themes
rm -Rf wp-cli.phar
rm -Rf "$(pwd)/wp/wp-content/"
ln -s "$(pwd)/wp-content" "$(pwd)/wp"