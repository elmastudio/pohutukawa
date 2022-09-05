<?php

/*-----------------------------------------------------------------------------------*/
/* Set the content width based on the theme's design and stylesheet.
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) )
	$content_width = 680;

/*-----------------------------------------------------------------------------------*/
/* Sets up theme defaults and registers support for various WordPress features.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Make theme available for translation. Translations can be added to the /languages/ directory.
	load_theme_textdomain( 'pohutukawa', get_template_directory() . '/languages' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for editor font sizes.
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name' => __( 'small', 'pohutukawa' ),
			'shortName' => __( 'S', 'pohutukawa' ),
			'size' => 15,
			'slug' => 'small'
		),
		array(
			'name' => __( 'regular', 'pohutukawa' ),
			'shortName' => __( 'M', 'pohutukawa' ),
			'size' => 17,
			'slug' => 'regular'
		),
		array(
			'name' => __( 'large', 'pohutukawa' ),
			'shortName' => __( 'L', 'pohutukawa' ),
			'size' => 21,
			'slug' => 'large'
		),
		array(
			'name' => __( 'larger', 'pohutukawa' ),
			'shortName' => __( 'XL', 'pohutukawa' ),
			'size' => 25,
			'slug' => 'larger'
		)
	) );

	// Add editor color palette.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'black', 'pohutukawa' ),
			'slug' => 'black',
			'color' => '#000000',
		),
		array(
			'name' => __( 'white', 'pohutukawa' ),
			'slug' => 'white',
			'color' => '#ffffff',
		),
		array(
			'name' => __( 'light grey', 'pohutukawa' ),
			'slug' => 'light-grey',
			'color' => '#999',
		),
		array(
			'name' => __( 'orange', 'pohutukawa' ),
			'slug' => 'orange',
			'color' => '#ef5722',
		),
		array(
		'name' => __( 'blue', 'pohutukawa' ),
		'slug' => 'blue',
		'color' => '#70A7C7',
		),
	) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'pohutukawa' ),
		'optional' => __( 'Optional Navigation (no sub menus supported)', 'pohutukawa' )
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'status', 'link', 'quote', 'image', 'gallery', 'video', 'audio' ) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'pohutukawa_custom_background_args', array(
		'default-color' => 'f0f0f0',
	) ) );

	// This theme allows users to set a custom header.
	$args = array(
		'width'         			=> 1400,
		'height'        			=> 440,
		'default-text-color'	=> '#222',
		'default-image' 			=> get_template_directory_uri() . '/images/headers/pohutukawa.jpg',
	);
	add_theme_support( 'custom-header', $args );

	}
	add_action( 'after_setup_theme', 'pohutukawa_setup' );

/*-----------------------------------------------------------------------------------*/
/* Create the Theme Options Page
/*-----------------------------------------------------------------------------------*/
require( get_template_directory() . '/includes/theme-options.php' );

/*-----------------------------------------------------------------------------------*/
/* Call JavaScript Scripts for pohutukawa (Masonry layout, Fitvids for Elasic Videos and Custom)
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts','pohutukawa_scripts_function');

	function pohutukawa_scripts_function() {
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', false, '1.1');
		wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', false, '1.0');
		wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', false, '1.0');
}


/*-----------------------------------------------------------------------------------*/
/*  Returns the Google font stylesheet URL if available.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_font_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by the used fonts translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$pt_sans = _x( 'on', 'PT Sans: on or off', 'pohutukawa' );

	if ( 'off' !== $pt_sans ) {
		$font_families = array();

		if ( 'off' !== $pt_sans )
			$font_families[] = 'PT Sans:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/*-----------------------------------------------------------------------------------*/
