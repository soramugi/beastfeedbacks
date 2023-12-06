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
 * @package BeastFeedbacks
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'BEASTFEEDBACKS_VERSION', '0.1.0' );
define( 'BEASTFEEDBACKS_DOMAIN', 'beastfeedbacks' );
define( 'BEASTFEEDBACKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEASTFEEDBACKS_URL', plugin_dir_url( __FILE__ ) );

/**
 * プラグイン有効化
 */
function beastfeedbacks_activate() {
	include_once BEASTFEEDBACKS_DIR . 'includes/class-beastfeedbacks-activator.php';
	BeastFeedbacks_Activator::activate();
}

/**
 * プラグイン無効化
 */
function beastfeedbacks_deactivate() {
	include_once BEASTFEEDBACKS_DIR . 'includes/class-beastfeedbacks-deactivator.php';
	BeastFeedbacks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'beastfeedbacks_activate' );
register_deactivation_hook( __FILE__, 'beastfeedbacks_deactivate' );

require BEASTFEEDBACKS_DIR . 'includes/class-beastfeedbacks.php';
BeastFeedbacks::get_instance()->init();
