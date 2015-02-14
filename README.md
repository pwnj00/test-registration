# Test registration project

## Requirements
* Apache 2.x web server with mod_rewrite enabled
* php 5.3
* PostgreSQL 9.3+

## Installation
1. Create PGSQL database for project
2. Execute db.sql script for create db tables and functions
3. Edit `/config/config.php` file to set up database connection
4. Set up apache virtual host:
  * Set DocumentRoot to the `/web/` directory of the project
  * Set "AllowOverride all" in Directory config to allow .htaccess work properly

## Other
This project uses Bootstrap 3.3.2 HTML, CSS and JS framework
