<?php
/*
Plugin Name: Sporting Reservations
Plugin URI: https://webservi.es
Description: Reservation for sporting (Alta usuarios y cambio de asientos)
Version: 1.0
Author: Webservi.es
Author URI: https://decodecms.com
Text Domain: dcms-reservation
Domain Path: languages
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/
namespace dcms\reservation;

require __DIR__ . '/vendor/autoload.php';

use dcms\reservation\includes\Plugin;
use dcms\reservation\includes\Submenu;
use dcms\reservation\includes\Enqueue;
use dcms\reservation\includes\Database;
use dcms\reservation\includes\Process;
use dcms\reservation\includes\Shortcode;
use dcms\reservation\includes\Export;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class to handle settings constants and loading files
**/
final class Loader{

	// Define all the constants we need
	public function define_constants(){
		define ('DCMS_RESERVATION_VERSION', '1.1');
		define ('DCMS_RESERVATION_PATH', plugin_dir_path( __FILE__ ));
		define ('DCMS_RESERVATION_URL', plugin_dir_url( __FILE__ ));
		define ('DCMS_RESERVATION_BASE_NAME', plugin_basename( __FILE__ ));
		define ('DCMS_RESERVATION_SUBMENU', 'edit.php?post_type=events_sporting');

		// Ranges
		define ('DCMS_RANGE_NEW_USERS_START', 'dcms_start_change-seats');
		define ('DCMS_RANGE_NEW_USERS_END', 'dcms_end_change-seats');
		define ('DCMS_RANGE_CHANGE_SEAT_START', 'dcms_start_new-users');
		define ('DCMS_RANGE_CHANGE_SEAT_END', 'dcms_end_new-users');

		// Shortcode
		define ('DCMS_SHORTCODE_NEW_USER', 'dcms_alta_abonados');
	}

	// Load tex domain
	public function load_domain(){
		add_action('plugins_loaded', function(){
			$path_languages = dirname(DCMS_RESERVATION_BASE_NAME).'/languages/';
			load_plugin_textdomain('dcms-reservation', false, $path_languages );
		});
	}

	// Add link to plugin list
	public function add_link_plugin(){
		add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ){
			$cad = (strpos(DCMS_RESERVATION_SUBMENU,'?')) ? "&" : '?';
			return array_merge( array(
				'<a href="' . esc_url( admin_url( DCMS_RESERVATION_SUBMENU . $cad . 'page=reservation' ) ) . '">' . __( 'Settings', 'dcms-reservation' ) . '</a>'
			), $links );
		} );
	}

	// Initialize all
	public function init(){
		$this->define_constants();
		$this->load_domain();
		$this->add_link_plugin();
		new Plugin();
		new SubMenu();
		new Enqueue();
		new Database();
		new Process();
		new Shortcode();
		new Export();
	}

}

$dcms_RESERVATION_process = new Loader();
$dcms_RESERVATION_process->init();