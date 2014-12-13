<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin/settings
 */
class Lazy_Disqus_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The array of plugin settings.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      array     $registered_settings    The array of plugin settings.
	 */
	private $registered_settings;

	/**
	 * The callback helper to render HTML elements for settings forms.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Lazy_Disqus_Callback_Helper    $callback    Render HTML elements.
	 */
	protected $callback;

	/**
	 * The sanitization helper to sanitize and validate settings.
	 *
	 * @since    1.4.0
	 * @access   protected
	 * @var      Lazy_Disqus_Sanitization_Helper    $sanitization    Sanitize and validate settings.
	 */
	protected $sanitization;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 	1.0.0
	 * @param 	string    					$plugin_name 			The name of this plugin.
	 * @param 	Lazy_Disqus_Callback_Helper 		$settings_callback
	 * @param 	Lazy_Disqus_Sanitization_Helper 	$settings_sanitization
	 */
	public function __construct( $plugin_name, $settings_callback, $settings_sanitization ) {

		$this->plugin_name = $plugin_name;
		$this->registered_settings = $this->set_registered_settings();

		$this->callback = $settings_callback;
		$this->sanitization = $settings_sanitization;

		$this->sanitization->set_registered_settings( $this->registered_settings );
	}

	/**
	 * Register all settings sections and fields.
	 *
	 * @since 	1.4.0
	 * @return 	void
	*/
	public function register_settings() {

		if ( false == get_option( 'lazy_disqus_settings' ) ) {
			add_option( 'lazy_disqus_settings' );
		}

		foreach( $this->registered_settings as $tab => $settings ) {

			// add_settings_section( $id, $title, $callback, $page )
			add_settings_section(
				'lazy_disqus_settings_' . $tab,
				__return_null(),
				'__return_false',
				'lazy_disqus_settings_' . $tab
				);

			foreach ( $settings as $option ) {

				$_name = isset( $option['name'] ) ? $option['name'] : '';

				// add_settings_field( $id, $title, $callback, $page, $section, $args )
				add_settings_field(
					'lazy_disqus_settings[' . $option['id'] . ']',
					$_name,
					method_exists( $this->callback, $option['type'] . '_callback' ) ? array( $this->callback, $option['type'] . '_callback' ) : array( $this->callback, 'missing_callback' ),
					'lazy_disqus_settings_' . $tab,
					'lazy_disqus_settings_' . $tab,
					array(
						'id'      => isset( $option['id'] ) ? $option['id'] : null,
						'desc'    => !empty( $option['desc'] ) ? $option['desc'] : '',
						'name'    => isset( $option['name'] ) ? $option['name'] : null,
						'section' => $tab,
						'size'    => isset( $option['size'] ) ? $option['size'] : null,
						'options' => isset( $option['options'] ) ? $option['options'] : '',
						'std'     => isset( $option['std'] ) ? $option['std'] : ''
						)
					);
			} // end foreach

		} // end foreach

		// Creates our settings in the options table
		register_setting( 'lazy_disqus_settings', 'lazy_disqus_settings', array( $this->sanitization, 'settings_sanitize' ) );

	}

	/**
	 * Set the array of plugin settings
	 *
	 * @since 	1.4.0
	 * @return 	array 	$settings
	*/
	private function set_registered_settings() {

	/**
	 * 'Whitelisted' Lazy_Disqus settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 */
	$settings = array(
		/** General Settings */
		'general' => apply_filters( 'lazy_disqus_settings_general',
			array(
				'disqus_shortname' => array(
					'id' => 'disqus_shortname',
					'name' => __( 'Disqus Usernames', $this->plugin_name ),
					'desc' => __( ' Your shortname is different than your username. <br />So, <a  target="_blank" href="https://help.disqus.com/customer/portal/articles/466208">what is a shortname?</a>', $this->plugin_name ),
					'type' => 'text'
					)
				) // end General Settings
			), // end apply_filters
				); // end $lazy_disqus_settings

	return $settings;

	} // end set_registered_settings

}
