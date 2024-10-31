<?php

/**
 * Plugin Name:       Precise Plugin Updater
 * Plugin URI:        https://wordpress.org/plugins/precise-plugin-updater/
 * Description:       Choose what type of update is allowed for any single plugin: <strong>all</strong> - allows any updates; <strong>minor</strong> - preserves the first part of a version number; <strong>patch</strong> - preserves the first two parts; <strong>none</strong> - turns automatic updates off. Select default policy in settings->plugin updater
 * Version:           1.0.2
 * Author:            Cardinal90
 * Author URI:        https://github.com/Cardinal90
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ppu
 * Domain Path:       /languages
 */


if ( ! defined( 'WPINC' ) ) {
	exit;
}

require_once 'bootstrap.php';
