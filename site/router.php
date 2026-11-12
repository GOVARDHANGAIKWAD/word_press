<?php
/**
 * PHP Built-in Server Router for WordPress
 */
$root = __DIR__;
$uri  = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

// 1. Serve static files and standalone PHP scripts directly
if ( '/' !== $uri && file_exists( $root . $uri ) && ! is_dir( $root . $uri ) ) {
	return false;
}

// 2. Serve subdirectories that have their own index.php (such as /wp-admin/)
$trimmed_uri = rtrim( $uri, '/' );
if ( is_dir( $root . $uri ) && file_exists( $root . $trimmed_uri . '/index.php' ) && $trimmed_uri !== '' ) {
	$_SERVER['SCRIPT_NAME'] = $trimmed_uri . '/index.php';
	chdir( $root . $trimmed_uri );
	require_once $root . $trimmed_uri . '/index.php';
	return;
}

// 3. Fallback to main WordPress index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
chdir( $root );
require_once $root . '/index.php';
