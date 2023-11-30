<?php
/**
 * 管理画面
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/admin
 */

/**
 * 管理画面
 */
class BeastFeedbacks_Admin {

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
		wp_enqueue_style(
			BEASTFEEDBACKS_DOMAIN,
			plugin_dir_url( __FILE__ ) . 'css/beastfeedbacks-admin.css',
			array(),
			BEASTFEEDBACKS_VERSION,
			'all'
		);
		/* phpcs:ignore
		wp_enqueue_script(
			BEASTFEEDBACKS_DOMAIN,
			plugin_dir_url( __FILE__ ) . 'js/beastfeedbacks-admin.js',
			array( 'jquery' ),
			BEASTFEEDBACKS_VERSION,
			false
		);
		 */

		// フィードバックの管理ページの構築.
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		add_filter( 'bulk_actions-edit-' . $this->post_type, array( $this, 'admin_bulk_actions' ) );
		add_filter( 'views_edit-' . $this->post_type, array( $this, 'admin_view_tabs' ) );

		add_filter( 'post_row_actions', array( $this, 'manage_post_row_actions' ), 10, 2 );
		add_filter( 'wp_untrash_post_status', array( $this, 'untrash_beastfeedbacks_status_handler' ), 10, 3 );

		add_filter( 'manage_' . $this->post_type . '_posts_columns', array( $this, 'manage_posts_columns' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'manage_posts_custom_column' ), 10, 2 );

		add_action( 'restrict_manage_posts', array( $this, 'add_type_filter' ) );
		add_action( 'pre_get_posts', array( $this, 'type_filter_result' ) );
	}

	/**
	 * 追加する投稿タイプ、フィードバックの入力値の保存に活用
	 *
	 * @var string ポストタイプ.
	 */
	public $post_type = 'beastfeedbacks';

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
			case 'beastfeedbacks_response':
				$post    = get_post( $post_id );
				$content = json_decode( $post->post_content, true );
				if ( ! is_array( $content ) ) {
					return;
				}

				$type        = isset( $content['type'] )
					? $content['type']
					: '';
				$post_params = isset( $content['post_params'] )
					? $content['post_params']
					: array();
				?>
				<table>
					<tbody>
						<?php if ( 'vote' === $type ) : ?>
						<tr>
							<td>選択</td>
							<td><?php echo esc_html( $post_params['selected'] ); ?></td>
						</tr>
						<?php elseif ( 'survey' === $type ) : ?>
							<?php foreach ( $post_params as $key => $value ) : ?>
								<tr>
									<td><?php echo esc_html( $key ); ?></td>
									<td><?php echo esc_html( $value ); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif ?>
					</tbody>
				</table>
				<table>
					<tbody>
						<hr />
						<?php if ( isset( $content['ip_address'] ) ) : ?>
						<tr>
							<td>IP_Address</td>
							<td><?php echo esc_html( $content['ip_address'] ); ?></td>
						</tr>
						<?php endif ?>
						<?php if ( isset( $content['user_agent'] ) ) : ?>
						<tr>
							<td>UserAgent</td>
							<td><?php echo esc_html( $content['user_agent'] ); ?></td>
						</tr>
						<?php endif ?>
					</tbody>
				</table>
				<?php
				return;
			case 'beastfeedbacks_source':
				$post = get_post( $post_id );
				if ( ! isset( $post->post_parent ) ) {
					return;
				}

				$form_url   = get_permalink( $post->post_parent );
				$parsed_url = wp_parse_url( $form_url );

				printf(
					'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
					esc_url( $form_url ),
					esc_html( $parsed_url['path'] )
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

	/**
	 * Add a post filter dropdown at the top of the admin page.
	 *
	 * @return void
	 */
	public function add_type_filter() {
		$screen = get_current_screen();

		if ( 'edit-beastfeedbacks' !== $screen->id ) {
			return;
		}

		$selected_type = isset( $_GET['beastfeedbacks_type'] ) ? sanitize_key( $_GET['beastfeedbacks_type'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$select_types = BeastFeedbacks_Block::TYPES;

		$options = '';
		foreach ( $select_types as $select_type ) {

			$options .= sprintf(
				'<option value="%s" %s>%s</option>',
				$select_type,
				$selected_type === $select_type ? 'selected' : '',
				$select_type,
			);
		}

		?>
		<select name="beastfeedbacks_type">
			<option value=""><?php esc_html_e( 'All Types', 'beastfeedbacks' ); ?></option>
			<?php echo $options; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</select>
		<?php
	}

	/**
	 * Type フィルターの表示に対応
	 *
	 * @param WP_Query $query Current query.
	 *
	 * @return void
	 */
	public function type_filter_result( $query ) {
		$selected_type = isset( $_GET['beastfeedbacks_type'] ) ? sanitize_key( $_GET['beastfeedbacks_type'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ! $selected_type || 'beastfeedbacks' !== $query->query_vars['post_type'] ) {
			return;
		}

		$meta_query = array(
			array(
				'key'   => 'beastfeedbacks_type',
				'value' => $selected_type,
			),
		);

		$old_meta_query = $query->get( 'meta_query' );
		if ( $old_meta_query ) {
			$meta_query[] = $old_meta_query;
		}

		$query->set( 'meta_query', $meta_query );
	}
}
