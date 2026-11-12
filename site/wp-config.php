<?php
/**
 * The base configuration for WordPress
 * Coalition Technologies Skills Test
 */

// ** Database settings ** //
$db_host = getenv('DB_HOST') ?: '127.0.0.1:3307';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';
$db_name = getenv('DB_NAME') ?: 'coalitiontest';

define( 'DB_NAME', $db_name );
define( 'DB_USER', $db_user );
define( 'DB_PASSWORD', $db_pass );
define( 'DB_HOST', $db_host );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY',         'Y{7@d9`q`w8F+sL&9W$bK4!v#x0Z>1mN~5pQ<2rT?8yU;3oP-6aE_4tI=8uO:1xV' );
define( 'SECURE_AUTH_KEY',  'T%2kL*9qW#4yP!8zO~1mN=5vR<7sB>3oX?6aE;4tI+8uY:0cF-2hJ@9gD_5wA&1rS' );
define( 'LOGGED_IN_KEY',    'M#8vP!4yQ~2kL<7sB>1mN=5rT?9wO;3oX+6aE:8uY*0cF-4tI@2hJ_9gD&1rS$5zA' );
define( 'NONCE_KEY',        'K!4yQ~2kL<7sB>1mN=5rT?9wO;3oX+6aE:8uY*0cF-4tI@2hJ_9gD&1rS$5zAW#8v' );
define( 'AUTH_SALT',        'N=5rT?9wO;3oX+6aE:8uY*0cF-4tI@2hJ_9gD&1rS$5zAW#8vP!4yQ~2kL<7sB>1m' );
define( 'SECURE_AUTH_SALT', 'O;3oX+6aE:8uY*0cF-4tI@2hJ_9gD&1rS$5zAW#8vP!4yQ~2kL<7sB>1mN=5rT?9w' );
define( 'LOGGED_IN_SALT',   'X+6aE:8uY*0cF-4tI@2hJ_9gD&1rS$5zAW#8vP!4yQ~2kL<7sB>1mN=5rT?9wO;3o' );
define( 'NONCE_SALT',       'E:8uY*0cF-4tI@2hJ_9gD&1rS$5zAW#8vP!4yQ~2kL<7sB>1mN=5rT?9wO;3oX+6a' );

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );
define( 'DISABLE_WP_CRON', true );

// Dynamic host handling so both coalitiontest.local and localhost work seamlessly
if ( isset( $_SERVER['HTTP_HOST'] ) ) {
    $http_host = $_SERVER['HTTP_HOST'];
    $protocol  = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' ) ? 'https://' : 'http://';
    define( 'WP_HOME', $protocol . $http_host );
    define( 'WP_SITEURL', $protocol . $http_host );
} else {
    define( 'WP_HOME', 'http://coalitiontest.local' );
    define( 'WP_SITEURL', 'http://coalitiontest.local' );
}

define( 'FS_METHOD', 'direct' );

/* That\'s all, stop editing! Happy publishing. */

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';

