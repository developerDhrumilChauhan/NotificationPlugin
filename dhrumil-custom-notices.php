<?php

/**
 *
 * @link              https://www.dhrumilcustomnotices.com
 * @since             1.0.0
 * @package           Dhrumil_Custom_Notices
 *
 * @wordpress-plugin
 * Plugin Name:       Dhrumil's Custom Notice Plugin
 * Plugin URI:        https://www.dhrumilcustomnotices.com
 * Description:       This plugin allow to create custom notifications and display using a shortcode 
 * Version:           1.0.0
 * Author:            Dhrumil Chauhan
 * Author URI:        https://www.dhrumilcustomnotices.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dhrumil-custom-notices
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DHRUMIL_CUSTOM_NOTICES_VERSION', '1.0.0' );

function activate_dhrumil_custom_notices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dhrumil-custom-notices-activator.php';
	Dhrumil_Custom_Notices_Activator::activate();
}

function deactivate_dhrumil_custom_notices() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dhrumil-custom-notices-deactivator.php';
	Dhrumil_Custom_Notices_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dhrumil_custom_notices' );
register_deactivation_hook( __FILE__, 'deactivate_dhrumil_custom_notices' );

require plugin_dir_path( __FILE__ ) . 'includes/class-dhrumil-custom-notices.php';

function run_dhrumil_custom_notices() {

	$plugin = new Dhrumil_Custom_Notices();
	$plugin->run();
}

run_dhrumil_custom_notices();