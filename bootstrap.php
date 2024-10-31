<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
	include_once $file;
}

class PPU_Bootstrap {
	public function __construct() {
		load_plugin_textdomain( 'ppu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		add_action( 'plugins_loaded', array( $this, 'start' ) );

		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	public function start() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
		$submenu_page    = new PPU_Submenu_Page();
		$submenu         = new PPU_Submenu( $submenu_page );
		$global_settings = new PPU_Global_Settings( $submenu_page );
		$plugin_page     = new PPU_Plugin_Page();
		$plugin_settings = new PPU_Plugin_Settings();
		$plugin_updater  = new PPU_Plugin_Updater();
	}

	public function register_admin_scripts( $hook ) {
		if ( 'plugins.php' !== $hook ) {
			return;
		}
		wp_register_script( 'ppu-admin-js', plugin_dir_url( __FILE__ ) . 'admin/js/precise-plugin-updater.js' );
		wp_enqueue_script( 'ppu-admin-js' );
		wp_register_style( 'ppu-admin-css', plugin_dir_url( __FILE__ ) . 'admin/css/precise-plugin-updater.css' );
		wp_enqueue_style( 'ppu-admin-css' );
	}

	public static function uninstall() {
		delete_option( 'ppu_settings' );
		delete_option( 'ppu_default_policy' );
	}
}

new PPU_Bootstrap();
