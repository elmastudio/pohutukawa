<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!--end .entry-header -->

	<footer class="entry-meta">
		<ul>
			<li class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
			<li class="post-author"><?php _e('by', 'pohutukawa') ?>
				<?php
					printf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'pohutukawa' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					sprintf( esc_attr__( 'All posts by %s', 'pohutukawa' ), get_the_author() ),
					get_the_author() );
					?>
			</li>
			<li class="post-comments"><?php comments_popup_link( __( '0 comments', 'pohutukawa' ), __( '1 comment', 'pohutukawa' ), __( '% comments', 'pohutukawa' ), 'comments-link', __( 'comments off', 'pohutukawa' ) ); ?></li>
			<li class="post-edit"><?php edit_post_link(__( 'Edit this post', 'pohutukawa') ); ?></li>
		</ul>
	</footer><!-- end .entry-meta -->

	<div class="entry-content">
		<?php if ( has_post_thumbnail() ): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>
		<?php the_content(); ?>	
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'pohutukawa' ), 'after' => '</div>' ) ); ?>
	</div><!-- end .entry-content -->

	<div class="single-posts-meta">

		<?php if ( get_post_format() ) : // Show author bio only for standard post format posts ?>
			
		<?php else: ?>

			<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
				<div class="author-info">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'pohutukawa_author_bio_avatar_size', 70 ) ); ?>
					<div class="author-description">
						<h3><?php printf( __( 'Posted by %s', 'pohutukawa' ), "<a href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a>" ); ?></h3>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div><!-- end .author-description -->			
				</div><!-- end .author-info -->

			<?php endif; ?>

		<?php endif; ?>

			<ul>
				<li class="cats"><span><?php _e('Category:', 'pohutukawa') ?></span> <?php the_category( ' ' ); ?></li>
				<?php $tags_list = get_the_tag_list( '', ', ' ); 
				if ( $tags_list ): ?>	
				<li class="tags"><span><?php _e('Tags:', 'pohutukawa') ?></span> <?php the_tags( '', ' ', '' ); ?></li>
				<?php endif; ?>

				<?php // Include Share-Btns on single posts page
				$options = get_option('pohutukawa_theme_options');
				if($options['share-singleposts'] or $options['share-posts']) : ?>
					<?php get_template_part( 'share'); ?>
				<?php endif; ?>

			</ul>
	</div><!-- end .single-posts-meta -->

</article><!-- end .post-<?php the_ID(); ?> -->