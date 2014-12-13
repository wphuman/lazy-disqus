<?php

/**
 * Lazy Disqus Callback Helper Class
 *
 * The callback functions of the options page
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin/settings
 */

class Lazy_Disqus_Callback_Helper {

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
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function missing_callback( $args ) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', $this->plugin_name ), $args['id'] );
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function header_callback( $args ) {
		echo '<hr/>';
	}

	/**
	 * Checkbox Callback
	 *
	 * Renders checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function checkbox_callback( $args ) {
		global $lazy_disqus_options;

		$checked = isset( $lazy_disqus_options[ $args[ 'id' ] ] ) ? checked( 1, $lazy_disqus_options[ $args[ 'id' ] ], false ) : '';
		$html = '<input type="checkbox" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']" value="1" ' . $checked . '/>';
		$html .= '<br />';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Multicheck Callback
	 *
	 * Renders multiple checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function multicheck_callback( $args ) {

		if ( empty( $args['options'] ) ) {
			return;
		}

		global $lazy_disqus_options;

		foreach( $args['options'] as $key => $option ) {

			if( isset( $lazy_disqus_options[$args['id']][$key] ) ) {
				$enabled = $option;
			} else {
				$enabled = NULL;
			}

			echo '<input name="lazy_disqus_settings[' . $args['id'] . '][' . $key . ']" id="lazy_disqus_settings[' . $args['id'] . '][' . $key . ']" type="checkbox" value="' . $option . '" ' . checked($option, $enabled, false) . '/>&nbsp;';
			echo '<label for="lazy_disqus_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';

		}

		echo '<p class="description">' . $args['desc'] . '</p>';

	}

	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function radio_callback( $args ) {
		global $lazy_disqus_options;

		foreach ( $args['options'] as $key => $option ) {
			$checked = false;

			if ( isset( $lazy_disqus_options[ $args['id'] ] ) && $lazy_disqus_options[ $args['id'] ] == $key ) {
				$checked = true;
			} elseif( isset( $args['std'] ) && $args['std'] == $key && ! isset( $lazy_disqus_options[ $args['id'] ] ) ) {
				$checked = true;
			}

			echo '<input name="lazy_disqus_settings[' . $args['id'] . ']"" id="lazy_disqus_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked(true, $checked, false) . '/>&nbsp;';
			echo '<label for="lazy_disqus_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';

		}

		echo '<p class="description">' . $args['desc'] . '</p>';
	}

	/**
	 * Text Callback
	 *
	 * Renders text fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function text_callback( $args ) {

		$this->input_type_callback( 'text', $args );

	}

	/**
	 * Email Callback
	 *
	 * Renders email fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function email_callback( $args ) {

		$this->input_type_callback( 'email', $args );

	}

	/**
	 * Url Callback
	 *
	 * Renders url fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function url_callback( $args ) {

		$this->input_type_callback( 'url', $args );

	}

	/**
	 * Input Type Callback
	 *
	 * Renders input type fields.
	 *
	 * @since 	1.0.0
	 * @param 	string $type Input Type
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	private function input_type_callback( $type, $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="' . $type . '" class="' . $size . '-text" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<br />';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function number_callback( $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$max  = isset( $args['max'] ) ? $args['max'] : 999999;
		$min  = isset( $args['min'] ) ? $args['min'] : 0;
		$step = isset( $args['step'] ) ? $args['step'] : 1;

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . $size . '-text" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<br />';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Textarea Callback
	 *
	 * Renders textarea fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function textarea_callback( $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<textarea class="large-text" cols="50" rows="5" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Password Callback
	 *
	 * Renders password fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function password_callback( $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="password" class="' . $size . '-text" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function select_callback( $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$html = '<select id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']"/>';

		foreach ( $args['options'] as $option => $option_name ) {
			$selected = selected( $option, $value, false );
			$html .= '<option value="' . $option . '" ' . $selected . '>' . $option_name . '</option>';
		}

		$html .= '</select>';
		$html .= '<br />';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Rich Editor Callback
	 *
	 * Renders rich editor fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @global 	$wp_version WordPress Version
	 */
	public function rich_editor_callback( $args ) {
		global $lazy_disqus_options, $wp_version;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
			ob_start();
			wp_editor( stripslashes( $value ), 'lazy_disqus_settings_' . $args['id'], array( 'textarea_name' => 'lazy_disqus_settings[' . $args['id'] . ']' ) );
			$html = ob_get_clean();
		} else {
			$html = '<textarea class="large-text" rows="10" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']">' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		}

		$html .= '<br/><label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

	/**
	 * Upload Callback
	 *
	 * Renders upload fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$lazy_disqus_options Array of all the Lazy Disqus Options
	 * @return 	void
	 */
	public function upload_callback( $args ) {
		global $lazy_disqus_options;

		if ( isset( $lazy_disqus_options[ $args['id'] ] ) ) {
			$value = $lazy_disqus_options[$args['id']];
		} else {
			$value = isset($args['std']) ? $args['std'] : '';
		}

		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';
		$html = '<input type="text" class="' . $size . '-text lazy_disqus_upload_field" id="lazy_disqus_settings[' . $args['id'] . ']" name="lazy_disqus_settings[' . $args['id'] . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		$html .= '<span>&nbsp;<input type="button" class="lazy_disqus_settings_upload_button button-secondary" value="' . __( 'Upload File', $this->plugin_name ) . '"/></span>';
		$html .= '<label for="lazy_disqus_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

		echo $html;
	}

}
