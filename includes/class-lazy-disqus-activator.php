<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/includes
 * @author     Tang Rufus @ WP Human <rufus@wphuman.com>
 */
class Lazy_Disqus_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate( $network_wide ) {

		// Lazy Disqus should never be network wide
		if ( $network_wide ) {

			deactivate_plugins( plugin_basename( __FILE__ ), true, true );
			wp_die( "Lazy Disqus doesn't work network wide.<br />See the <a href='https://wordpress.org/plugins/lazy-disqus/faq/'>FAQ</a> for more information.", 'Activation Error', array( 'back_link' => true ) );

		}
	}
}
