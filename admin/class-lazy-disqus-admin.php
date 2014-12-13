<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin
 * @author     Tang Rufus @ WP Human <rufus@wphuman.com>
 */
class Lazy_Disqus_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lazy-disqus-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'postbox' );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		// Add a settings page for this plugin to the Settings menu.
		add_menu_page(
			__( 'Lazy Disqus', $this->plugin_name ),
			__( 'Lazy Disqus', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_admin_page' )
			);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'partials/lazy-disqus-display.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 	1.0.0
	 */
	public function get_options_tabs() {

		$tabs 					= array();
		$tabs['general']  		= __( 'General', $this->plugin_name );

		return apply_filters( 'lazy_disqus_settings_tabs', $tabs );
	}

	/**
	 * Show defered admin notices
	 *
	 * @since  1.0.0
	 * @see  http://stackoverflow.com/questions/9807064/wordpress-how-to-display-notice-in-admin-panel-on-plugin-activation
	 */
	public function show_enqueued_admin_notices() {

		$notices = Lazy_Disqus_Option::get_enqueued_admin_notices();

		// Quit early if nosaved  admin notices
		if ( empty( $notices ) ) {
			return;
		}

		foreach( $notices as $notice ) {
			echo "<div class='$notice[class]'><p>$notice[message]</p></div>";
		}

		Lazy_Disqus_Option::dequeue_admin_notices( $notices );

	} // end show_enqueued_admin_notices

}
