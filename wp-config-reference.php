<?php
/**
 * WordPress Configuration Reference Guide
 * 
 * A comprehensive collection of wp-config.php constants and settings.
 * This is a REFERENCE FILE - do not use directly. Copy only the constants you need.
 * 
 * @author      Creative Ground
 * @version     2.0.0
 * @updated     2025-01-12
 * @link        https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 */

/* ===========================================================================
   TABLE OF CONTENTS
   ===========================================================================
   1.  Environment & Base Configuration
   2.  Database Settings
   3.  URL Configuration
   4.  Filesystem & Paths
   5.  Content, Plugin & Theme Paths
   6.  Uploads Configuration
   7.  Cookie Settings
   8.  Authentication Keys & Salts
   9.  Security Settings
   10. SSL & HTTPS Configuration
   11. Debugging & Development
   12. Performance & Caching
   13. Object Cache (Redis/Memcached)
   14. Cron Configuration
   15. Post Revisions & Autosave
   16. Trash Settings
   17. Updates & File Modifications
   18. Multisite Configuration
   19. Mail Settings
   20. Proxy Configuration
   21. External HTTP Requests
   22. Language & Localization
   23. Error Handling & Recovery Mode
   24. FTP/SSH Credentials
   25. PHP Settings & Session Security
   26. Plugin-Specific Constants
   27. Migration Helpers
   28. Miscellaneous
   =========================================================================== */


/* ===========================================================================
   1. ENVIRONMENT & BASE CONFIGURATION
   =========================================================================== */

/**
 * Environment Type (WordPress 5.5+)
 * 
 * Defines the current environment. WordPress and plugins can adjust behavior
 * based on this value. Use wp_get_environment_type() to retrieve.
 * 
 * Options: 'local', 'development', 'staging', 'production'
 * Default: 'production'
 */
define( 'WP_ENVIRONMENT_TYPE', 'production' );

/**
 * Development Mode (WordPress 6.3+)
 * 
 * Enables development mode for specific features.
 * Affects caching behavior and asset loading.
 * 
 * Options: 'core', 'plugin', 'theme', 'all', '' (empty to disable)
 */
define( 'WP_DEVELOPMENT_MODE', '' );

/**
 * Local Development Flag
 * 
 * Custom constant for toggling local development features.
 * Not a core WordPress constant - useful for custom code switches.
 */
define( 'WP_LOCAL_DEV', false );


/* ===========================================================================
   2. DATABASE SETTINGS
   =========================================================================== */

/**
 * Database Credentials
 * 
 * Standard database connection settings.
 * These are typically set during WordPress installation.
 */
define( 'DB_NAME', 'database_name_here' );
define( 'DB_USER', 'username_here' );
define( 'DB_PASSWORD', 'password_here' );
define( 'DB_HOST', 'localhost' );

/**
 * Database Charset
 * 
 * Character set for database tables.
 * utf8mb4 supports full Unicode including emojis (recommended).
 */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Database Collation
 * 
 * Collation type for database tables.
 * Leave blank to use MySQL default, or specify explicitly.
 * 
 * Common options:
 * - '' (empty): Use MySQL default
 * - 'utf8mb4_unicode_ci': Good general purpose collation
 * - 'utf8mb4_unicode_520_ci': Better Unicode 5.2+ sorting (recommended)
 */
define( 'DB_COLLATE', '' );
// define( 'DB_COLLATE', 'utf8mb4_unicode_ci' );
// define( 'DB_COLLATE', 'utf8mb4_unicode_520_ci' );

/**
 * Database Table Prefix
 * 
 * Prefix for all WordPress database tables.
 * Change from default 'wp_' for added security.
 * Only letters, numbers, and underscores allowed.
 */
$table_prefix = 'wp_';

/**
 * Database Repair
 * 
 * Enables the database repair script at /wp-admin/maint/repair.php
 * SECURITY: Disable after use - anyone can access the repair page when enabled.
 */
define( 'WP_ALLOW_REPAIR', false );

/**
 * Global Tables Upgrade
 * 
 * Prevents WordPress from upgrading global tables (users, usermeta) during updates.
 * Useful in multisite or shared user table configurations.
 */
define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', false );

/**
 * Custom User Tables
 * 
 * Share user tables across multiple WordPress installations.
 * Both constants must be set together.
 */
// define( 'CUSTOM_USER_TABLE', 'shared_users' );
// define( 'CUSTOM_USER_META_TABLE', 'shared_usermeta' );


/* ===========================================================================
   3. URL CONFIGURATION
   =========================================================================== */

