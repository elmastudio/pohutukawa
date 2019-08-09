 <?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */
?>

	</div><!-- end #container -->

	<footer id="footer">

	<?php
	/* Include the Footer widget areas */
		if ( ! is_404() )
			get_sidebar( 'footer' );
	?>

		<div id="site-generator" class="clearfix">
			<a href="#header" class="top"><?php _e('&#8593; Back to Top &#8593;', 'pohutukawa') ?></a>

			<?php if ( is_active_sidebar( 'widget-area-footer-sociallinks' ) ) : ?>
				<div class="widget-area-footer-sociallinks">
					<?php dynamic_sidebar( 'widget-area-footer-sociallinks' ); ?>
				</div><!-- end .widget-area-footer-sociallinks -->
			<?php endif; ?>

			<?php
				$options = get_option('pohutukawa_theme_options');
				if($options['custom_footertext'] != '' ){
					echo stripslashes($options['custom_footertext']);
			} else { ?>

			<ul class="credit">
				<li>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?></li>
				<?php
					/* Include Privacy Policy link. */
					if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '<li>  // ', '</li>', 'pohutukawa');
					}
				?>
				<li><?php _e('<span class="slash"> //</span> Proudly powered by', 'pohutukawa') ?> <a href="https://wordpress.org/" ><?php _e('WordPress', 'pohutukawa') ?></a></li>
				<li><?php printf( __( '<span class="slash"> //</span> Theme: %1$s by %2$s', 'pohutukawa' ), 'Pohutukawa', '<a href="https://www.elmastudio.de/en/">Elmastudio</a>' ); ?></li>
				<?php } ?>
			</ul>

			<?php if (has_nav_menu( 'optional' ) ) {
				wp_nav_menu( array('theme_location' => 'optional', 'container' => 'nav' , 'container_class' => 'optional-nav', 'depth' => 1 ));}
			?>
		</div><!-- end #site-generator -->

	</footer><!-- end #footer -->
</div><!-- end #wrap -->

<?php // Include Facebook Google+ button code if the share post options are activated.
	$options = get_option('pohutukawa_theme_options');
	if($options['share-singleposts'] or $options['share-posts'] or $options['share-pages']) : ?>
	<script type="text/javascript">
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/<?php _e('en_US', 'pohutukawa') ?>/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
