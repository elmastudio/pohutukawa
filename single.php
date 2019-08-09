<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */

get_header(); ?>

	<div id="content" class="entry-content">

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

		<nav id="nav-single" class="clearfix">
			<div class="nav-next"><?php next_post_link( '%link', __( 'Next Post &raquo;', 'pohutukawa' ) ); ?></div>
			<div class="nav-previous"><?php previous_post_link( '%link', __( '&laquo; Previous Post', 'pohutukawa' ) ); ?></div>
		</nav><!-- #nav-below -->

	</div><!--end #content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
