<?php
/**
 * Plugin Name: Shared Counts
 * Plugin URI:  https://wordpress.org/plugins/shared-counts/
 * Description: WordPress plugin that leverages SharedCount.com API to quickly retrieve, cache, and display various social sharing counts.
 * Author:      Bill Erickson & Jared Atchison
 * Version:     1.0.0
 *
 * Shared Counts is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Shared Counts is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Shared Counts. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    SharedCounts
 * @author     Bill Erickson & Jared Atchison
 * @since      1.0.0
 * @license    GPL-2.0+
 * @copyright  Copyright (c) 2017
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Basic plugin constants.
 */
// Version.
define( 'SHARED_COUNTS_VERSION', '1.0.0' );

// Directory path.
define( 'SHARED_COUNTS_DIR', plugin_dir_path( __FILE__ ) );

// Directory URL.
define( 'SHARED_COUNTS_URL', plugin_dir_url( __FILE__ ) );

// Base name.
define( 'SHARED_COUNTS_BASE', plugin_basename( __FILE__ ) );

// Plugin root file.
define( 'SHARED_COUNTS_FILE', __FILE__ );

/**
 * We require a modern supported version of PHP (5.6+).
 */
if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {

	/**
	 * Deactivate plugin.
	 *
	 * @since 1.0.0
	 */
	add_action( 'admin_init', function() {

		deactivate_plugins( plugin_basename( __FILE__ ) );
	} );

	/**
	 * Display notice after deactivation.
	 *
	 * @since 1.0.0
	 */
	add_action( 'admin_notices', function() {

		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Shared Counts requires PHP 5.6+. Contact your web host to update.', 'shared-counts' ) . '</p></div>';

		if ( isset( $_GET['activate'] ) ) { // WPCS: CSRF ok.
			unset( $_GET['activate'] ); // WPCS: CSRF ok.
		}
	} );

} else {

	/**
	 * Load the primary.
	 */
	require_once SHARED_COUNTS_DIR . 'includes/class-shared-counts.php';

	/**
	 * The function provides access to the sharing methods.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	function shared_counts() {

		return Shared_Counts::instance();
	}
	shared_counts();
}