<?php
/**
 * ブロックエディタ
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/includes
 */

/**
 * Block
 */
class BeastFeedbacks_Block {

	/**
	 * ブロックで提供するタイプリスト
	 *
	 * @var array[string]
	 */
	public const TYPES = array(
		'like',
		'vote',
		'survey',
	);

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
		add_filter( 'block_categories_all', array( $this, 'block_categories_all' ), 10, 2 );
		add_action( 'init', array( $this, 'register_block_type' ) );
	}

	/**
	 * ブロックのカテゴリを追加
	 *
	 * @param array[]                 $block_categories     Array of categories for block types.
	 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
	 * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#block_categories_all
	 */
	public function block_categories_all( array $block_categories, WP_Block_Editor_Context $block_editor_context ) {
		if ( ! empty( $block_editor_context->post ) ) {
			array_push(
				$block_categories,
				array(
					'slug'  => 'beastfeedbacks',
					'title' => __( 'BeastFeedbacks', 'beastfeedbacks' ),
					'icon'  => null,
				)
			);
		}
		return $block_categories;
	}

	/**
	 * ブロックエディタの登録
	 */
	public function register_block_type() {
		register_block_type( plugin_dir_path( __DIR__ ) . 'build/like/' );
		register_block_type( plugin_dir_path( __DIR__ ) . 'build/vote/' );
		register_block_type( plugin_dir_path( __DIR__ ) . 'build/survey-form/' );
		register_block_type( plugin_dir_path( __DIR__ ) . 'build/survey-input/' );
		register_block_type( plugin_dir_path( __DIR__ ) . 'build/survey-select/' );
	}
}
