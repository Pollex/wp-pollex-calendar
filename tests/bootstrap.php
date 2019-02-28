<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Pollex_Calendar
 */

$vendorDir = __DIR__ . '/../vendor';
 
if (!@include($vendorDir . '/autoload.php')) {
    die("You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install
");
}

/**
 * === Wordpress test suite autoload
 */
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	// $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
	$_tests_dir = dirname( dirname( __FILE__ ) ) . '/tmp/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/pollex-calendar.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
