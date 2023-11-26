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
class BeastFeedbacks_Admin
{

	public $postType = 'beastfeedbacks';

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
	 * @param      string    $beastfeedbacks       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($beastfeedbacks, $version)
	{
		$this->beastfeedbacks = $beastfeedbacks;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles()
	{
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

		wp_enqueue_style($this->beastfeedbacks, plugin_dir_url(__FILE__) . 'css/beastfeedbacks-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts()
	{
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

		wp_enqueue_script($this->beastfeedbacks, plugin_dir_url(__FILE__) . 'js/beastfeedbacks-admin.js', array('jquery'), $this->version, false);
	}

	public function add_menu_page()
	{
		add_menu_page(
			"BeastFeedbacks",
			"BeastFeedbacks",
			'edit_pages',
			'edit.php?post_type=' . $this->postType,
			'',
			'dashicons-feedback'
		);

		register_post_type($this->postType, array(
			'labels' => array(
				'name' => 'Beastfeedbacks',
			),

			'public' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_admin_bar' => false,
			'show_in_rest' => false,

			'rewrite' => false,
			'query_var' => false,

			'rest_controller_class' => '',

			'map_meta_cap' => true,
			'capability_type' => 'page',
			'capabilities' => array(
				'create_posts' => 'do_not_allow',

				// 'delete_posts' => 'do_not_allow',
				// 'publish_posts'       => 'do_not_allow',
				// 'edit_post'           => 'do_not_allow',
				// 'edit_others_posts'   => 'edit_others_pages',
				// 'read_private_posts'  => 'read_private_pages',
				// 'read_post'           => 'read_page',
			),
		));
	}

	/**
	 * 一覧で表示するカラム
	 */
	public function manage_posts_columns()
	{
		return array(
			'cb' => '<input type="checkbox" />',
			'beastfeedbacks_from' => __('From', 'beastfeedbacks'),
			'beastfeedbacks_source' => __('Source', 'beastfeedbacks'),
			'beastfeedbacks_type' => __('Type', 'beastfeedbacks'),
			'beastfeedbacks_date' => __('Date', 'beastfeedbacks'),
			'beastfeedbacks_response' => __('Response Data', 'beastfeedbacks'),
		);
	}

	public function manage_posts_custom_column($col, $post_id)
	{
		$post = get_post($post_id);

		$list = [
			'beastfeedbacks_from',
			'beastfeedbacks_source',
			'beastfeedbacks_type',
			'beastfeedbacks_date',
			'beastfeedbacks_response',
		];

		if (!in_array($col, $list, true)) {
			return;
		}

		switch ($col) {
			case 'beastfeedbacks_date':
				echo esc_html(date_i18n('Y/m/d', get_the_time('U')));
				return;
			case 'beastfeedbacks_from':
				echo 'TODO';
				// $this->grunion_manage_post_column_from($post);
				return;
			case 'beastfeedbacks_response':
				// $this->grunion_manage_post_column_response($post);
				return;
			case 'beastfeedbacks_source':
				// $this->grunion_manage_post_column_source($post);
				return;
			case 'beastfeedbacks_type':
				$metas = get_post_meta($post_id, 'beastfeedbacks_type');
				echo $metas[0];
				return;
		}
	}
}