/**
 * Site URLs
 * 
 * WP_HOME: The URL users type to reach your site (front-end).
 * WP_SITEURL: The URL where WordPress core files are located.
 * 
 * Setting these overrides database values and improves performance
 * by eliminating database queries for these values.
 * 
 * IMPORTANT: Always use https:// for production sites.
 */
define( 'WP_HOME', 'https://domain.com' );
define( 'WP_SITEURL', 'https://domain.com' );

/**
 * Dynamic URL Configuration
 * 
 * Automatically detect the current host.
 * Useful for development environments or when domain varies.
 * WARNING: Security risk in production - use explicit URLs instead.
 */
// define( 'WP_HOME', 'https://' . $_SERVER['HTTP_HOST'] );
// define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] );

/**
 * Relocate Mode
 * 
 * Temporary constant to help relocate/migrate a site.
 * Updates siteurl to the URL used to access wp-login.php.
 * IMPORTANT: Remove immediately after logging in successfully.
 */
// define( 'RELOCATE', true );


/* ===========================================================================
   4. FILESYSTEM & PATHS
   =========================================================================== */

/**
 * Filesystem Method
 * 
 * How WordPress should write files (updates, uploads, etc.).
 * 
 * Options:
 * - 'direct': Write files directly (requires proper ownership)
 * - 'ssh2': Use SSH2 PHP extension
 * - 'ftpext': Use FTP PHP extension
 * - 'ftpsockets': Use PHP sockets for FTP
 * 
 * WordPress auto-detects if not set.
 */
define( 'FS_METHOD', 'direct' );

/**
 * File Permissions
 * 
 * Default permissions for new directories and files.
 * umask() ensures permissions don't exceed system limits.
 * 
 * Recommended values (balances security and compatibility):
 * - Directories: 0755 (rwxr-xr-x)
 * - Files: 0644 (rw-r--r--)
 * 
 * More restrictive (0750/0640) can cause issues with some hosts/plugins.
 * 
 * TIP: For wp-config.php specifically, set to 400 or 440 via SSH/SFTP
 * after installation for maximum security.
 */
define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );

/**
 * Temporary Directory
 * 
 * Directory for temporary files during updates/uploads.
 * Must be writable by the web server.
 * Falls back to system temp directory if not set.
 */
// define( 'WP_TEMP_DIR', '/tmp/' );

/**
 * ABSPATH
 * 
 * Absolute path to the WordPress directory.
 * Typically defined at the end of wp-config.php.
 * Required for WordPress to function.
 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}


/* ===========================================================================
   5. CONTENT, PLUGIN & THEME PATHS
   =========================================================================== */

/**
 * Content Directory
 * 
 * Location of the wp-content directory.
 * Allows moving wp-content outside the WordPress root for security.
 */
define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
define( 'WP_CONTENT_URL', 'https://domain.com/wp-content' );

/**
 * Plugin Directory
 * 
 * Full path and URL to the plugins directory.
 * Allows custom plugin directory locations.
 */
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins' );

/**
 * Plugin Directory (Legacy)
 * 
 * Relative path for backwards compatibility.
 * Used by older plugins.
 */
define( 'PLUGINDIR', 'wp-content/plugins' );

/**
 * Must-Use Plugins Directory
 * 
 * Plugins in this directory are automatically activated.
 * Cannot be deactivated through the admin interface.
 * Great for critical functionality and hosting-level features.
 */
define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' );
define( 'WPMU_PLUGIN_URL', WP_CONTENT_URL . '/mu-plugins' );
define( 'MUPLUGINDIR', 'wp-content/mu-plugins' );

/**
 * Theme Paths
 * 
 * Functions to get template paths.
 * Note: These use functions, not static values.
 * Generally not needed in wp-config.php.
 */
// define( 'TEMPLATEPATH', get_template_directory() );      // Parent theme path
// define( 'STYLESHEETPATH', get_stylesheet_directory() );  // Child theme path

/**
 * Default Theme
 * 
 * Fallback theme if the active theme is broken or missing.
 * Must be a theme that exists in the themes directory.
 */
define( 'WP_DEFAULT_THEME', 'twentytwentyfour' );


/* ===========================================================================
   6. UPLOADS CONFIGURATION
   =========================================================================== */

/**
 * Uploads Directory
 * 
 * Custom uploads folder location.
 * Path is relative to ABSPATH.
 */
// define( 'UPLOADS', 'wp-content/uploads' );

/**
 * Unfiltered Uploads
 * 
 * Allow administrators to upload any file type.
 * SECURITY WARNING: Major security risk - not recommended for production.
 * Allows upload of potentially dangerous files (PHP, JS, etc.).
 */
