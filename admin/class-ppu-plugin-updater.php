<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Decides, if a plugin should be updated automatically
 * by using auto_update_plugin filter
 */
class PPU_Plugin_Updater {

	public function __construct() {
		$this->init();
	}

	private function init() {
		add_filter( 'auto_update_plugin', array( $this, 'maybe_auto_update_plugin' ), 10, 2 );
	}

	public function maybe_auto_update_plugin( $update, $item ) {
		$new_version = explode( '.', $item->new_version );
		$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $item->plugin );
		$old_version = explode( '.', $plugin_data['Version'] );

		if ( $new_version[0] > $old_version[0] ) {
			$type = 'all';
		} elseif ( $new_version[1] > $old_version[1] ) {
			$type = 'minor';
		} else {
			$type = 'patch';
		}

		$option       = get_option( 'ppu_settings', array() );
		$default      = get_option( 'ppu_default_policy', 'all' );
		$encoded_name = sanitize_key( $plugin_data['Name'] );
		$update       = false;

		if ( isset( $option[ 'ppu_' . $encoded_name ] ) ) {
			$allowed = $option[ 'ppu_' . $encoded_name ];
		} elseif ( isset( $default ) ) {
			$allowed = $default;
		} else {
			$allowed = 'all';
		}

		if ( 'none' === $allowed ) {
			$update = false;
		} elseif ( 'patch' === $allowed && 'patch' === $type ) {
			$update = true;
		} elseif ( 'minor' === $allowed && ( 'minor' === $type || 'patch' === $type ) ) {
			$update = true;
		} elseif ( 'all' === $allowed ) {
			$update = true;
		}

		return $update;
	}
}
