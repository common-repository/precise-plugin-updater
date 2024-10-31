<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Adds plugin's settings into menu
 */
class PPU_Submenu {
	private $submenu_page;

	public function __construct( $submenu_page ) {
		$this->submenu_page = $submenu_page;
		$this->init();
	}

	private function init() {
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );
	}

	public function add_submenu_page() {
		add_submenu_page(
			'options-general.php',
			esc_html__( 'Plugin automatic updates options', 'ppu' ),
			esc_html__( 'Plugin updater', 'ppu' ),
			'install_plugins',
			'ppu_options',
			array( $this->submenu_page, 'render' )
		);
	}
}