// define( 'ALLOW_UNFILTERED_UPLOADS', true );


/* ===========================================================================
   7. COOKIE SETTINGS
   =========================================================================== */

/**
 * Cookie Domain
 * 
 * Domain for WordPress cookies.
 * Important for login issues, especially with subdomains.
 * 
 * Examples:
 * - '.domain.com'     : Domain and ALL subdomains (note the leading dot)
 * - 'domain.com'      : Root domain only
 * - 'www.domain.com'  : Specific subdomain only
 */
define( 'COOKIE_DOMAIN', 'domain.com' );

/**
 * Cookie Paths
 * 
 * Paths where cookies are valid.
 * Usually only needs customization for subdirectory installs.
 */
define( 'COOKIEPATH', '/' );
define( 'SITECOOKIEPATH', '/' );
define( 'ADMIN_COOKIE_PATH', '/wp-admin' );
// define( 'PLUGINS_COOKIE_PATH', '/wp-content/plugins' );

/**
 * Cookie Names
 * 
 * Custom cookie names using the COOKIEHASH.
 * COOKIEHASH is auto-generated from siteurl.
 * Rarely needs customization.
 */
// define( 'USER_COOKIE', 'wordpressuser_' . COOKIEHASH );
// define( 'PASS_COOKIE', 'wordpresspass_' . COOKIEHASH );
// define( 'AUTH_COOKIE', 'wordpress_' . COOKIEHASH );
// define( 'SECURE_AUTH_COOKIE', 'wordpress_sec_' . COOKIEHASH );
// define( 'LOGGED_IN_COOKIE', 'wordpress_logged_in_' . COOKIEHASH );
// define( 'RECOVERY_MODE_COOKIE', 'wordpress_rec_' . COOKIEHASH );

/**
 * Cookie Hash
 * 
 * Hash used for cookie names. Auto-generated from siteurl.
 * Only override if you need specific cookie naming.
 */
// define( 'COOKIEHASH', md5( 'https://domain.com' ) );


/* ===========================================================================
   8. AUTHENTICATION KEYS & SALTS
   =========================================================================== */

/**
 * Authentication Unique Keys and Salts
 * 
 * Enhance security of cookies and passwords.
 * Generate unique values at: https://api.wordpress.org/secret-key/1.1/salt/
 * 
 * Changing these will invalidate all existing cookies,
 * forcing all users to log in again.
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );


/* ===========================================================================
   9. SECURITY SETTINGS
   =========================================================================== */

/**
 * File Editor
 * 
 * Disable the built-in plugin/theme editor in wp-admin.
 * Prevents code editing through the admin interface.
 * Highly recommended for production sites.
 */
define( 'DISALLOW_FILE_EDIT', true );

/**
 * File Modifications
 * 
 * Completely disable plugin/theme installation and updates.
 * Also disables the file editor.
 * Use for locked-down production environments.
 */
define( 'DISALLOW_FILE_MODS', false );

/**
 * Unfiltered HTML
 * 
 * Block unfiltered HTML even for administrators and editors.
 * Prevents insertion of arbitrary HTML/JavaScript.
 * Important for multi-author sites.
 */
define( 'DISALLOW_UNFILTERED_HTML', true );

/**
 * Application Passwords (WordPress 5.6+)
 * 
 * Disable the Application Passwords feature.
 * Application passwords allow API authentication.
 * Disable if not using REST API authentication.
 */
// define( 'WP_DISABLE_APPLICATION_PASSWORDS', true );

/**
 * Image Editing
 * 
 * Allow image edits to overwrite original files.
 * Saves disk space but loses original images.
 */
define( 'IMAGE_EDIT_OVERWRITE', true );


/* ===========================================================================
   10. SSL & HTTPS CONFIGURATION
   =========================================================================== */

/**
 * Force SSL for Admin
 * 
 * Force HTTPS for the entire WordPress admin area.
 * Recommended for all production sites.
 */
define( 'FORCE_SSL_ADMIN', true );

/**
 * Force SSL for Login (Deprecated but still functional)
 * 
 * Only secure the login/registration pages.
 * FORCE_SSL_ADMIN is preferred as it covers everything.
 */
define( 'FORCE_SSL_LOGIN', true );

/**
 * Reverse Proxy / Load Balancer HTTPS Detection
 * 
 * Detect HTTPS when behind Cloudflare, load balancers, or reverse proxies.
 * These proxies terminate SSL and forward requests as HTTP.
 * 
 * Place this BEFORE wp-settings.php is loaded.
 */

// Generic X-Forwarded-Proto header detection (most proxies/load balancers)
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

