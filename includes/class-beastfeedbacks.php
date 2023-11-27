<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    BeastFeedbacks
 * @subpackage BeastFeedbacks/includes
 * @author     Your Name <email@example.com>
 */
class BeastFeedbacks {


	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      BeastFeedbacks_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $beastfeedbacks    The string used to uniquely identify this plugin.
	 */
	protected $beastfeedbacks;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {
		if ( defined( 'BEASTFEEDBACKS_VERSION' ) ) {
			$this->version = BEASTFEEDBACKS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->beastfeedbacks = 'beastfeedbacks';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_blocks_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - BeastFeedbacks_Loader. Orchestrates the hooks of the plugin.
	 * - BeastFeedbacks_I18n. Defines internationalization functionality.
	 * - BeastFeedbacks_Admin. Defines all hooks for the admin area.
	 * - BeastFeedbacks_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-beastfeedbacks-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-beastfeedbacks-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-beastfeedbacks-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-beastfeedbacks-public.php';

		require_once plugin_dir_path( __DIR__ ) . 'blocks/class-beastfeedbacks-blocks.php';

		$this->loader = new BeastFeedbacks_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the BeastFeedbacks_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new BeastFeedbacks_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new BeastFeedbacks_Admin( $this->get_beastfeedbacks(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_page' );

		// add_filter( 'bulk_actions-edit-' . $plugin_admin->post_type, array( $this, 'grunion_admin_bulk_actions' ) );
		// add_filter( 'views_edit-' . $plugin_admin->post_type, array( $this, 'grunion_admin_view_tabs' ) );
		$this->loader->add_filter( 'manage_' . $plugin_admin->post_type . '_posts_columns', $plugin_admin, 'manage_posts_columns' );

		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'manage_posts_custom_column', 10, 2 );
		// $this->loader->add_action('restrict_manage_posts', array($this, 'grunion_source_filter'));
		// $this->loader->add_action('pre_get_posts', array($this, 'grunion_source_filter_results'));

		// $this->loader->add_filter('post_row_actions', array($this, 'grunion_manage_post_row_actions'), 10, 2);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new BeastFeedbacks_Public( $this->get_beastfeedbacks(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Block
	 */
	private function define_blocks_hooks() {
		$plugin_blocks = new BeastFeedbacks_Blocks( $this->get_beastfeedbacks(), $this->get_version() );

		$this->loader->add_filter( 'block_categories_all', $plugin_blocks, 'block_categories_all', 10, 2 );
		$this->loader->add_action( 'rest_api_init', $plugin_blocks, 'register_rest_route' );
		$this->loader->add_action( 'init', $plugin_blocks, 'register_block_type' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_beastfeedbacks() {
		return $this->beastfeedbacks;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    BeastFeedbacks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
