<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/public
 * @author     Tang Rufus @ WP Human <rufus@wphuman.com>
 */
class Lazy_Disqus_Public {

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
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * [load_comments_template description]
	 * @param  [type] $comment_template [description]
	 * @return [type]                   [description]
	 */
	public function load_comments_template( $comment_template ) {

		global $post;

		if ( !( is_singular() && 'open' == $post->comment_status ) ) {
			return;
		}

		return plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/lazy-disqus-public-display.php';
	}


}
