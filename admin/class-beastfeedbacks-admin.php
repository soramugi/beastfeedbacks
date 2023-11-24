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
		$slug = 'beastfeedbacks';

		add_menu_page(
			"BeastFeedbacks",
			"BeastFeedbacks",
			'edit_pages',
			'edit.php?post_type=beastfeedbacks',
			'',
			'dashicons-feedback'
		);

		$labels = array(
			'name'               => 'Beastfeedbacks',
			'singular_name'      => 'Beastfeedback',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Beastfeedback',
			'edit_item'          => 'Edit Beastfeedback',
			'new_item'           => 'New Beastfeedback',
			'all_items'          => 'All Beastfeedbacks',
			'view_item'          => 'View Beastfeedback',
			'search_items'       => 'Search Beastfeedbacks',
			'not_found'          => 'No beastfeedbacks found',
			'not_found_in_trash' => 'No beastfeedbacks found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Beastfeedbacks'
		);

		$args = array(
			'labels'             => $labels,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'show_in_admin_bar'     => false,
			'public'                => false,
			'rewrite'               => false,
			'query_var'             => false,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
			'capabilities'          => array(
				'create_posts'        => 'do_not_allow',
				'publish_posts'       => 'publish_pages',
				'edit_posts'          => 'edit_pages',
				'edit_others_posts'   => 'edit_others_pages',
				'delete_posts'        => 'delete_pages',
				'delete_others_posts' => 'delete_others_pages',
				'read_private_posts'  => 'read_private_pages',
				'edit_post'           => 'edit_page',
				'delete_post'         => 'delete_page',
				'read_post'           => 'read_page',
			),
			'map_meta_cap'          => true,
		);

		register_post_type('beastfeedbacks', $args);
	}
}
