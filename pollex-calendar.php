<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pollex.nl/
 * @since             1.0.0
 * @package           Pollex_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       Pollex Calendar
 * Plugin URI:        https://pollex.nl/plugins/pollex-calendar
 * Description:       Display your (recurring-)events to your visitors.
 * Version:           1.0.0
 * Author:            Pollex'
 * Author URI:        https://pollex.nl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pollex-calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'POLLEX_CALENDAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pollex-calendar-activator.php
 */
function activate_pollex_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pollex-calendar-activator.php';
	Pollex_Calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pollex-calendar-deactivator.php
 */
function deactivate_pollex_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pollex-calendar-deactivator.php';
	Pollex_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pollex_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_pollex_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pollex-calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pollex_calendar() {

	$plugin = new Pollex_Calendar();
	$plugin->run();

}
run_pollex_calendar();
