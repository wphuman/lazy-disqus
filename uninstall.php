<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}


// Important: Check if the file is the one
// that was registered during the uninstall hook.
if ( 'lazy-disqus/lazy-disqus.php' !== WP_UNINSTALL_PLUGIN )  {
	exit;
}

// Check if the $_REQUEST content actually is the plugin name
if ( ! in_array( 'lazy-disqus/lazy-disqus.php', $_REQUEST['checked'] ) ) {
	exit;
}

if ( 'delete-selected' !== $_REQUEST['action'] ) {
	exit;
}

// Check user roles.
if ( ! current_user_can( 'activate_plugins' ) ) {
	exit;
}

// Run an admin referrer check to make sure it goes through authentication
check_admin_referer( 'bulk-plugins' );

// Safe to carry on
if ( false !== get_option( 'lazy_disqus_enqueued_admin_notices' ) ) {
	delete_option( 'lazy_disqus_enqueued_admin_notices' );
}

if ( false !== get_option( 'lazy_disqus_settings' ) ) {
	delete_option( 'lazy_disqus_settings' );
}

if ( false !== get_option( 'lazy_disqus_version' ) ) {
	delete_option( 'lazy_disqus_version' );
}
