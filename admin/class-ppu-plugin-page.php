<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Renders view for the plugins page
 */
class PPU_Plugin_Page {
	private $option;
	private $default;

	public function __construct() {
		$this->init();
	}

	private function init() {
		add_action( 'pre_current_active_plugins', array( $this, 'render_nonce' ) );
		add_filter( 'manage_plugins_columns', array( $this, 'add_column' ) );
		add_action( 'manage_plugins_custom_column', array( $this, 'render_column' ), 10, 3 );
	}

	public function render_nonce() {
		echo '<span id="ppu-ajax-nonce" class="hidden">' . esc_html( wp_create_nonce( 'ppu-ajax-nonce' ) ) . '</span>';
	}

	/**
	 * Adds our custom column on manage_plugins_columns filter
	 */
	public function add_column( $columns ) {
		/*
		* Uncomment next line to test on next plugins page load.
		* Also go to wp-admin/includes/class-wp-automatic-updater.php and comment out 3 conditions at the top of function run()
		*/
		// wp_maybe_auto_update();
		$columns['ppu'] = esc_html__( 'Automatic updates', 'ppu' );

		return $columns;
	}

	/**
	 * Renders a radio input for a plugin. This is called once for every plugin
	 * on manage_plugins_custom_column action. Uses private properties
	 * $option and $default to cache option values between calls
	 */
	public function render_column( $column_name, $plugin_file, $plugin_data ) {
		if ( 'ppu' === $column_name && current_user_can( 'install_plugins' ) ) {
			$encoded_name = sanitize_key( $plugin_data['Name'] );

			if ( ! isset( $this->option ) ) {
				$this->option  = get_option( 'ppu_settings', array() );
				$this->default = get_option( 'ppu_default_policy', 'all' );
			}

			if ( isset( $this->option[ 'ppu_' . $encoded_name ] ) ) {
				$value = $this->option[ 'ppu_' . $encoded_name ];
			} else {
				$value = $this->default;
			}

			$html  = '<div class = "ppu-container" style="font-size: 12px">';
			$html .= '<div class = "ppu-mobile-only">' . esc_html__( 'Automatic updates', 'ppu' ) . ':</div>';
			$html .= "<div><input type='radio' id='ppu_radio_all_{$encoded_name}' name='ppu_{$encoded_name}' value='all'" . checked( 'all', $value, false ) . '/>';
			$html .= "<label for='ppu_radio_all_{$encoded_name}'>" . esc_html__( 'All', 'ppu' ) . '</label></div>';

			$html .= "<div><input type='radio' id='ppu_radio_minor_{$encoded_name}' name='ppu_{$encoded_name}' value='minor'" . checked( 'minor', $value, false ) . '/>';
			$html .= "<label for='ppu_radio_minor_{$encoded_name}'>" . esc_html__( 'Minor', 'ppu' ) . '</label></div>';

			$html .= "<div><input type='radio' id='ppu_radio_patch_{$encoded_name}' name='ppu_{$encoded_name}' value='patch'" . checked( 'patch', $value, false ) . '/>';
			$html .= "<label for='ppu_radio_patch_{$encoded_name}'>" . esc_html__( 'Patch', 'ppu' ) . '</label></div>';

			$html .= "<div><input type='radio' id='ppu_radio_none_{$encoded_name}' name='ppu_{$encoded_name}' value='none'" . checked( 'none', $value, false ) . '/>';
			$html .= "<label for='ppu_radio_none_{$encoded_name}'>" . esc_html__( 'None', 'ppu' ) . '</label></div>';

			$html .= '</div>';
			echo $html;
		}
	}
}
