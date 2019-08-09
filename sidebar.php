<?php
/**
 * The Sidebar containing the widget areas.
 
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */
?>

	<div id="sidebar">

		<nav id="main-nav">
			<?php
			$options = get_option('pohutukawa_theme_options');
			if( $options['menu_title'] != '' ) : ?>
				<h3><?php echo $options['menu_title']; ?></h3>
			<?php else: ?>
				<h3><?php _e('Menu', 'pohutukawa') ?></h3>
			<?php endif  ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- end #main-nav -->

		<?php if ( is_active_sidebar( 'widget-area-main' ) ) : ?>
			<div class="widget-area">
				<?php dynamic_sidebar( 'widget-area-main' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>

	</div><!-- end #sidebar -->