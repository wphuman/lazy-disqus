<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin/partials
 */


$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $this->get_options_tabs() ) ? $_GET[ 'tab' ] : 'general';

ob_start();
?>
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?> <em>by <a href="https://wphuman.com/">WP Human</a></em></h2>

	<?php settings_errors( 'lazy_disqus-notices' ); ?>

	<h2 class="nav-tab-wrapper">
		<?php
		foreach( $this->get_options_tabs() as $tab_id => $tab_name ) {

			$tab_url = add_query_arg( array(
				'settings-updated' => false,
				'tab' => $tab_id
				) );

			$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

			echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
			echo esc_html( $tab_name );
			echo '</a>';
		}
		?>
	</h2>
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

		<div class="postbox-container columns-2">

			<div id="postbox-container-2" class="postbox-container">

				<?php do_meta_boxes( 'lazy_disqus_settings_' . $active_tab, 'normal', $active_tab ); ?>

			</div><!-- .postbox-container-2-->

		</div><!-- .postbox-container.columns-2-->

			<div id="postbox-container-1" class="postbox-container">

				<?php do_meta_boxes( 'lazy_disqus_settings_side', 'side', $active_tab ); ?>

			</div><!-- .postbox-container-1-->

		</div><!-- #post-body-->

	</div><!-- #poststuff-->
</div><!-- .wrap -->
<?php
	echo ob_get_clean();
