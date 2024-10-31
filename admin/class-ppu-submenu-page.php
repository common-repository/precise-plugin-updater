<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Renders view for the settings page
 */
class PPU_Submenu_Page {

	/**
	 * The full settings page layout
	 */
	public function render() {
		?>
			<div class="wrap">

				<h2><?php esc_html_e( 'Precise plugin updater settings', 'ppu' ); ?></h2>

				<?php // settings_errors(); ?>
				<form method="post" action="options.php">
					<?php settings_fields( 'ppu_default_policy' ); ?>
					<?php do_settings_sections( 'ppu_options' ); ?>
					<?php submit_button(); ?>
					<p><?php esc_html_e( 'Reset all settings (including the individual plugin settings)', 'ppu' ); ?></p>
					<?php
					submit_button(
						esc_html__( 'Reset', 'ppu' ), 'secondary', 'reset', true, array(
							'id' => 'ppu_reset_settings',
						)
					);
					?>

				</form>
				<script>
					document.getElementById('ppu_reset_settings').addEventListener('click', function(e){
						if ( ! confirm(<?php echo '"' . esc_html__( 'Are you sure?', 'ppu' ) . '"'; ?>)) {
							e.preventDefault();
							e.stopPropagation();
						}
					});
				</script>

			</div>
		<?php
	}

	/**
	 * The single settings section
	 */
	public function display_settings_section() {
		?>
		<p><?php esc_html_e( 'Select default policy for automatic plugin updates. Go to plugins page to set rules for individual plugins.', 'ppu' ); ?></p>
		<p>
			<strong><?php esc_html_e( 'All', 'ppu' ); ?></strong><?php esc_html_e( ' - Install all updates automatically;', 'ppu' ); ?>
			<br>
			<strong><?php esc_html_e( 'Minor', 'ppu' ); ?></strong><?php esc_html_e( ' - Install an update only if the first part of a version number hasn\'t changed;', 'ppu' ); ?>
			<br>
			<strong><?php esc_html_e( 'Patch', 'ppu' ); ?></strong><?php esc_html_e( ' - Install an update only if the first and second parts of a version number are the same;', 'ppu' ); ?>
			<br>
			<strong><?php esc_html_e( 'None', 'ppu' ); ?></strong><?php esc_html_e( ' - Do not install any updates', 'ppu' ); ?>
			<br>
			<?php esc_html_e( 'Please note, that some plugins use two numbers for version instead of three - to update them automatically you need to turn on at least minor updates for them', 'ppu' ); ?></p>
		<?php

	}

	/**
	 * The only setting plugin has
	 */
	public function display_default_policy_setting() {
		$option = get_option( 'ppu_default_policy', 'all' );

		$html  = "<div><input type='radio' id='ppu_radio_all' name='ppu_default_policy' value='all'" . checked( 'all', $option, false ) . '/>';
		$html .= "<label for='ppu_radio_all'>" . esc_html__( 'All', 'ppu' ) . '</label></div>';

		$html .= "<div><input type='radio' id='ppu_radio_minor' name='ppu_default_policy' value='minor'" . checked( 'minor', $option, false ) . '/>';
		$html .= "<label for='ppu_radio_minor'>" . esc_html__( 'Minor', 'ppu' ) . '</label></div>';

		$html .= "<div><input type='radio' id='ppu_radio_patch' name='ppu_default_policy' value='patch'" . checked( 'patch', $option, false ) . '/>';
		$html .= "<label for='ppu_radio_patch'>" . esc_html__( 'Patch', 'ppu' ) . '</label></div>';

		$html .= "<div><input type='radio' id='ppu_radio_none' name='ppu_default_policy' value='none'" . checked( 'none', $option, false ) . '/>';
		$html .= "<label for='ppu_radio_none'>" . esc_html__( 'None', 'ppu' ) . '</label></div>';

		echo $html;
	}


}
