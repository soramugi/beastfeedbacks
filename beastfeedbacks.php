<?php
/**
 * Plugin Name:       BeastFeedbacks
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       beastfeedbacks
 *
 * @package create-block
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'get_plugin_data' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

define( 'BEASTFEEDBACKS_VERSION', $plugin_data['Version'] );
define( 'BEASTFEEDBACKS_DOMAIN', $plugin_data['TextDomain'] );

/**
 * プラグイン有効化
 */
function activate_beastfeedbacks() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-beastfeedbacks-activator.php';
	BeastFeedbacks_Activator::activate();
}

/**
 * プラグイン無効化
 */
function deactivate_beastfeedbacks() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-beastfeedbacks-deactivator.php';
	BeastFeedbacks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_beastfeedbacks' );
register_deactivation_hook( __FILE__, 'deactivate_beastfeedbacks' );

require plugin_dir_path( __FILE__ ) . 'includes/class-beastfeedbacks.php';
BeastFeedbacks::get_instance()->init();
