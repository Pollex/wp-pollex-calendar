<?php

/**
 * Fired during plugin activation
 *
 * @link       https://pollex.nl/
 * @since      1.0.0
 *
 * @package    Pollex_Calendar
 * @subpackage Pollex_Calendar/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pollex_Calendar
 * @subpackage Pollex_Calendar/includes
 * @author     Pollex' <timvosch@pollex.nl>
 */
class Pollex_Calendar_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Pollex_Calendar_Activator::load_dependencies();
		Pollex_Calendar_Activator::db_installation();
	}

	/**
	 * Load dependencies.
	 * 
	 * @since 1.0.0
	 */
	private static function load_dependencies() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	}

	/**
	 * Create or update necessarry tables.
	 * 
	 * @since 1.0.0
	 */
	private static function db_installation() {
		Pollex_Calendar_Activator::db_install_events();
		Pollex_Calendar_Activator::db_install_event_series();
		Pollex_Calendar_Activator::db_install_event_attributes();
	}

	/**
	 * Create or update `pollex_calendar_events` table.
	 * 
	 * Create or update table `pollex_calendar_events` with columns
	 *  id, serieId, ownerId, startDate, endDate, title, description.
	 * 
	 * @since 1.0.0
	 */
	private static function db_install_events() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'pollex_calendar_events';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			serieId INT,
			ownerId INT NOT NULL,
			startDate DATETIME NOT NULL,
			endDate DATETIME NOT NULL,
			title varchar(255) NOT NULL,
			description TEXT,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}

	/**
	 * Create or update `pollex_calendar_event_series` table.
	 * 
	 * Create or update table `pollex_calendar_event_series` with columns:
	 *  id, type, ownerId.
	 * 
	 * @since 1.0.0
	 */
	private static function db_install_event_series() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'pollex_calendar_event_series';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			type INT NOT NULL,
			ownerId INT NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}

	/**
	 * Create or update `pollex_calendar_event_attributes` table.
	 * 
	 * Create or update table `pollex_calendar_event_attributes` with columns
	 *  id, eventId, attributeKey, attributeValue
	 * 
	 * @since 1.0.0
	 */
	private static function db_install_event_attributes() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'pollex_calendar_event_attributes';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			eventId INT NOT NULL,
			attributeKey varchar(255) NOT NULL,
			attributeValue TEXT NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";

		dbDelta($sql);
	}

}
