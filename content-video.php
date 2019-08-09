<?php
/**
 * The template for displaying posts in the Video Post Format
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'pohutukawa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!--end .entry-header -->

	<footer class="entry-meta">
		<ul>
			<li class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
			<li class="post-comments"><?php comments_popup_link( __( '0 comments', 'pohutukawa' ), __( '1 comment', 'pohutukawa' ), __( '% comments', 'pohutukawa' ), 'comments-link', __( 'comments off', 'pohutukawa' ) ); ?></li>

			<?php // Include Share-Btns
				$options = get_option('pohutukawa_theme_options');
				if( $options['share-posts'] ) : ?>
				<?php get_template_part( 'share'); ?>
			<?php endif; ?>

			<li class="post-edit"><?php edit_post_link(__( 'Edit this post', 'pohutukawa') ); ?></li>
		</ul>
	</footer><!-- end .entry-meta -->

	<div class="entry-content">
		<?php the_content( __( 'Continue Reading', 'pohutukawa' ) ); ?>
	</div><!-- end .entry-content -->

</article><!-- end post -<?php the_ID(); ?> -->