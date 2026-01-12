# WordPress wp-config.php Reference Guide

A comprehensive collection of WordPress `wp-config.php` constants, settings, and configurations for developers and agencies managing WordPress sites.

![WordPress](https://img.shields.io/badge/WordPress-6.7%2B-blue?logo=wordpress)
![PHP](https://img.shields.io/badge/PHP-8.1%2B-purple?logo=php)
![License](https://img.shields.io/badge/License-MIT-green)

## Overview

This reference guide contains **850+ lines** of documented WordPress configuration options organised into **28 categories**. It covers everything from basic settings to advanced configurations for caching, security, multisite, and popular plugins.

**This is a reference file** — do not use it directly as your `wp-config.php`. Instead, copy only the constants you need for your specific setup.

## Table of Contents

| # | Section | Description |
|---|---------|-------------|
| 1 | Environment & Base Configuration | Environment type, development mode |
| 2 | Database Settings | Credentials, charset, collation, repair |
| 3 | URL Configuration | Home/site URLs, dynamic URLs, relocate mode |
| 4 | Filesystem & Paths | FS method, permissions, temp directory |
| 5 | Content, Plugin & Theme Paths | Custom wp-content, plugin, mu-plugin paths |
| 6 | Uploads Configuration | Custom uploads directory, unfiltered uploads |
| 7 | Cookie Settings | Cookie domain, paths, custom names |
| 8 | Authentication Keys & Salts | Security keys and salts |
| 9 | Security Settings | File editor, file mods, unfiltered HTML |
| 10 | SSL & HTTPS Configuration | Force SSL, reverse proxy detection |
| 11 | Debugging & Development | Debug mode, logging, script debug |
| 12 | Performance & Caching | Memory limits, page cache, cache key salt |
| 13 | Object Cache (Redis/Memcached) | Redis and Memcached configuration |
| 14 | Cron Configuration | WP-Cron, server cron, lock timeout |
| 15 | Post Revisions & Autosave | Revision limits, autosave interval |
| 16 | Trash Settings | Auto-empty days, media trash |
| 17 | Updates & File Modifications | Auto-updates, core updates |
| 18 | Multisite Configuration | Network setup, subdomain/subdirectory |
| 19 | Mail Settings | Mail interval |
| 20 | Proxy Configuration | HTTP proxy settings |
| 21 | External HTTP Requests | Block external, whitelist hosts |
| 22 | Language & Localization | WPLANG, language directory |
| 23 | Error Handling & Recovery Mode | Recovery email, WSOD protection |
| 24 | FTP/SSH Credentials | Update credentials |
| 25 | PHP Settings & Session Security | Error display, session hardening |
| 26 | Plugin-Specific Constants | WP Rocket, UpdraftPlus, WooCommerce, etc. |
| 27 | Migration Helpers | URL updates, search-replace tools |
| 28 | Miscellaneous | SHORTINIT, WP_USE_THEMES, etc. |

## Quick Start

### Basic Production Setup

```php
<?php
// Performance
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// URLs
define( 'WP_HOME', 'https://yourdomain.com' );
define( 'WP_SITEURL', 'https://yourdomain.com' );

// Security
define( 'FORCE_SSL_ADMIN', true );
define( 'DISALLOW_FILE_EDIT', true );

// Content management
define( 'AUTOSAVE_INTERVAL', 120 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 14 );

// Debugging (off for production)
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
```

### Development Setup

```php
<?php
// Environment
define( 'WP_ENVIRONMENT_TYPE', 'development' );
define( 'WP_LOCAL_DEV', true );

// Debugging (on for development)
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );

// Disable concatenation for easier debugging
define( 'CONCATENATE_SCRIPTS', false );
```

### Cloudflare / Reverse Proxy Setup

```php
<?php
// Detect HTTPS behind Cloudflare or load balancers
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

// Cloudflare-specific
if ( isset( $_SERVER['HTTP_CF_VISITOR'] ) ) {
    $cf_visitor = json_decode( $_SERVER['HTTP_CF_VISITOR'] );
    if ( isset( $cf_visitor->scheme ) && $cf_visitor->scheme === 'https' ) {
        $_SERVER['HTTPS'] = 'on';
    }
}
```

### Redis Object Cache

```php
<?php
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );
define( 'WP_REDIS_PASSWORD', '' );
define( 'WP_REDIS_DATABASE', 0 );
define( 'WP_REDIS_PREFIX', 'mysite_' );
define( 'WP_REDIS_TIMEOUT', 1 );
define( 'WP_REDIS_READ_TIMEOUT', 1 );
```

## Security Recommendations

### File Permissions

After setting up your `wp-config.php`, secure it with restrictive permissions:

```bash
# Set wp-config.php to read-only
chmod 400 wp-config.php

# Or if the above causes issues
chmod 440 wp-config.php
```

### Move wp-config.php

WordPress automatically checks one directory above the web root for `wp-config.php`. Moving it there adds an extra layer of security:

```
/home/user/wp-config.php          ← Move here (outside web root)
/home/user/public_html/           ← WordPress installation
/home/user/public_html/wp-admin/
/home/user/public_html/wp-content/
/home/user/public_html/wp-includes/
```

### Session Security

Add these PHP settings to harden session cookies:

```php
<?php
@ini_set( 'session.cookie_httponly', true );  // Prevent XSS access to cookies
@ini_set( 'session.cookie_secure', true );    // HTTPS only
@ini_set( 'session.use_only_cookies', true ); // Block session fixation
```

### Recommended Security Constants

```php
<?php
define( 'DISALLOW_FILE_EDIT', true );     // Disable theme/plugin editor
define( 'DISALLOW_UNFILTERED_HTML', true ); // Block unfiltered HTML
define( 'FORCE_SSL_ADMIN', true );        // Force HTTPS for admin
```

## Server Cron Setup

Disable WP-Cron and use a real server cron for better reliability:

```php
<?php
define( 'DISABLE_WP_CRON', true );
```

Then add a server cron job (every 5 minutes recommended):

```bash
# Using wget
*/5 * * * * wget -q -O - https://yourdomain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1

# Using curl
*/5 * * * * curl -s https://yourdomain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1

# Using WP-CLI (if available)
*/5 * * * * cd /path/to/wordpress && wp cron event run --due-now >/dev/null 2>&1
```

## Migration Guide

### Quick Domain Change

Add temporarily to `functions.php` or create a mu-plugin:

```php
<?php
update_option( 'siteurl', 'https://newdomain.com' );
update_option( 'home', 'https://newdomain.com' );
```

**Remove immediately after the site loads correctly!**

### Using WP-CLI

```bash
# Update URLs
wp option update siteurl 'https://newdomain.com'
wp option update home 'https://newdomain.com'

# Full search-replace
wp search-replace 'https://olddomain.com' 'https://newdomain.com' --all-tables --precise
```

### Using wp-config.php

```php
<?php
define( 'WP_HOME', 'https://newdomain.com' );
define( 'WP_SITEURL', 'https://newdomain.com' );

// Temporary - remove after first successful login
define( 'RELOCATE', true );
```

## Plugin-Specific Constants

### WP Rocket

```php
<?php
// White label (hide WP Rocket branding)
define( 'WP_ROCKET_WHITE_LABEL_FOOTPRINT', true );
define( 'WP_ROCKET_WHITE_LABEL_ACCOUNT', true );

// License credentials
define( 'WP_ROCKET_EMAIL', 'your-email@domain.com' );
define( 'WP_ROCKET_KEY', 'your-license-key' );
```

### UpdraftPlus

```php
<?php
// Disable admin locking
define( 'UPDRAFTPLUS_NOADMINLOCK', true );
```

### Gravity Forms

```php
<?php
define( 'GF_LICENSE_KEY', 'your-license-key' );
```

### ACF Pro

```php
<?php
// Hide ACF menu in production
define( 'ACF_LITE', true );
```

## Environment Types (WordPress 5.5+)

WordPress 5.5 introduced environment types. Set the appropriate type for your installation:

```php
<?php
// Options: 'local', 'development', 'staging', 'production'
define( 'WP_ENVIRONMENT_TYPE', 'production' );
```

Check environment in code:

```php
<?php
if ( wp_get_environment_type() === 'production' ) {
    // Production-only code
}
```

## Useful Resources

- [WordPress wp-config.php Documentation](https://developer.wordpress.org/advanced-administration/wordpress/wp-config/)
- [WordPress Salts Generator](https://api.wordpress.org/secret-key/1.1/salt/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WP-CLI Commands](https://developer.wordpress.org/cli/commands/)

## File Structure

```
kperrow/wp-config/
├── README.md                  # This file
├── wp-config-reference.php    # Complete reference (850+ lines)
└── LICENSE                    # MIT License
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/new-constant`)
3. Commit your changes (`git commit -m 'Add new constant for XYZ'`)
4. Push to the branch (`git push origin feature/new-constant`)
5. Open a Pull Request

## Changelog

### v2.0.0 (2025-01-12)
- Added 28 organised sections
- Added environment type constants (WP 5.5+)
- Added development mode constant (WP 6.3+)
- Added Redis object cache configuration
- Added Cloudflare/reverse proxy HTTPS detection
- Added session cookie security settings
- Added plugin-specific constants (WP Rocket, UpdraftPlus, etc.)
- Added migration helpers section
- Added Creative Ground production template
- Comprehensive documentation for all constants

### v1.0.0
- Initial release with basic constants

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

**Creative Ground**  
WordPress Development Agency & Managed Hosting  
[www.creativeground.com.au](https://www.creativeground.com.au)

---

⭐ If you find this useful, please consider giving it a star on GitHub!
