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
		/**
		 * TODO: カスタムカテゴリに対応
		 * https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
		 * https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#block_categories_all
		 */

		register_block_type(BEASTFEEDBACKS_PLUGIN_PATH . 'blocks/build/vote/');
	}
}
