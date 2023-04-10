<?php

/**
 * @since      1.0.0
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/includes
 * @author     Dhrumil Chauhan <dhrumilchauhan708@gmail.com>
 */

class Dhrumil_Custom_Notices {

	protected $loader;
	protected $plugin_name;
	protected $plugin_page_title;
	protected $plugin_menu_item_name;
	protected $version;

	public function __construct() {
		if ( defined( 'DHRUMIL_CUSTOM_NOTICES_VERSION' ) ) {
			$this->version = DHRUMIL_CUSTOM_NOTICES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'dhrumil-custom-notices';
		$this->plugin_page_title = "Send A Notice";
		$this->plugin_menu_item_name = "Send A Notice";

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dhrumil-custom-notices-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dhrumil-custom-notices-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dhrumil-custom-notices-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dhrumil-custom-notices-public.php';

		$this->loader = new Dhrumil_Custom_Notices_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Dhrumil_Custom_Notices_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Dhrumil_Custom_Notices_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_page_title(), $this->get_plugin_menu_item_name());

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_admin_menu_link' );
		$this->loader->add_filter( 'user_row_actions', $plugin_admin, 'add_custom_user_action', 10, 2);
	    
	}

	private function define_public_hooks() {

		$plugin_public = new Dhrumil_Custom_Notices_Public( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_page_title(), $this->get_plugin_menu_item_name());
        $this->loader->add_action( 'init', $plugin_public, 'add_notice_shortcode' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_login', $plugin_public, 'check_for_new_notices');
		$this->loader->add_action( 'wp_ajax_checkForNewNotices', $plugin_public, 'checkForNewNotices');
	}
	
	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_plugin_page_title() {
		return $this->plugin_page_title;
	}

	public function get_plugin_menu_item_name() {
		return $this->plugin_menu_item_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