// Cloudflare-specific detection
if ( isset( $_SERVER['HTTP_CF_VISITOR'] ) ) {
    $cf_visitor = json_decode( $_SERVER['HTTP_CF_VISITOR'] );
    if ( isset( $cf_visitor->scheme ) && $cf_visitor->scheme === 'https' ) {
        $_SERVER['HTTPS'] = 'on';
    }
}

// AWS Elastic Load Balancer
// if ( isset( $_SERVER['HTTP_X_FORWARDED_PORT'] ) && $_SERVER['HTTP_X_FORWARDED_PORT'] === '443' ) {
//     $_SERVER['HTTPS'] = 'on';
// }


/* ===========================================================================
   11. DEBUGGING & DEVELOPMENT
   =========================================================================== */

/**
 * WordPress Debug Mode
 * 
 * Master switch for debugging features.
 * Shows PHP errors, warnings, and notices.
 * NEVER enable on production sites.
 */
define( 'WP_DEBUG', false );

/**
 * Debug Logging
 * 
 * Log errors to /wp-content/debug.log file.
 * Useful for debugging without displaying errors to visitors.
 * Can also specify a custom path.
 */
define( 'WP_DEBUG_LOG', false );
// define( 'WP_DEBUG_LOG', '/path/to/custom/debug.log' );

/**
 * Debug Display
 * 
 * Show errors on screen.
 * Set to false and use WP_DEBUG_LOG for production debugging.
 */
define( 'WP_DEBUG_DISPLAY', false );

/**
 * Script Debugging
 * 
 * Use non-minified versions of core CSS and JavaScript files.
 * Required for modifying core scripts during development.
 */
define( 'SCRIPT_DEBUG', false );

/**
 * Script Concatenation
 * 
 * Concatenate JavaScript files in admin.
 * Set to false to load scripts separately (easier debugging).
 * Set to true for better admin performance in production.
 */
define( 'CONCATENATE_SCRIPTS', true );

/**
 * Script Compression
 * 
 * Enable gzip compression for scripts and styles.
 */
define( 'COMPRESS_SCRIPTS', true );
define( 'COMPRESS_CSS', true );
define( 'ENFORCE_GZIP', true );

/**
 * Save Database Queries
 * 
 * Store all database queries in $wpdb->queries array.
 * Useful for debugging but uses significant memory.
 * Access via $wpdb->queries global.
 */
define( 'SAVEQUERIES', false );


/* ===========================================================================
   12. PERFORMANCE & CACHING
   =========================================================================== */

/**
 * Memory Limits
 * 
 * PHP memory allocated to WordPress.
 * WP_MEMORY_LIMIT: Front-end operations
 * WP_MAX_MEMORY_LIMIT: Admin-side operations (imports, updates, etc.)
 * 
 * Recommended values:
 * - Standard sites: 256M / 512M
 * - WooCommerce/heavy plugins: 512M / 1024M
 */
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/**
 * Advanced Page Caching
 * 
 * Enable advanced caching via advanced-cache.php drop-in.
 * Required by most caching plugins (WP Rocket, WP Super Cache, W3TC, etc.).
 * 
 * Note: Caching plugins usually add this automatically.
 */
define( 'WP_CACHE', true );

/**
 * Cache Key Salt
 * 
 * Unique string to prevent cache collisions in shared environments.
 * Essential when multiple WordPress sites share the same cache server.
 * Use a unique string per site - can include special characters.
 * 
 * Example: 'domain_com_' or a random string
 */
define( 'WP_CACHE_KEY_SALT', 'unique_site_identifier_' );


/* ===========================================================================
   13. OBJECT CACHE (REDIS / MEMCACHED)
   =========================================================================== */

/**
 * Redis Object Cache Configuration
 * 
 * Settings for the Redis Object Cache plugin.
 * Dramatically improves performance by caching database queries.
 * 
 * Plugin: https://wordpress.org/plugins/redis-cache/
 */

// Redis connection settings
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );
define( 'WP_REDIS_PASSWORD', '' );
define( 'WP_REDIS_DATABASE', 0 );

// Redis key prefix - prevents collisions in shared Redis instances
define( 'WP_REDIS_PREFIX', 'domain_com_' );

// Connection timeouts (seconds)
define( 'WP_REDIS_TIMEOUT', 1 );
define( 'WP_REDIS_READ_TIMEOUT', 1 );

// Disable Redis (useful for debugging)
define( 'WP_REDIS_DISABLED', false );

// Use Redis for transients only (selective flush)
// define( 'WP_REDIS_SELECTIVE_FLUSH', true );

