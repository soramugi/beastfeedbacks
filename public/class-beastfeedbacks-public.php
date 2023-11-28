<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/public
 * @author     Your Name <email@example.com>
 */
class BeastFeedbacks_Public {


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
	 * @param      string $beastfeedbacks       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $beastfeedbacks, $version ) {
		$this->beastfeedbacks = $beastfeedbacks;
		$this->version        = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BeastFeedbacks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BeastFeedbacks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->beastfeedbacks, plugin_dir_url( __FILE__ ) . 'css/beastfeedbacks-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in BeastFeedbacks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The BeastFeedbacks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->beastfeedbacks, plugin_dir_url( __FILE__ ) . 'js/beastfeedbacks-public.js', array( 'jquery' ), $this->version, false );
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
		$key = 'beastfeedbacks_' . $id . '_nonce';

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
			$response_data['count'] = BeastFeedbacks::get_like_count( $post_id );
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