/* Load block editor styles.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_block_editor_styles() {
 wp_enqueue_style( 'pohutukawa-block-editor-styles', get_template_directory_uri() . '/block-editor.css');
 wp_enqueue_style( 'pohutukawa-fonts', pohutukawa_font_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'pohutukawa_block_editor_styles' );

/*-----------------------------------------------------------------------------------*/
/* Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'pohutukawa_page_menu_args' );

/*-----------------------------------------------------------------------------------*/
/* Sets the post excerpt length to 40 characters.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'pohutukawa_excerpt_length' );

/*-----------------------------------------------------------------------------------*/
/* Returns a "Continue Reading" link for excerpts
/*-----------------------------------------------------------------------------------*/
function pohutukawa_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading', 'pohutukawa' ) . '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and pohutukawa_continue_reading_link().
/*
/* To override this in a child theme, remove the filter and add your own
/* function tied to the excerpt_more filter hook.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_auto_excerpt_more( $more ) {
	return ' &hellip;' . pohutukawa_continue_reading_link();
}
add_filter( 'excerpt_more', 'pohutukawa_auto_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Adds a pretty "Continue Reading" link to custom post excerpts.
/*
/* To override this link in a child theme, remove the filter and add your own
/* function tied to the get_the_excerpt filter hook.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= pohutukawa_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'pohutukawa_custom_excerpt_more' );

/*-----------------------------------------------------------------------------------*/
/* Comments template pohutukawa_comment
/*-----------------------------------------------------------------------------------*/
function pohutukawa_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>

	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">

				<?php echo get_avatar( $comment, 40 ); ?>

			<div class="comment-content">
				<ul class="comment-meta">
					<li class="comment-author"><?php printf( __( '%s', 'pohutukawa' ), sprintf( '%s', get_comment_author_link() ) ); ?></li>
						<li class="comment-time"><?php _e( ' // ', 'pohutukawa' ); ?><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s &#64; %2$s', 'pohutukawa' ),
						get_comment_date('d.m.y'),
						get_comment_time() );
					?></a></li>
					<li class="comment-edit"><?php edit_comment_link( __( 'Edit', 'pohutukawa' ), ' ' );?></li>
					<li class="comment-reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'pohutukawa' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li>
				</ul>

				<?php comment_text(); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'pohutukawa' ); ?></p>
				<?php endif; ?>
			</div><!-- end .comment-content -->
		</article><!-- end .comment -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( '<span>Pingback:</span>', 'pohutukawa' ); ?> <?php comment_author_link(); ?></p>
		<p><?php edit_comment_link( __('Edit pingback', 'pohutukawa'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

/*-----------------------------------------------------------------------------------*/
/* Register widgetized area and update sidebar with default widgets
/*-----------------------------------------------------------------------------------*/
function pohutukawa_widgets_init() {

	register_sidebar( array (
		'name' => __( 'Main Widget Area', 'pohutukawa' ),
		'id' => 'widget-area-main',
		'description' => __( 'Main widget area (below the post and pages content).', 'pohutukawa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer Widget Area 1', 'pohutukawa' ),
		'id' => 'widget-area-footer-1',
		'description' => __( 'Footer Widget Area 1 (left column in desktop view)', 'pohutukawa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer Widget Area 2', 'pohutukawa' ),
		'id' => 'widget-area-footer-2',
		'description' => __( 'Footer Widget Area 2 (middle column in desktop view)', 'pohutukawa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Footer Widget Area 3', 'pohutukawa' ),
		'id' => 'widget-area-footer-3',
		'description' => __( 'Footer Widget Area 3 (right column in desktop view)', 'pohutukawa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Social Links Footer Widget', 'pohutukawa' ),
		'id' => 'widget-area-footer-sociallinks',
		'description' => __( 'Optional widget area to include the Social Links Widget in the bottom footer area.', 'pohutukawa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

}
add_action( 'init', 'pohutukawa_widgets_init' );

/*-----------------------------------------------------------------------------------*/
/* Customized pohutukawa search form
/*-----------------------------------------------------------------------------------*/
function pohutukawa_search_form( $form ) {

		$form = '	<form method="get" class="searchform" action="'. home_url() .'">
			<input type="text" class="field s" name="s" placeholder="'. esc_attr__('Search...', 'pohutukawa') .'" />
			<input type="submit" class="searchsubmit" name="submit" value="'. esc_attr__('Submit', 'pohutukawa') .'" />
	</form>';

		return $form;
}
add_filter( 'get_search_form', 'pohutukawa_search_form' );

/*-----------------------------------------------------------------------------------*/
/* Add Theme Customizer CSS
/*-----------------------------------------------------------------------------------*/
function pohutukawa_css_wrap() {
	?>
	<style type="text/css" id="custom-css">
	 <?php if (get_header_image() != '') { ?>
		 @media screen and (min-width: 1100px) {
					.site-header {
				 background: url(<?php echo( get_header_image() ); ?>) no-repeat scroll;
					height: 440px;
					background-position:center;
					background-size: cover;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					}
			}
	 <?php } ?>
</style>
	<?php
}
add_action( 'wp_head', 'pohutukawa_css_wrap');

/*-----------------------------------------------------------------------------------*/
/* pohutukawa Shortcodes
/*-----------------------------------------------------------------------------------*/
// Enable shortcodes in widget areas
add_filter( 'widget_text', 'do_shortcode' );

// Replace WP autop formatting
if (!function_exists( "pohutukawa_remove_wpautop")) {
	function pohutukawa_remove_wpautop($content) {
		$content = do_shortcode( shortcode_unautop( $content ) );
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Multi Columns Shortcodes
/* Don't forget to add "_last" behind the shortcode if it is the last column.
/*-----------------------------------------------------------------------------------*/

// Two Columns
function pohutukawa_shortcode_two_columns_one( $atts, $content = null ) {
	 return '<div class="two-columns-one">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one', 'pohutukawa_shortcode_two_columns_one' );

function pohutukawa_shortcode_two_columns_one_last( $atts, $content = null ) {
	 return '<div class="two-columns-one last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'two_columns_one_last', 'pohutukawa_shortcode_two_columns_one_last' );

// Three Columns
function pohutukawa_shortcode_three_columns_one($atts, $content = null) {
	 return '<div class="three-columns-one">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one', 'pohutukawa_shortcode_three_columns_one' );

function pohutukawa_shortcode_three_columns_one_last($atts, $content = null) {
	 return '<div class="three-columns-one last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_one_last', 'pohutukawa_shortcode_three_columns_one_last' );

function pohutukawa_shortcode_three_columns_two($atts, $content = null) {
	 return '<div class="three-columns-two">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two', 'pohutukawa_shortcode_three_columns' );

function pohutukawa_shortcode_three_columns_two_last($atts, $content = null) {
	 return '<div class="three-columns-two last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'three_columns_two_last', 'pohutukawa_shortcode_three_columns_two_last' );

// Four Columns
function pohutukawa_shortcode_four_columns_one($atts, $content = null) {
	 return '<div class="four-columns-one">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one', 'pohutukawa_shortcode_four_columns_one' );

function pohutukawa_shortcode_four_columns_one_last($atts, $content = null) {
	 return '<div class="four-columns-one last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_one_last', 'pohutukawa_shortcode_four_columns_one_last' );

function pohutukawa_shortcode_four_columns_two($atts, $content = null) {
	 return '<div class="four-columns-two">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two', 'pohutukawa_shortcode_four_columns_two' );

function pohutukawa_shortcode_four_columns_two_last($atts, $content = null) {
	 return '<div class="four-columns-two last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_two_last', 'pohutukawa_shortcode_four_columns_two_last' );

function pohutukawa_shortcode_four_columns_three($atts, $content = null) {
	 return '<div class="four-columns-three">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three', 'pohutukawa_shortcode_four_columns_three' );

function pohutukawa_shortcode_four_columns_three_last($atts, $content = null) {
	 return '<div class="four-columns-three last">' . pohutukawa_remove_wpautop($content) . '</div>';
}
add_shortcode( 'four_columns_three_last', 'pohutukawa_shortcode_four_columns_three_last' );

// Divide Text Shortcode
function pohutukawa_shortcode_divider($atts, $content = null) {
	 return '<div class="divider"></div>';
}
add_shortcode( 'divider', 'pohutukawa_shortcode_divider' );

/*-----------------------------------------------------------------------------------*/
/* Text Highlight and Info Boxes Shortcodes
/*-----------------------------------------------------------------------------------*/

function pohutukawa_shortcode_white_box($atts, $content = null) {
	 return '<div class="white-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'white_box', 'pohutukawa_shortcode_white_box' );

function pohutukawa_shortcode_yellow_box($atts, $content = null) {
	 return '<div class="yellow-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'yellow_box', 'pohutukawa_shortcode_yellow_box' );

function pohutukawa_shortcode_red_box($atts, $content = null) {
	 return '<div class="red-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'red_box', 'pohutukawa_shortcode_red_box' );

function pohutukawa_shortcode_blue_box($atts, $content = null) {
	 return '<div class="blue-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'blue_box', 'pohutukawa_shortcode_blue_box' );

function pohutukawa_shortcode_green_box($atts, $content = null) {
	 return '<div class="green-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'green_box', 'pohutukawa_shortcode_green_box' );

function pohutukawa_shortcode_lightgrey_box($atts, $content = null) {
	 return '<div class="lightgrey-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'lightgrey_box', 'pohutukawa_shortcode_lightgrey_box' );

function pohutukawa_shortcode_grey_box($atts, $content = null) {
	 return '<div class="grey-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'grey_box', 'pohutukawa_shortcode_grey_box' );

function pohutukawa_shortcode_dark_box($atts, $content = null) {
	 return '<div class="dark-box">' . do_shortcode( pohutukawa_remove_wpautop($content) ) . '</div>';
}
add_shortcode( 'dark_box', 'pohutukawa_shortcode_dark_box' );

/*-----------------------------------------------------------------------------------*/
/* General Buttons Shortcodes
/*-----------------------------------------------------------------------------------*/

function pohutukawa_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target'	=> '',
		'color'	=> '',
		'size'	=> '',
	'form'	=> '',
	'style'	=> '',
		), $atts));

	$color = ($color) ? ' '.$color. '-btn' : '';
	$size = ($size) ? ' '.$size. '-btn' : '';
	$form = ($form) ? ' '.$form. '-btn' : '';
	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="standard-btn' .$color.$size.$form. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('button', 'pohutukawa_button');

/*-----------------------------------------------------------------------------------*/
/* Link Post Format Button Shortcode
/*-----------------------------------------------------------------------------------*/

function pohutukawa_link_format( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'link'	=> '#',
		'target'	=> '',
	 'style'	=> '',
		), $atts));

	$target = ($target == 'blank') ? ' target="_blank"' : '';

	$out = '<a' .$target. ' class="link' .$style. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';

		return $out;
}
add_shortcode('link_format', 'pohutukawa_link_format');