// Ignored cache groups (won't be stored in Redis)
// define( 'WP_REDIS_IGNORED_GROUPS', ['counts', 'plugins'] );

/**
 * Memcached Configuration
 * 
 * For sites using Memcached instead of Redis.
 * Requires Memcached plugin and server.
 */
// define( 'WP_CACHE_KEY_SALT', 'domain_com_' );
// $memcached_servers = array(
//     'default' => array( '127.0.0.1:11211' )
// );


/* ===========================================================================
   14. CRON CONFIGURATION
   =========================================================================== */

/**
 * Disable WP-Cron
 * 
 * Disable WordPress's pseudo-cron system.
 * Use with a real server cron job for better reliability and performance.
 * 
 * Server cron examples:
 * 
 * Every 5 minutes (recommended):
 * */5 * * * * wget -q -O - https://domain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
 * 
 * Using curl:
 * */5 * * * * curl -s https://domain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
 * 
 * Using WP-CLI (if available):
 * */5 * * * * cd /path/to/wordpress && wp cron event run --due-now >/dev/null 2>&1
 */
define( 'DISABLE_WP_CRON', false );

/**
 * Alternate Cron Method
 * 
 * Alternative method for firing cron when DISABLE_WP_CRON is false.
 * Uses a redirect-based approach that works better on some hosts.
 * Can help with cron reliability issues.
 */
define( 'ALTERNATE_WP_CRON', false );

/**
 * Cron Lock Timeout
 * 
 * Minimum time (seconds) between cron executions.
 * Prevents overlapping cron runs.
 * MINUTE_IN_SECONDS = 60
 */
define( 'WP_CRON_LOCK_TIMEOUT', 60 );


/* ===========================================================================
   15. POST REVISIONS & AUTOSAVE
   =========================================================================== */

/**
 * Post Revisions
 * 
 * Number of post revisions to keep.
 * 
 * Options:
 * - true: Keep all revisions (default, can bloat database)
 * - false: Disable revisions completely
 * - integer: Specific number to keep (recommended: 3-10)
 */
define( 'WP_POST_REVISIONS', 5 );

/**
 * Autosave Interval
 * 
 * How often (seconds) WordPress autosaves posts.
 * Default: 60 seconds
 * 
 * Recommendations:
 * - Default (60): Standard editing
 * - 120-300: Reduce server load
 * - 900+: Minimal autosaves (good for low-resource servers)
 * - 7200: Essentially disable autosave behavior
 */
define( 'AUTOSAVE_INTERVAL', 120 );


/* ===========================================================================
   16. TRASH SETTINGS
   =========================================================================== */

/**
 * Trash Auto-Empty
 * 
 * Days before trashed items are permanently deleted.
 * Set to 0 to disable trash (immediate permanent deletion).
 * Default: 30 days
 * Recommended: 14-30 days
 */
define( 'EMPTY_TRASH_DAYS', 14 );

/**
 * Media Trash
 * 
 * Enable trash functionality for media items.
 * When false, media deletions are permanent immediately.
 */
define( 'MEDIA_TRASH', true );


/* ===========================================================================
   17. UPDATES & FILE MODIFICATIONS
   =========================================================================== */

/**
 * Automatic Updates Master Switch
 * 
 * Completely disable all automatic updates.
 * Includes core, plugins, themes, and translations.
 */
define( 'AUTOMATIC_UPDATER_DISABLED', false );

/**
 * Core Auto-Updates
 * 
 * Control automatic WordPress core updates.
 * 
 * Options:
 * - true: Enable all core updates (major + minor)
 * - false: Disable all core updates
 * - 'minor': Only minor/security updates (recommended)
 */
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

/**
 * Plugin & Theme Auto-Updates
 * 
 * Note: Individual plugin/theme auto-updates are controlled via filters
 * in your theme's functions.php or a mu-plugin:
 * 
 * // Enable auto-updates for all plugins
 * add_filter( 'auto_update_plugin', '__return_true' );
 * 
 * // Enable auto-updates for all themes
 * add_filter( 'auto_update_theme', '__return_true' );
 */


/* ===========================================================================
   18. MULTISITE CONFIGURATION
   =========================================================================== */

/**
 * Enable Multisite Feature
 * 
 * Allows access to the Network Setup page.
 * After running setup, additional constants are required.
 */
// define( 'WP_ALLOW_MULTISITE', true );

/**
 * Multisite Configuration
 * 
 * These constants are added after Network Setup is complete.
 * WordPress generates these - copy from the setup page.
 */
