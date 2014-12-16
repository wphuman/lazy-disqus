<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wphuman.com/
 * @since             1.0.0
 * @package           Lazy_Disqus
 *
 * @wordpress-plugin
 * Plugin Name:       Lazy Disqus
 * Plugin URI:        https://wphuman.com/
 * Description:       Defer Disqus loading
 * Version:           1.0.0
 * Author:            Tang Rufus @ WP Human
 * Author URI:        https://wphuman.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lazy-disqus
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lazy-disqus-activator.php
 */
function activate_lazy_disqus( $network_wide ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lazy-disqus-activator.php';
	Lazy_Disqus_Activator::activate( $network_wide );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lazy-disqus-deactivator.php
 */
function deactivate_lazy_disqus() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lazy-disqus-deactivator.php';
	Lazy_Disqus_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lazy_disqus' );
register_deactivation_hook( __FILE__, 'deactivate_lazy_disqus' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-lazy-disqus.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lazy_disqus() {

	$plugin = new Lazy_Disqus();
	$plugin->run();

}
run_lazy_disqus();
