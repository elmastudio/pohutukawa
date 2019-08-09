<?php
/**
 * The template for displaying image attachments.
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */

get_header(); ?>

<div id="content" class="entry-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!--end .entry-header -->

		<footer class="entry-meta">
			<ul>
				<li class="post-date"><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></li>
				<li class="post-comments"><?php comments_popup_link( __( '0 comments', 'pohutukawa' ), __( '1 comment', 'pohutukawa' ), __( '% comments', 'pohutukawa' ), 'comments-link', __( 'comments off', 'pohutukawa' ) ); ?></li>
				<li class="post-edit"><?php edit_post_link(__( 'Edit this post', 'pohutukawa') ); ?></li>
			</ul>
		</footer><!-- end .entry-meta -->

		<div class="entry-content">
			<div class="attachment">
<?php
	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
	 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
	 */
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
						<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php
							$attachment_size = apply_filters( 'theme_attachment_size', 1200 );
							echo wp_get_attachment_image( $post->ID, array( $attachment_size, 1200 ) ); // filterable image width with 1200px limit for image height.
						?></a>

						<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div><!-- .attachment -->
				</div><!-- .entry-content -->

				<div class="single-posts-meta">
					 <ul>
					<?php if (function_exists('pohutukawa_simple_exif')) { ?>
						<?php pohutukawa_simple_exif($post->ID); ?>
					<?php } ?>

						<?php
						$metadata = wp_get_attachment_metadata();
						printf( __( '<li class="image-size"><span>Image Size:</span> <a href="%3$s" title="Link to full-size image">%4$s&times;%5$s pixels</a> </li>
						<li><span>Posted in:</span> <a href="%6$s" title="%7$s">%7$s</a></li>', 'pohutukawa' ),
							esc_attr( get_the_time() ),
							get_the_date(),
							esc_url( wp_get_attachment_url() ),
							$metadata['width'],
							$metadata['height'],
							esc_url( get_permalink( $post->post_parent ) ),
							get_the_title( $post->post_parent )
							);
						?>

					<?php // Include Share-Btns on single posts page
						$options = get_option('pohutukawa_theme_options');
						if($options['share-singleposts'] or $options['share-posts']) : ?>
						<?php get_template_part( 'share'); ?>
					<?php endif; ?>

				</div><!-- end .single-posts-meta -->

		</article><!-- #post-<?php the_ID(); ?> -->

			<?php comments_template(); ?>

				<nav id="image-nav"  class="clearfix">
					<span class="next-image"><?php next_image_link( false, __( 'Next Image &raquo;' , 'pohutukawa' ) ); ?></span>
					<span class="previous-image"><?php previous_image_link( false, __( '&laquo; Previous Image' , 'pohutukawa' ) ); ?></span>
				</nav><!-- #image-nav -->

	</div><!--end #content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
