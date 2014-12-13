<?php

/**
 * Fired during plugin upgrade.
 *
 * This class defines all code necessary to run during the plugin's update.
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin
 */
class Lazy_Disqus_Updater {

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
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	/**
	 *
	 * @since    1.0.0
	 */
	public function update() {

		$lazy_disqus_version = get_option( 'lazy_disqus_version', '0.0.1' );
		$lastest_version = '1.0.0';

		if ( $lazy_disqus_version == $lastest_version) {
			return;
		}

		$lazy_disqus_version = preg_replace( '/[^0-9.].*/', '', $lazy_disqus_version );

		// Upgrade from v1.3.0 or before
		if ( version_compare( $lazy_disqus_version, '1.0.0', '<' ) ) {
			$this->enqueue_new_install_admin_notice();
		}

		update_option( 'lazy_disqus_version', $lastest_version );

	}

	/**
	 *
	 * @since  1.4.2
	 * @return void
	 */
	private function enqueue_new_install_admin_notice() {

		$notice = array(
			'class'  => 'updated',
			'message' => sprintf( __( '<strong>Important: </strong>  Click <a href="%s"><strong>here</strong></a> to set your Disqus shortname.', $this->plugin_name ),
				admin_url( 'admin.php?page=lazy-disqus' )
				)
			);

		$this->enqueue_admin_notice( $notice );

	}


	/**
	 * Enqueue an admin notice to database
	 *
	 * @since  1.0.0
	 * @param  array  $notice
	 * @return void
	 */
	private function enqueue_admin_notice( array $notice ) {

	// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		Lazy_Disqus_Option::enqueue_admin_notice( $notice );

	}

}
