<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Processes ajax requests with new individual plugin settings
 */
class PPU_Plugin_Settings {

	public function __construct() {
		$this->init();
	}

	private function init() {
		add_action( 'wp_ajax_ppu_plugin_setting', array( $this, 'ppu_plugin_setting' ) );
	}

	public function ppu_plugin_setting() {
		if ( wp_verify_nonce( $_POST['nonce'], 'ppu-ajax-nonce' ) && current_user_can( 'install_plugins' ) ) {
			if ( isset( $_POST['name'] ) && isset( $_POST['value'] ) ) {
				$name  = sanitize_text_field( wp_unslash( $_POST['name'] ) );
				$value = sanitize_text_field( wp_unslash( $_POST['value'] ) );
				if ( in_array( $value, array( 'all', 'minor', 'patch', 'none' ), true ) ) {
					$option = get_option( 'ppu_settings', array() );

					$option[ $name ] = $value;

					if ( update_option( 'ppu_settings', $option ) ) {
						die( '1' );
					}
				}
			}
		}
		die( '0' );
	}
}
