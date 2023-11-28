<?php
/**
 * ブロックエディタ
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/blocks
 */

/**
 * Block
 */
class BeastFeedbacks_Blocks {

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
	 * @param      string $beastfeedbacks       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $beastfeedbacks, $version ) {
		$this->beastfeedbacks = $beastfeedbacks;
		$this->version        = $version;
	}

	/**
	 * カスタムカテゴリに対応
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
		register_block_type(
			plugin_dir_path( __FILE__ ) . 'build/like/',
			array(
				'render_callback' => array( $this, 'render_callback_like' ),
			)
		);
		register_block_type( plugin_dir_path( __FILE__ ) . 'build/vote/' );
	}

	/**
	 * Likeの表示
	 *
	 * @param array  $attributes    Array containing the Jetpack AI Assistant block attributes.
	 * @param string $content String containing the Jetpack AI Assistant block content.
	 *
	 * @return string
	 */
	public function render_callback_like( $attributes, $content ) {
		$post_id = get_the_ID();
		$count   = BeastFeedbacks::get_like_count( $post_id );
		$nonce   = wp_create_nonce( 'beastfeedbacks_' . $post_id . '_nonce' );

		return vsprintf(
			'<div %s data-nonce="%s" data-id="%s">%s</div>',
			array(
				get_block_wrapper_attributes(),
				$nonce,
				$post_id,
				vsprintf(
					'<div class="wp-block-beastfeedbacks-like-balloon"><p class="like-count">%s</p></div>%s',
					array(
						$count,
						$content,
					)
				),

			)
		);
	}
}
