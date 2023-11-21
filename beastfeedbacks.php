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

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function beastfeedbacks_beastfeedbacks_block_init()
{
	register_block_type(__DIR__ . '/build');
}
add_action('init', 'beastfeedbacks_beastfeedbacks_block_init');

require_once BEASTFEEDBACKS_PLUGIN_PATH . 'includes/auto-load.php';
