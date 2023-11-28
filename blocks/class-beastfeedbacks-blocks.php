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
		register_block_type( plugin_dir_path( __FILE__ ) . 'build/form/' );
		register_block_type( plugin_dir_path( __FILE__ ) . 'build/star/' );
	}

	/**
	 * Like数の取得
	 *
	 * @param integer $post_id Like登録に使用したpostを渡す.
	 */
	public function get_like_count( $post_id ) {
		$args  = array(
			'post_type'   => 'beastfeedbacks',
			'post_parent' => $post_id,
			'meta_query'  => array(
				array(
					'key'   => 'beastfeedbacks_type',
					'value' => 'like',
				),
			),
			'post_status' => 'publish',
		);
		$query = new WP_Query( $args );
		return $query->post_count;
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
		$count   = $this->get_like_count( $post_id );
		$nonce   = wp_create_nonce( 'beastfeedbacks_' . $post_id . '_nonce' );

		return vsprintf(
			'<div class="wp-block-beastfeedback-like-wrapper" %s data-nonce="%s" data-id="%s">%s</div>',
			array(
				get_block_wrapper_attributes(),
				$nonce,
				$post_id,
				vsprintf(
					'<div class="wp-block-beastfeedback-like-balloon"><p class="like-count">%s</p></div>%s',
					array(
						$count,
						$content,
					)
				),

			)
		);
	}

	/**
	 * Wp-jsonとしてAPI登録
	 */
	public function register_rest_route() {
		register_rest_route(
			'beastfeedbacks/v1',
			'/register',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'handle_register' ),
			)
		);
	}

	/**
	 * フォーム実行の値格納
	 *
	 * @param WP_REST_Request $request リクエスト.
	 */
	public function handle_register( WP_REST_Request $request ) {
		$params = $request->get_json_params();
		if (
			! isset( $params['beastfeedbacks_type'] )
			|| ! isset( $params['nonce'] )
			|| ! isset( $params['id'] )
		) {
			return new WP_Error();
		}

		$id  = esc_attr( $params['id'] );
		$key = 'beastfeedbacks_' . esc_attr( $params['id'] ) . '_nonce';

		if ( ! wp_verify_nonce( $params['nonce'], $key ) ) {
			return new WP_Error( 404, 'Security check' );
		}

		$post       = get_post( $id );
		$post_id    = $post ? (int) $post->ID : 0; // 存在しているか確認.
		$from       = $this->get_ip_address();
		$user_agent = $this->get_user_agent();
		$type       = esc_attr( $params['beastfeedbacks_type'] );
		$time       = current_time( 'mysql' );
		$title      = "{$from} - {$time}";

		wp_insert_post(
			array(
				'post_date'    => $time,
				'post_type'    => 'beastfeedbacks',
				'post_status'  => 'publish',
				'post_parent'  => $post_id,
				'post_title'   => addslashes( wp_kses( $title, array() ) ),
				'post_name'    => md5( $title ),
				'post_content' => wp_json_encode(
					array(
						'user_agent' => $user_agent,
					)
				),
				'meta_input'   => array(
					'beastfeedbacks_from' => $from,
					'beastfeedbacks_type' => $type,
				),
			)
		);

		$response_data = array(
			'success' => 1,
			'message' => '投票ありがとうございました。',
		);

		if ( 'like' === $type ) {
			$response_data['count'] = $this->get_like_count( $post_id );
		}

		return new WP_REST_Response( $response_data, 200 );
	}

	/**
	 * ユーザーエージェントの取得
	 *
	 * @return string
	 */
	private function get_user_agent() {
		return isset( $_SERVER['HTTP_USER_AGENT'] )
			? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) )
		   : ''; // @codingStandardsIgnoreLine
	}

	/**
	 * IPアドレスの取得
	 *
	 * @return string
	 */
	private function get_ip_address() {
		return isset( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
		: '';
	}
}
