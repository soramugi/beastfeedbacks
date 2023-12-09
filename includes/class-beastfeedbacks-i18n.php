<?php
/**
 * 翻訳
 *
 * @link       https://beastfeedbacks.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/includes
 */

/**
 * 翻訳
 */
class BeastFeedbacks_I18n {

	/**
	 * Self class
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * @return self
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Init
	 */
	public function init() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'init', array( $this, 'wp_set_script_translations' ) );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			BEASTFEEDBACKS_DOMAIN,
			false,
			BEASTFEEDBACKS_DIR . 'languages'
		);
	}

	/**
	 * ブロックエディタ用の翻訳
	 */
	function wp_set_script_translations() {
		wp_set_script_translations(
			BEASTFEEDBACKS_DOMAIN . '-script',
			BEASTFEEDBACKS_DOMAIN,
			BEASTFEEDBACKS_DIR . 'languages',
		);
	}
}
