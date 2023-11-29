<?php
/**
 * 公開用設定
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/public
 */

/**
 * 公開用設定
 */
class BeastFeedbacks_Public {

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
		/* phpcs:ignore
		wp_enqueue_style(
			BEASTFEEDBACKS_DOMAIN,
			plugin_dir_url( __FILE__ ) . 'css/beastfeedbacks-public.css',
			array(),
			BEASTFEEDBACKS_VERSION,
			'all'
		);
		wp_enqueue_script(
			BEASTFEEDBACKS_DOMAIN,
			plugin_dir_url( __FILE__ ) . 'js/beastfeedbacks-public.js',
			array( 'jquery' ),
			BEASTFEEDBACKS_VERSION,
			false
		);
		*/

		add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );
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
		$key = BeastFeedbacks_Block::get_instance()->get_rest_api_nonce_key( $id );

		if ( ! wp_verify_nonce( $params['nonce'], $key ) ) {
			return new WP_Error( 404, 'Security check' );
		}

		$post       = get_post( $id );
		$post_id    = $post ? (int) $post->ID : 0; // 存在しているか確認.
		$ip_address = $this->get_ip_address();
		$user_agent = $this->get_user_agent();
		$type       = esc_attr( $params['beastfeedbacks_type'] );
		$time       = current_time( 'mysql' );
		$title      = "{$ip_address} - {$time}";
		$content    = array(
			'user_agent' => $user_agent,
			'ip_address' => $ip_address,
		);

		if ( 'vote' === $type ) {
			$content['select']   = $params['select'];
			$content['selected'] = $params['selected'];
		}

		wp_insert_post(
			array(
				'post_date'    => $time,
				'post_type'    => 'beastfeedbacks',
				'post_status'  => 'publish',
				'post_parent'  => $post_id,
				'post_title'   => addslashes( wp_kses( $title, array() ) ),
				'post_name'    => md5( $title ),
				'post_content' => addslashes( wp_kses( wp_json_encode( $content, true ), array() ) ),
				'meta_input'   => array(
					'beastfeedbacks_type' => $type,
				),
			)
		);

		$response_data = array(
			'success' => 1,
			'message' => '投票ありがとうございました。',
		);

		if ( 'like' === $type ) {
			$response_data['count'] = BeastFeedbacks::get_instance()->get_like_count( $post_id );
		}

		return new WP_REST_Response( $response_data, 200 );
	}

	/**
	 * ユーザーエージェントの取得
	 *
	 * @return string
	 */
	public function get_user_agent() {
		return isset( $_SERVER['HTTP_USER_AGENT'] )
			? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) )
		   : ''; // @codingStandardsIgnoreLine
	}

	/**
	 * IPアドレスの取得
	 *
	 * @return string
	 */
	public function get_ip_address() {
		return isset( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
		: '';
	}
}
