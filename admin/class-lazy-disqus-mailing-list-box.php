<?php
/**
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin
 */

class Lazy_Disqus_Mailing_List_Box {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	/**
	 * Register the meta boxes on options page.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {

		add_meta_box(
				'mailing_list_box',							// Meta box ID
				__( 'WP Human Mailing List', $this->plugin_name ), 	// Meta box Title
				array( $this, 'render_meta_box' ),			// Callback defining the plugin's innards
				'lazy_disqus_settings_side',						// Screen to which to add the meta box
				'side'									// Context
				);

	}

	/**
	 * Print the meta box on options page.
	 *
	 * @since     1.0.0
	 */
	public function render_meta_box( $active_tab ) {

		require( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/lazy-disqus-mailing-list-box-display.php' );

	} // end render_meta_box

} //end Lazy_Disqus_Option_Box_Base
