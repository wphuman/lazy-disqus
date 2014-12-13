<?php

/**
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/admin/partials
 */
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'lazy_disqus_settings' ); ?>
	<?php do_settings_sections( 'lazy_disqus_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />
