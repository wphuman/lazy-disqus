<?php

/**
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/includes
 */

class Lazy_Disqus_Option {

	/**
	 * Get Settings
	 *
	 * Retrieves all plugin settings.
	 *
	 * @since 	1.0.0
	 * @return 	array Lazy Disqus settings
	 */
	static public function set_global_options() {

		global $lazy_disqus_options;

		$lazy_disqus_options = get_option( 'lazy_disqus_settings' );
		if ( empty( $lazy_disqus_options ) ) {
			$lazy_disqus_options = array();
		}

		$lazy_disqus_options = apply_filters( 'lazy_disqus_get_settings', $lazy_disqus_options );

	}

	/**
	 * Get an option
	 *
	 * Looks to see if the specified setting exists, returns default if not.
	 *
	 * @since 	1.0.0
	 * @return 	mixed
	 */
	static public function get_option( $key = '', $default = false ) {

		global $lazy_disqus_options;

		if ( empty( $lazy_disqus_options ) ) {
			self::set_global_options();
		}

		$value = !empty( $lazy_disqus_options[ $key ] ) ? $lazy_disqus_options[ $key ] : $default;
		$value = apply_filters( 'lazy_disqus_get_option', $value, $key, $default );
		return apply_filters( 'lazy_disqus_get_option_' . $key, $value, $key, $default );

	}

	/**
	 * Get enqueued admin notices
	 *
	 * Looks to see if notices exists, returns default if not.
	 *
	 * @since 	1.0.0
	 * @return 	array
	 */
	static public function get_enqueued_admin_notices( $default = array() ) {
		$notices = get_option( 'lazy_disqus_enqueued_admin_notices', $default );
		return apply_filters( 'lazy_disqus_get_enqueued_admin_notices', $notices, $default );
	}

	/**
	 * Enqueue an admin notice
	 *
	 * @since 	1.0.0
	 *
	 * @param   array 	$notices 	Notice to be enqueued
	 * @return 	array
	 */
	static public function enqueue_admin_notice( array $notice ) {

		// Early quit if no notices
		if ( empty( $notice ) ) {
			return;
		}

		$old_notices = self::get_enqueued_admin_notices();
		$new_notices = array_push( $old_notices, $notice );
		$new_notices = apply_filters( 'lazy_disqus_enqueue_admin_notice', $old_notices, $notice);

		delete_option( 'lazy_disqus_enqueued_admin_notices' );
		add_option( 'lazy_disqus_enqueued_admin_notices', $new_notices );

	}

	/**
	 * Delete enqueued admin notices
	 *
	 * @since  1.0.0
	 * @param  array  	$notices 		Notices to be dequeued
	 * @return void
	 */
	static public function dequeue_admin_notices( array $notices ) {

		// Early quit if no new admin notices
		if ( empty( $notices ) ) {
			return;
		}

		$old_notices = self::get_enqueued_admin_notices();

		// Early quit if no old admin notices
		if ( empty( $old_notices ) ) {
			return;
		}

		// @TODO Fix: multidimentional array_diff throws `Array to string conversion` notice
		$new_notices = array_diff( $old_notices, $notices );
		$new_notices = apply_filters( 'lazy_disqus_dequeue_admin_notices', $new_notices, $notices, $old_notices );

		delete_option( 'lazy_disqus_enqueued_admin_notices' );

		if ( !empty( $new_notices ) ) {
			add_option( 'lazy_disqus_enqueued_admin_notices', $new_notices );
		}

	}

}
