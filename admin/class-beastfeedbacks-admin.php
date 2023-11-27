<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/admin
 * @author     Your Name <email@example.com>
 */
class BeastFeedbacks_Admin {

	/**
	 * ポストタイプ
	 *
	 * @var string ポストタイプ.
	 */
	public $post_type = 'beastfeedbacks';

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
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->beastfeedbacks, plugin_dir_url( __FILE__ ) . 'css/beastfeedbacks-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->beastfeedbacks, plugin_dir_url( __FILE__ ) . 'js/beastfeedbacks-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * メニューページの登録
	 */
	public function add_menu_page() {
		add_menu_page(
			'BeastFeedbacks',
			'BeastFeedbacks',
			'edit_pages',
			'edit.php?post_type=' . $this->post_type,
			'',
			'dashicons-feedback'
		);

		register_post_type(
			$this->post_type,
			array(
				'labels'                => array(
					'name' => 'Beastfeedbacks',
				),

				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => false,
				'show_in_admin_bar'     => false,
				'show_in_rest'          => false,

				'rewrite'               => false,
				'query_var'             => false,

				'rest_controller_class' => '',

				'map_meta_cap'          => true,
				'capability_type'       => 'page',
				'capabilities'          => array(
					'create_posts' => 'do_not_allow',

					// 'delete_posts' => 'do_not_allow',
					// 'publish_posts'       => 'do_not_allow',
					// 'edit_post'           => 'do_not_allow',
					// 'edit_others_posts'   => 'edit_others_pages',
					// 'read_private_posts'  => 'read_private_pages',
					// 'read_post'           => 'read_page',
				),
			)
		);
	}

	/**
	 * プルダウンの一括操作、編集を削除
	 *
	 * @param array $actions List of actions available.
	 * @return array $actions
	 */
	public function admin_bulk_actions( $actions ) {
		global $current_screen;
		if ( 'edit-beastfeedbacks' !== $current_screen->id ) {
			return $actions;
		}

		unset( $actions['edit'] );
		return $actions;
	}

	/**
	 * タブ表示の整形
	 *
	 * @param array $views List of post views.
	 * @return array $views
	 */
	public function admin_view_tabs( $views ) {
		global $current_screen;
		if ( 'edit-beastfeedbacks' !== $current_screen->id ) {
			return $views;
		}

		unset( $views['publish'] );

		return $views;
	}

	/**
	 * 一覧で表示するカラム
	 */
	public function manage_posts_columns() {
		return array(
			'cb'                      => '<input type="checkbox" />',
			'beastfeedbacks_from'     => __( 'From', 'beastfeedbacks' ),
			'beastfeedbacks_source'   => __( 'Source', 'beastfeedbacks' ),
			'beastfeedbacks_type'     => __( 'Type', 'beastfeedbacks' ),
			'beastfeedbacks_date'     => __( 'Date', 'beastfeedbacks' ),
			'beastfeedbacks_response' => __( 'Response Data', 'beastfeedbacks' ),
		);
	}

	/**
	 * 一覧で表示する行
	 *
	 * @param string $column_name The name of the column to display.
	 * @param int    $post_id     The current post ID.
	 */
	public function manage_posts_custom_column( $column_name, $post_id ) {
		$list = array(
			'beastfeedbacks_from',
			'beastfeedbacks_source',
			'beastfeedbacks_type',
			'beastfeedbacks_date',
			'beastfeedbacks_response',
		);

		if ( ! in_array( $column_name, $list, true ) ) {
			return;
		}

		switch ( $column_name ) {
			case 'beastfeedbacks_date':
				echo esc_html( date_i18n( 'Y/m/d', get_the_time( 'U' ) ) );
				return;
			case 'beastfeedbacks_from':
				$meta = get_post_meta( $post_id, 'beastfeedbacks_from', true );
				echo esc_html( $meta );
				return;
			case 'beastfeedbacks_response':
				$post = get_post( $post_id );
				echo esc_html( $post->post_content );
				return;
			case 'beastfeedbacks_source':
				$post = get_post( $post_id );
				if ( ! isset( $post->post_parent ) ) {
					return;
				}

				$form_url   = get_permalink( $post->post_parent );
				$parsed_url = wp_parse_url( $form_url );

				printf(
					'<a href="%s" target="_blank" rel="noopener noreferrer">/%s</a>',
					esc_url( $form_url ),
					esc_html( basename( $parsed_url['path'] ) )
				);
				return;
			case 'beastfeedbacks_type':
				$meta = get_post_meta( $post_id, 'beastfeedbacks_type', true );
				echo esc_html( $meta );
				return;
		}
	}

	/**
	 * Add actions to beastfeedbacks response rows in WP Admin.
	 *
	 * @param string[] $actions Default actions.
	 * @return string[]
	 */
	public function manage_post_row_actions( $actions ) {
		global $post;

		if ( 'beastfeedbacks' !== $post->post_type ) {
			return $actions;
		}

		if ( 'publish' !== $post->post_status ) {
			return $actions;
		}

		unset( $actions['inline hide-if-no-js'] );
		unset( $actions['edit'] );

		return $actions;
	}

	/**
	 * Method untrash_beastfeedbacks_status_handler
	 * wp_untrash_post filter handler.
	 *
	 * @param string $current_status   The status to be set.
	 * @param int    $post_id          The post ID.
	 * @param string $previous_status  The previous status.
	 */
	public function untrash_beastfeedbacks_status_handler( $current_status, $post_id, $previous_status ) {
		$post = get_post( $post_id );
		if ( 'beastfeedbacks' === $post->post_type ) {
			if ( in_array( $previous_status, array( 'publish' ), true ) ) {
				return $previous_status;
			}
			return 'publish';
		}
		return $current_status;
	}
}
