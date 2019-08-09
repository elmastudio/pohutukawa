<?php
/**
 * The Footer widget area.
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */
?>

<?php
	if (   ! is_active_sidebar( 'widget-area-footer-1'  )
		&& ! is_active_sidebar( 'widget-area-footer-2' )
		&& ! is_active_sidebar( 'widget-area-footer-3'  )
	)
		return;
?>

	<div id="footer-widgets-wrap">
		<div id="footer-widget-area">

		<?php if ( is_active_sidebar( 'widget-area-footer-1' ) ) : ?>
			<div class="widget-area-footer-1">
				<?php dynamic_sidebar( 'widget-area-footer-1' ); ?>
			</div><!-- end .widget-area-footer-1 -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'widget-area-footer-2' ) ) : ?>
			<div class="widget-area-footer-2">
				<?php dynamic_sidebar( 'widget-area-footer-2' ); ?>
			</div><!-- end .widget-area-footer-2 -->
		<?php endif; ?>
		
		<?php if ( is_active_sidebar( 'widget-area-footer-3' ) ) : ?>
			<div class="widget-area-footer-3">
				<?php dynamic_sidebar( 'widget-area-footer-3' ); ?>
			</div><!-- end .widget-area-footer-3 -->
		<?php endif; ?>

		</div><!-- end #footer-widget-area -->
	</div><!-- end #footer-widgets-wrap -->