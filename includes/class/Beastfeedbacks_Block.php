<?php

class BeastFeedbacks_Block
{
	public static function init()
	{
		static $instance = false;

		if (!$instance) {
			$instance = new BeastFeedbacks_Block();
		}

		return $instance;
	}

	protected function __construct()
	{
		add_action('init', array($this, 'register_block_type'));
		add_filter('block_categories_all', array($this, 'block_categories_all'), 10, 2);
	}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function register_block_type()
	{
		register_block_type(BEASTFEEDBACKS_PLUGIN_PATH . 'blocks/build/vote/');
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
}