// define( 'MULTISITE', true );
// define( 'SUBDOMAIN_INSTALL', false );  // true for subdomain, false for subdirectory
// define( 'DOMAIN_CURRENT_SITE', 'domain.com' );
// define( 'PATH_CURRENT_SITE', '/' );
// define( 'SITE_ID_CURRENT_SITE', 1 );
// define( 'BLOG_ID_CURRENT_SITE', 1 );

/**
 * Sunrise Drop-in
 * 
 * Load sunrise.php before WordPress loads.
 * Used for domain mapping and advanced multisite configurations.
 */
// define( 'SUNRISE', true );

/**
 * Multisite File Uploads
 * 
 * Maximum upload file size for non-super-admins (in KB).
 * Can also be set in Network Admin > Settings.
 */
// define( 'BLOG_UPLOAD_SPACE', 100 ); // MB per site
// define( 'UPLOAD_SPACE_CHECK_DISABLED', true );


/* ===========================================================================
   19. MAIL SETTINGS
   =========================================================================== */

/**
 * Mail Interval
 * 
 * Minimum time (seconds) between mail queue processing.
 * Affects wp_mail() for batch sending.
 */
// define( 'WP_MAIL_INTERVAL', 300 );


/* ===========================================================================
   20. PROXY CONFIGURATION
   =========================================================================== */

/**
 * HTTP Proxy Settings
 * 
 * Configure WordPress to use a proxy server for outbound HTTP requests.
 * Useful in corporate environments or for specific security requirements.
 */
// define( 'WP_PROXY_HOST', '192.168.1.100' );
// define( 'WP_PROXY_PORT', '8080' );
// define( 'WP_PROXY_USERNAME', '' );
// define( 'WP_PROXY_PASSWORD', '' );
// define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, domain.com, *.local' );


/* ===========================================================================
   21. EXTERNAL HTTP REQUESTS
   =========================================================================== */

/**
 * Block External HTTP Requests
 * 
 * Prevent WordPress from making outbound HTTP requests.
 * Security measure against malicious plugins/themes.
 * NOTE: Breaks many features - use WP_ACCESSIBLE_HOSTS to whitelist.
 */
define( 'WP_HTTP_BLOCK_EXTERNAL', false );

/**
 * Accessible Hosts Whitelist
 * 
 * Domains allowed when WP_HTTP_BLOCK_EXTERNAL is true.
 * Comma-separated list, wildcards (*) allowed for subdomains.
 * 
 * Common hosts to whitelist:
 * - api.wordpress.org (updates, plugin info)
 * - downloads.wordpress.org (core, plugin, theme downloads)
 * - *.github.com (many plugins fetch from GitHub)
 */
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org,*.github.com' );


/* ===========================================================================
   22. LANGUAGE & LOCALIZATION
   =========================================================================== */

/**
 * Site Language
 * 
 * WordPress locale code.
 * Requires corresponding .mo files in the languages directory.
 * Find codes at: https://translate.wordpress.org/
 * 
 * Common codes:
 * - '' (empty): English (US)
 * - 'en_AU': Australian English
 * - 'en_GB': British English
 * - 'de_DE': German
 * - 'fr_FR': French
 * - 'es_ES': Spanish
 */
define( 'WPLANG', 'en_AU' );

/**
 * Languages Directory
 * 
 * Custom location for language files.
 */
// define( 'WP_LANG_DIR', ABSPATH . 'wp-content/languages' );


/* ===========================================================================
   23. ERROR HANDLING & RECOVERY MODE
   =========================================================================== */

/**
 * Recovery Mode Email
 * 
 * Email address that receives recovery mode notifications.
 * Sent when a plugin/theme causes a fatal error.
 */
define( 'RECOVERY_MODE_EMAIL', 'admin@domain.com' );

/**
 * Disable Fatal Error Handler
 * 
 * Completely disable the fatal error handler.
 * No recovery mode, no admin notification emails.
 */
// define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );

/**
 * Sandbox Scraping (WSOD Protection)
 * 
 * Disable White Screen of Death (WSOD) protection.
 * When true, fatal errors won't trigger recovery mode.
 */
define( 'WP_SANDBOX_SCRAPING', false );

/**
 * Start Timestamp
 * 
 * Modify WordPress's request start time.
 * Used for performance measuring.
 */
// define( 'WP_START_TIMESTAMP', microtime( true ) );


/* ===========================================================================
   24. FTP/SSH CREDENTIALS
   =========================================================================== */

/**
 * FTP Credentials
 * 
 * Store FTP credentials for automatic updates.
 * SECURITY: Avoid storing credentials in config if possible.
 * Use proper file permissions (FS_METHOD = 'direct') instead.
 */
