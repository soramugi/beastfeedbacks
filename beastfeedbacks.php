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
 * @package           create-block
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('BEASTFEEDBACKS_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once BEASTFEEDBACKS_PLUGIN_PATH . 'includes/auto-load.php';
