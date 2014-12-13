<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/includes
 * @author     Tang Rufus @ WP Human <rufus@wphuman.com>
 */
class Lazy_Disqus {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Lazy_Disqus_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'lazy-disqus';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Lazy_Disqus_Loader. Orchestrates the hooks of the plugin.
	 * - Lazy_Disqus_i18n. Defines internationalization functionality.
	 * - Lazy_Disqus_Admin. Defines all hooks for the dashboard.
	 * - Lazy_Disqus_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lazy-disqus-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lazy-disqus-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lazy-disqus-options.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lazy-disqus-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lazy-disqus-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lazy-disqus-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lazy-disqus-meta-box.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lazy-disqus-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lazy-disqus-mailing-list-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lazy-disqus-updater.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-lazy-disqus-public.php';

		$this->loader = new Lazy_Disqus_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Lazy_Disqus_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Lazy_Disqus_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		// Run update scripts
		$plugin_updater = new Lazy_Disqus_Updater( $this->get_plugin_name() );
		$this->loader->add_action( 'admin_init', $plugin_updater, 'update' );

		$plugin_admin = new Lazy_Disqus_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Show defered admin notices
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_enqueued_admin_notices' );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Built the option page
		$settings_callback = new Lazy_Disqus_Callback_Helper( $this->plugin_name );
		$settings_sanitization = new Lazy_Disqus_Sanitization_Helper( $this->plugin_name );
		$plugin_settings = new Lazy_Disqus_Settings( $this->get_plugin_name(), $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );


		$plugin_meta_box = new Lazy_Disqus_Meta_Box( $this->get_plugin_name(), $plugin_admin->get_options_tabs() );
		$this->loader->add_action( 'load-toplevel_page_lazy-disqus' , $plugin_meta_box, 'add_meta_boxes' );

		$plugin_mailing_list_box = new Lazy_Disqus_Mailing_List_Box( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_lazy-disqus' , $plugin_mailing_list_box, 'add_meta_boxes' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->loader->add_action( 'init', 'Lazy_Disqus_Option', 'set_global_options' );

		$plugin_public = new Lazy_Disqus_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'comments_template', $plugin_public, 'load_comments_template', 0 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
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
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Lazy_Disqus_Loader    Orchestrates the hooks of the plugin.
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
