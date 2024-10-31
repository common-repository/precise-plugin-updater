<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Creates and processes plugin settings on the backend
 */
class PPU_Global_Settings {
	private $submenu_page;

	public function __construct( $submenu_page ) {
		$this->submenu_page = $submenu_page;
		$this->init();
	}

	private function init() {
		add_action( 'admin_init', array( $this, 'initialize_settings' ) );
	}

	public function initialize_settings() {
		if ( false === get_option( 'ppu_default_policy', false ) ) {
			add_option( 'ppu_default_policy', 'all' );
		}

		add_settings_section(
			'ppu_settings_section',
			'',
			array( $this->submenu_page, 'display_settings_section' ),
			'ppu_options'
		);

		add_settings_field(
			'default_policy',
			esc_html__( 'Default policy', 'ppu' ),
			array( $this->submenu_page, 'display_default_policy_setting' ),
			'ppu_options',
			'ppu_settings_section'
		);

		register_setting(
			'ppu_default_policy',
			'ppu_default_policy',
			array( $this, 'validate_settings' )
		);
	}

	public function validate_settings( $input ) {
		if ( isset( $_POST['reset'] ) ) {
			add_settings_error( 'ppu_settings', 'SettingSlug', __( 'Your settings have been reset', 'ppu' ), 'updated' );
			delete_option( 'ppu_settings' );

			return 'all';
		} else {
			$output = sanitize_text_field( wp_unslash( $input ) );
			if ( in_array( $output, array( 'all', 'minor', 'patch', 'none' ), true ) ) {
				return apply_filters( 'ppu_validate_settings', $output, $input );
			} else {
				return apply_filters( 'ppu_validate_settings', get_option( 'ppu_default_policy', 'all' ), $input );
			}
		}
	}


}
