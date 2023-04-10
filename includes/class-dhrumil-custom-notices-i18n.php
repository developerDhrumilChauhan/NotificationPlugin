<?php

/**
 * @since      1.0.0
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/includes
 * @author     Dhrumil Chauhan <dhrumilchauhan708@gmail.com>
 */
class Dhrumil_Custom_Notices_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dhrumil-custom-notices',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