// define( 'FTP_USER', 'username' );
// define( 'FTP_PASS', 'password' );
// define( 'FTP_HOST', 'ftp.domain.com' );
// define( 'FTP_SSL', true );
// define( 'FTP_BASE', '/path/to/wordpress/' );
// define( 'FTP_CONTENT_DIR', '/path/to/wordpress/wp-content/' );
// define( 'FTP_PLUGIN_DIR', '/path/to/wordpress/wp-content/plugins/' );

/**
 * SSH2 Credentials
 * 
 * For updates via SSH2 PHP extension.
 */
// define( 'FTP_PUBKEY', '/home/user/.ssh/id_rsa.pub' );
// define( 'FTP_PRIKEY', '/home/user/.ssh/id_rsa' );


/* ===========================================================================
   25. PHP SETTINGS & SESSION SECURITY
   =========================================================================== */

/**
 * PHP Error Display
 * 
 * Control PHP error reporting independent of WordPress debug settings.
 * For production: Hide errors from visitors, log them instead.
 */
@ini_set( 'display_errors', '0' );
@ini_set( 'log_errors', '1' );
// @ini_set( 'error_log', '/path/to/php-error.log' );
@ini_set( 'error_reporting', E_ALL );

/**
 * Session Cookie Security
 * 
 * Harden PHP session cookies against common attacks.
 * 
 * session.cookie_httponly: Prevents JavaScript access to session cookies
 *                          Mitigates XSS attacks stealing sessions
 * 
 * session.cookie_secure: Only send cookies over HTTPS connections
 *                        Prevents session hijacking on insecure networks
 * 
 * session.use_only_cookies: Prevent session ID from being passed in URLs
 *                           Blocks session fixation attacks
 */
@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );

/**
 * Other PHP Settings
 * 
 * Additional PHP configuration that can supplement php.ini.
 * Place at the top of wp-config.php for earliest effect.
 */
// @ini_set( 'max_execution_time', 300 );
// @ini_set( 'memory_limit', '256M' );
// @ini_set( 'upload_max_filesize', '64M' );
// @ini_set( 'post_max_size', '64M' );


/* ===========================================================================
   26. PLUGIN-SPECIFIC CONSTANTS
   =========================================================================== */

/**
 * WP Rocket Configuration
 * 
 * Settings for WP Rocket caching plugin.
 * https://wp-rocket.me/
 */

// White label - removes WP Rocket branding from source code
define( 'WP_ROCKET_WHITE_LABEL_FOOTPRINT', true );

// White label - hides WP Rocket from the account dashboard
define( 'WP_ROCKET_WHITE_LABEL_ACCOUNT', true );

// License credentials (for agencies managing multiple sites)
// define( 'WP_ROCKET_EMAIL', 'your-email@domain.com' );
// define( 'WP_ROCKET_KEY', 'your-license-key' );

/**
 * UpdraftPlus Configuration
 * 
 * Settings for UpdraftPlus backup plugin.
 * https://wordpress.org/plugins/updraftplus/
 */

// Disable admin locking feature
// Useful when the locking feature causes issues or you want to ensure
// all admins can always access UpdraftPlus settings
define( 'UPDRAFTPLUS_NOADMINLOCK', true );

/**
 * WooCommerce Configuration
 * 
 * Settings for WooCommerce plugin.
 * https://woocommerce.com/
 */

// Increase memory for WooCommerce operations
// define( 'WP_MEMORY_LIMIT', '512M' );

// Enable WooCommerce logging
// define( 'WC_LOG_DIR', '/path/to/wc-logs/' );

/**
 * Yoast SEO Configuration
 * 
 * Settings for Yoast SEO plugin.
 * https://yoast.com/
 */

// Disable Yoast admin bar menu
// define( 'WPSEO_DISABLE_ADMIN_BAR_MENU', true );

/**
 * Gravity Forms Configuration
 * 
 * Settings for Gravity Forms plugin.
 * https://www.gravityforms.com/
 */

// License key for auto-updates
// define( 'GF_LICENSE_KEY', 'your-license-key' );

/**
 * ACF Pro Configuration
 * 
 * Settings for Advanced Custom Fields Pro.
 * https://www.advancedcustomfields.com/
 */

// Hide ACF menu from admin (production sites)
// define( 'ACF_LITE', true );

/**
 * Wordfence Configuration
 * 
 * Settings for Wordfence Security plugin.
 * https://www.wordfence.com/
 */

// Disable Wordfence auto-update
// define( 'WORDFENCE_DISABLE_LIVE_TRAFFIC', true );

/**
 * Query Monitor Configuration
 * 
 * Settings for Query Monitor debugging plugin.
 * https://wordpress.org/plugins/query-monitor/
 */

