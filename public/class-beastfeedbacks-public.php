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

		$form_action = 'register_beastfeedbacks_form';
		add_action( 'wp_ajax_' . $form_action, array( $this, 'register_beastfeedbacks_form' ) );
		add_action( 'wp_ajax_nopriv_' . $form_action, array( $this, 'register_beastfeedbacks_form' ) );
	}

	/**
	 * アンケートフォームの受け取り処理
	 */
	public function register_beastfeedbacks_form() {
		check_ajax_referer( 'register_beastfeedbacks_form' );

		$params     = wp_unslash( $_POST );
		$id         = esc_attr( $params['id'] );
		$type       = esc_attr( $params['beastfeedbacks_type'] );
		$post       = get_post( $id );
		$post_id    = $post ? (int) $post->ID : 0; // 存在しているか確認.
		$ip_address = $this->get_ip_address();
		$user_agent = $this->get_user_agent();
		$time       = current_time( 'mysql' );
		$title      = "{$ip_address} - {$time}";

		$post_params = $params;
		$ignore_keys = array(
			'id',
			'beastfeedbacks_type',
			'action',
			'_wp_http_referer',
			'_wpnonce',
		);
		foreach ( $ignore_keys as $ignore_key ) {
			unset( $post_params[ $ignore_key ] );
		}
		$content = array(
			'user_agent'  => $user_agent,
			'ip_address'  => $ip_address,
			'type'        => $type,
			'post_params' => $post_params,
		);

		wp_insert_post(
			array(
				'post_date'    => $time,
				'post_type'    => 'beastfeedbacks',
				'post_status'  => 'publish',
				'post_parent'  => $post_id,
				'post_title'   => addslashes( wp_kses( $title, array() ) ),
				'post_name'    => md5( $title ),
				'post_content' => addslashes( wp_kses( wp_json_encode( $content, JSON_UNESCAPED_UNICODE ), array() ) ),
				'meta_input'   => array(
					'beastfeedbacks_type' => $type,
				),
			)
		);

		$message = ( 'survey' === $type )
			? 'アンケートへの回答ありがとうございました。'
			: '投票ありがとうございました。';
		$count   = ( 'like' === $type )
			? BeastFeedbacks::get_instance()->get_like_count( $post_id )
			: 1;

		$response_data = array(
			'success' => 1,
			'message' => $message,
			'count'   => $count,
		);

		wp_send_json( $response_data );
		wp_die();
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
