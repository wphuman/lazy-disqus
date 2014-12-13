<?php

/**
 * Load the disqus area
 *
 * @link       https://wphuman.com/
 * @since      1.0.0
 *
 * @package    Lazy_Disqus
 * @subpackage Lazy_Disqus/public/partials
 */

$disqus_shortname = Lazy_Disqus_Option::get_option( 'disqus_shortname' );
$disqus_identifier = get_permalink();
$disqus_title = get_the_title();
$disqus_url = get_permalink();

?>
<div id="comments" class="comments-area">
<div id='disqus_thread' class='disqus_thread'></div>
</div>
<script type='text/javascript'>
	var disqus_thread = document.getElementsByClassName('disqus_thread')[0],
	disqusLoaded=false;

	var disqus_shortname = '<?php echo $disqus_shortname; ?>';
	var disqus_identifier = '<?php echo $disqus_identifier; ?>';
	var disqus_title = '<?php echo $disqus_title; ?>';
	var disqus_url = '<?php echo $disqus_url; ?>';

	function loadDisqus() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		disqusLoaded = true;
	}
			//Get the offset of an object
	function findTop(obj) {
		var curtop = 0;
		if (obj.offsetParent) {
			do {
				curtop += obj.offsetTop;
			} while (obj = obj.offsetParent);
			return curtop;
		}
	}

	if(window.location.hash.indexOf('#disqus_thread') > 0)
		loadDisqus();

	if(disqus_thread) {
		var disqus_threadOffset = findTop(disqus_thread);

		window.onscroll = function() {
			if(!disqusLoaded && window.pageYOffset > disqus_threadOffset - 1500) {
				console.log('load disqus_thread, NOW!!');
				loadDisqus();
			}
		}
	}
</script>