// Set Query Monitor cookie for debugging without login
// define( 'QM_ENABLE_CAPS_PANEL', true );


/* ===========================================================================
   27. MIGRATION HELPERS
   =========================================================================== */

/**
 * Site Migration via functions.php
 * 
 * When migrating a site to a new domain, you can temporarily add these
 * lines to your theme's functions.php or a mu-plugin to update URLs.
 * 
 * IMPORTANT: Remove immediately after the site loads correctly!
 * 
 * Add to functions.php:
 * 
 * update_option( 'siteurl', 'https://newdomain.com' );
 * update_option( 'home', 'https://newdomain.com' );
 * 
 * Alternative: Use WP-CLI
 * wp option update siteurl 'https://newdomain.com'
 * wp option update home 'https://newdomain.com'
 * 
 * For full search-replace of old domain:
 * wp search-replace 'https://olddomain.com' 'https://newdomain.com' --all-tables
 */

/**
 * Database Search Replace Tools
 * 
 * For complex migrations, use these tools:
 * 
 * 1. WP-CLI (command line):
 *    wp search-replace 'old-domain.com' 'new-domain.com' --all-tables --precise
 * 
 * 2. Interconnect/IT Search Replace DB:
 *    https://github.com/interconnectit/Search-Replace-DB
 *    (Delete after use - security risk if left accessible)
 * 
 * 3. Better Search Replace plugin:
 *    https://wordpress.org/plugins/better-search-replace/
 */


/* ===========================================================================
   28. MISCELLANEOUS
   =========================================================================== */

/**
 * Short Init
 * 
 * Load minimal WordPress - only basic database and user functions.
 * Useful for custom scripts that need WordPress functions
 * but not the full framework. Significantly faster loading.
 */
// define( 'SHORTINIT', true );

/**
 * Disable Theme Loading
 * 
 * Load WordPress without theme functionality.
 * Useful for API endpoints or scripts that don't need themes.
 */
// define( 'WP_USE_THEMES', false );

/**
 * Disable Block Patterns from WordPress.org
 * 
 * Prevent fetching remote block patterns.
 * Add this filter to functions.php or mu-plugin:
 * 
 * add_filter( 'should_load_remote_block_patterns', '__return_false' );
 */

/**
 * Disable XML-RPC
 * 
 * XML-RPC is often targeted by brute force attacks.
 * Better to disable via filter in functions.php:
 * 
 * add_filter( 'xmlrpc_enabled', '__return_false' );
 * 
 * Or block via .htaccess for better performance.
 */

/**
 * Disable REST API for non-logged-in users
 * 
 * Add to functions.php or mu-plugin:
 * 
 * add_filter( 'rest_authentication_errors', function( $result ) {
 *     if ( ! is_user_logged_in() ) {
 *         return new WP_Error( 'rest_forbidden', 'REST API restricted.', array( 'status' => 401 ) );
 *     }
 *     return $result;
 * });
 */


/* ===========================================================================
   CREATIVE GROUND PRODUCTION TEMPLATE
   
   Copy this block for quick setup of production sites.
   =========================================================================== */

/*
// == Creative Ground | www.creativeground.com.au - Production Config ==

// Performance
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
define( 'WP_CACHE', true );
define( 'COMPRESS_SCRIPTS', true );
define( 'COMPRESS_CSS', true );
define( 'CONCATENATE_SCRIPTS', true );
define( 'ENFORCE_GZIP', true );

// URLs (update these!)
define( 'WP_HOME', 'https://domain.com' );
define( 'WP_SITEURL', 'https://domain.com' );

// Security
define( 'FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_ADMIN', true );
define( 'DISALLOW_FILE_EDIT', true );

// Content management
define( 'AUTOSAVE_INTERVAL', 900 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 14 );

// Localization
define( 'WPLANG', 'en_AU' );

// Debugging (off for production)
@ini_set( 'display_errors', '0' );
@ini_set( 'error_reporting', E_ALL );
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );

// Session security
@ini_set( 'session.cookie_httponly', true );
@ini_set( 'session.cookie_secure', true );
@ini_set( 'session.use_only_cookies', true );

// WP Rocket white label
define( 'WP_ROCKET_WHITE_LABEL_FOOTPRINT', true );
define( 'WP_ROCKET_WHITE_LABEL_ACCOUNT', true );

// == Creative Ground - End ==
*/


/* ===========================================================================
   LOAD WORDPRESS
   
   This must be the last line in wp-config.php.
   Everything above must come before this require statement.
   =========================================================================== */

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
