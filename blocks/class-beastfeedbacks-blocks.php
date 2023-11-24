<?php

class BeastFeedbacks_Blocks
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $beastfeedbacks    The ID of this plugin.
	 */
	private $beastfeedbacks;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $beastfeedbacks       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($beastfeedbacks, $version)
	{
		$this->beastfeedbacks = $beastfeedbacks;
		$this->version = $version;
	}

	/**
	 * カスタムカテゴリに対応
	 *
	 * https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#block_categories_all
	 */
	public function block_categories_all($block_categories, $editor_context)
	{
		if (!empty($editor_context->post)) {
			array_push(
				$block_categories,
				array(
					'slug'  => 'beastfeedbacks',
					'title' => __('BeastFeedbacks', 'beastfeedbacks'),
					'icon'  => null,
				)
			);
		}
		return $block_categories;
	}

	public function register_block_type()
	{
		register_block_type(plugin_dir_path(__FILE__) . 'build/like/', array(
			'render_callback' => array($this, 'render_callback_like'),
		));
		register_block_type(plugin_dir_path(__FILE__) . 'build/form/');
		register_block_type(plugin_dir_path(__FILE__) . 'build/star/');
	}

	public function render_callback_like()
	{
		$count = 0;
		return vsprintf(
			'<div %s data-nonce="%s">%s%s</div>',
			[
				get_block_wrapper_attributes(),
				wp_create_nonce('beastfeedbacks_nonce'),
				sprintf('<button>Like: <span class="count">%s</span></button>', $count),
				sprintf('<span style="display:none;" class="message">投票ありがとうございました</span>'),
			]
		);
	}

	public function register_rest_route()
	{
		register_rest_route('beastfeedbacks/v1', '/register', array(
			'methods' => 'POST',
			'callback' => array($this, 'handle_register')
		));
	}

	public function handle_register(WP_REST_Request $request)
	{
		$params = $request->get_json_params();
		if (!isset($params['beastfeedbacks']) || !isset($params['nonce'])) {
			return new WP_Error();
		}
		if (!wp_verify_nonce($params['nonce'], 'beastfeedbacks_nonce')) {
			return new WP_Error(404, 'Security check');
		}

		return new WP_REST_Response([
			'success' => 1,
			'count' => 3,
		], 200);
	}
}
