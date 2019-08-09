<?php
/**
 * Pohutukawa Theme Options
 *
 * @package WordPress
 * @subpackage Pohutukawa
 * @since Pohutukawa 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Properly enqueue styles and scripts for our theme options page.
/*
/* This function is attached to the admin_enqueue_scripts action hook.
/*
/* @param string $hook_suffix The action passes the current page to the function.
/* We don't do anything if we're not on our theme options page.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_admin_enqueue_scripts( $hook_suffix ) {
	if ( $hook_suffix != 'appearance_page_theme_options' )
		return;

	wp_enqueue_style( 'pohutukawa-theme-options', get_template_directory_uri() . '/includes/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'pohutukawa-theme-options', get_template_directory_uri() . '/includes/theme-options.js', array( 'farbtastic' ), '2011-04-28' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_enqueue_scripts', 'pohutukawa_admin_enqueue_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Register the form setting for our pohutukawa_options array.
/*
/* This function is attached to the admin_init action hook.
/*
/* This call to register_setting() registers a validation callback, pohutukawa_theme_options_validate(),
/* which is used when the option is saved, to ensure that our option values are complete, properly
/* formatted, and safe.
/*
/* We also use this function to add our theme option if it doesn't already exist.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === pohutukawa_get_theme_options() )
		add_option( 'pohutukawa_theme_options', pohutukawa_get_default_theme_options() );

	register_setting(
		'pohutukawa_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'pohutukawa_theme_options', // Database option, see pohutukawa_get_theme_options()
		'pohutukawa_theme_options_validate' // The sanitization callback, see pohutukawa_theme_options_validate()
	);
}
add_action( 'admin_init', 'pohutukawa_theme_options_init' );

/*-----------------------------------------------------------------------------------*/
/* Add our theme options page to the admin menu.
/*
/* This function is attached to the admin_menu action hook.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_theme_options_add_page() {
	add_theme_page(
		__( 'Theme Options', 'pohutukawa' ), // Name of page
		__( 'Theme Options', 'pohutukawa' ), // Label in menu
		'edit_theme_options',                  // Capability required
		'theme_options',                       // Menu slug, used to uniquely identify the page
		'theme_options_render_page'            // Function that renders the options page
	);
}
add_action( 'admin_menu', 'pohutukawa_theme_options_add_page' );

/*-----------------------------------------------------------------------------------*/
/* Returns an array of layout options registered for Pohutukawa
/*-----------------------------------------------------------------------------------*/

function pohutukawa_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __( 'right Sidebar', 'pohutukawa' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content-sidebar.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __( 'One-column', 'pohutukawa' ),
			'thumbnail' => get_template_directory_uri() . '/includes/images/content.png',
		),
	);

	return apply_filters( 'pohutukawa_layouts', $layout_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the default options for Pohutukawa
/*-----------------------------------------------------------------------------------*/

function pohutukawa_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#ef5722',
		'widget_headline_color'   => '#70A7C7',
		'theme_layout' => 'content-sidebar',
		'custom_logo' => '',
		'white_headerfont' => '',
		'menu_title' => '',
		'footerwidget_color'   => '#ef5722',
		'custom_footertext' => '',
		'custom_favicon' => '',
		'share-posts' => '',
		'share-singleposts' => '',
		'share-pages' => '',
	);

	return apply_filters( 'pohutukawa_default_theme_options', $default_theme_options );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Pohutukawa
/*-----------------------------------------------------------------------------------*/

function pohutukawa_get_theme_options() {
	return get_option( 'pohutukawa_theme_options' );
}

/*-----------------------------------------------------------------------------------*/
/* Returns the options array for Pohutukawa
/*-----------------------------------------------------------------------------------*/

function theme_options_render_page() {
	?>
	<div class="wrap">
		<h2><?php printf( __( '%s Theme Options', 'pohutukawa' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'pohutukawa_options' );
				$options = pohutukawa_get_theme_options();
				$default_options = pohutukawa_get_default_theme_options();
			?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Custom Link Color', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'pohutukawa' ); ?></span></legend>
							 <input type="text" name="pohutukawa_theme_options[link_color]" value="<?php echo esc_attr( $options['link_color'] ); ?>" id="link-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker1"></div>
							<br />
							<small class="description"><?php printf( __( 'Default Link Color: %s', 'pohutukawa' ), $default_options['link_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Second Custom Color', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Second Custom Color', 'pohutukawa' ); ?></span></legend>
							 <input type="text" name="pohutukawa_theme_options[widget_headline_color]" value="<?php echo esc_attr( $options['widget_headline_color'] ); ?>" id="widget-headline-color" />
							<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker3"></div>
							<br />
							<small class="description"><?php printf( __( 'This color is used for widget headlines, subheadlines and the quote post format. Default: %s', 'pohutukawa' ), $default_options['widget_headline_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top" class="image-radio-option"><th scope="row"><?php _e( 'Layout Options', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Layout Options', 'pohutukawa' ); ?></span></legend>
						<?php
							foreach ( pohutukawa_layouts() as $layout ) {
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="pohutukawa_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
									<span>
										<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>"/>
										<?php echo $layout['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Logo', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Logo image', 'pohutukawa' ); ?></span></legend>
							<input class="regular-text" type="text" name="pohutukawa_theme_options[custom_logo]" value="<?php esc_attr_e( $options['custom_logo'] ); ?>" />
						<br/><label class="description" for="pohutukawa_theme_options[custom_logo]"><?php _e('Upload your own logo image using the ', 'pohutukawa'); ?><a href="<?php echo home_url(); ?>/wp-admin/media-new.php" target="_blank"><?php _e('WordPress Media Uploader', 'pohutukawa'); ?></a><?php _e('. Copy your logo image file URL and insert the URL here.', 'pohutukawa'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'White Header Font Color', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'White Header Font Color', 'pohutukawa' ); ?></span></legend>
							<input id="pohutukawa_theme_options[white_headerfont]" name="pohutukawa_theme_options[white_headerfont]" type="checkbox" value="1" <?php checked( '1', $options['white_headerfont'] ); ?> />
							<label class="description" for="pohutukawa_theme_options[white_headerfont]"><?php _e( 'Check this box to set white as the standard header font color (this option is useful if you choose a dark header image).', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Menu Title', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Menu Title', 'pohutukawa' ); ?></span></legend>
							<input class="regular-text" type="text" name="pohutukawa_theme_options[menu_title]" value="<?php esc_attr_e( $options['menu_title'] ); ?>" />
						<br/><label class="description" for="pohutukawa_theme_options[menu_title]"><?php _e('Choose a custom title for your main navigation (e.g. Navigation, Pages or Categories. The default title is "Menu").', 'pohutukawa'); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Footer Widgets Background Color', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Footer Widgets Background Color', 'pohutukawa' ); ?></span></legend>
						<input type="text" name="pohutukawa_theme_options[footerwidget_color]" value="<?php echo esc_attr( $options['footerwidget_color'] ); ?>" id="footerwidget-color" />
						<div style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;" id="colorpicker2"></div>
						<br />
						<small class="description"><?php printf( __( 'Default Footer Widgets Background Color: %s', 'pohutukawa' ), $default_options['footerwidget_color'] ); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Footer Credit Text', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Footer text', 'pohutukawa' ); ?></span></legend>
							<textarea id="pohutukawa_theme_options[custom_footertext]" class="small-text" cols="120" rows="3" name="pohutukawa_theme_options[custom_footertext]"><?php echo esc_textarea( $options['custom_footertext'] ); ?></textarea>
						<br/><label class="description" for="pohutukawa_theme_options[custom_footertext]"><?php _e( 'Customize the footer credit text. Standard HTML is allowed.', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Custom Favicon', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Custom Favicon', 'pohutukawa' ); ?></span></legend>
							<input class="regular-text" type="text" name="pohutukawa_theme_options[custom_favicon]" value="<?php esc_attr_e( $options['custom_favicon'] ); ?>" />
						<br/><label class="description" for="pohutukawa_theme_options[custom_favicon]"><?php _e( 'Create a favicon image and upload your .ico Favicon image (via FTP) to your server and enter the Favicon URL here.', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for posts', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for posts', 'pohutukawa' ); ?></span></legend>
							<input id="pohutukawa_theme_options[share-posts]" name="pohutukawa_theme_options[share-posts]" type="checkbox" value="1" <?php checked( '1', $options['share-posts'] ); ?> />
							<label class="description" for="pohutukawa_theme_options[share-posts]"><?php _e( 'Check this box to include a post short URL, Twitter, Facebook and Google+ button on the blogs front page and on single post pages.', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for single post pages only', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for single post pages only', 'pohutukawa' ); ?></span></legend>
							<input id="pohutukawa_theme_options[share-singleposts]" name="pohutukawa_theme_options[share-singleposts]" type="checkbox" value="1" <?php checked( '1', $options['share-singleposts'] ); ?> />
							<label class="description" for="pohutukawa_theme_options[share-singleposts]"><?php _e( 'Check this box to include the share post buttons <strong>only</strong> on single post pages.', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Share option for pages', 'pohutukawa' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Share option for pages', 'pohutukawa' ); ?></span></legend>
							<input id="pohutukawa_theme_options[share-pages]" name="pohutukawa_theme_options[share-pages]" type="checkbox" value="1" <?php checked( '1', $options['share-pages'] ); ?> />
							<label class="description" for="pohutukawa_theme_options[share-pages]"><?php _e( 'Check this box to include the share option on pages.', 'pohutukawa' ); ?></label>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Sanitize and validate form input. Accepts an array, return a sanitized array.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_theme_options_validate( $input ) {
	global $layout_options, $font_options;

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
			$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Widget Headline color must be 3 or 6 hexadecimal characters
	if ( isset( $input['widget_headline_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['widget_headline_color'] ) )
			$output['widget_headline_color'] = '#' . strtolower( ltrim( $input['widget_headline_color'], '#' ) );

	// Footer widget background color must be 3 or 6 hexadecimal characters
	if ( isset( $input['footerwidget_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['footerwidget_color'] ) )
			$output['footerwidget_color'] = '#' . strtolower( ltrim( $input['footerwidget_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], pohutukawa_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	// Text options must be safe text with no HTML tags
	$input['custom_logo'] = wp_filter_nohtml_kses( $input['custom_logo'] );
	$input['menu_title'] = wp_filter_nohtml_kses( $input['menu_title'] );
	$input['custom_favicon'] = wp_filter_nohtml_kses( $input['custom_favicon'] );

	// checkbox value is either 0 or 1
	if ( ! isset( $input['white_headerfont'] ) )
		$input['white_headerfont'] = null;
	$input['white_headerfont'] = ( $input['white_headerfont'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-posts'] ) )
		$input['share-posts'] = null;
	$input['share-posts'] = ( $input['share-posts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-singleposts'] ) )
		$input['share-singleposts'] = null;
	$input['share-singleposts'] = ( $input['share-singleposts'] == 1 ? 1 : 0 );

	if ( ! isset( $input['share-pages'] ) )
		$input['share-pages'] = null;
	$input['share-pages'] = ( $input['share-pages'] == 1 ? 1 : 0 );

	return $input;
}

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current header font color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_print_white_headerfont_style() {
	$options = pohutukawa_get_theme_options();
	$white_headerfont = $options['white_headerfont'];

	$default_options = pohutukawa_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['white_headerfont'] == $white_headerfont )
		return;
?>
<style type="text/css">
@media screen and (min-width: 1100px) {
/* White Header Font Color */
#site-title h1 a,
#branding .optional-nav ul li,
#branding .optional-nav ul li a {color:#fff;}
#branding {border-bottom:1px solid #fff;}
}
</style>
<?php
}
add_action( 'wp_head', 'pohutukawa_print_white_headerfont_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current link color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_print_link_color_style() {
	$options = pohutukawa_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = pohutukawa_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
<style type="text/css">
/* Custom Link Color */
a,
#content h2.entry-title a:hover,
#branding .optional-nav ul a:hover,
#footer .widget_tag_cloud a,
.widget_recent_entries ul li a:hover,
.widget_recent_comments ul li a:hover,
.widget_twitter ul li a:hover,
#footer .flickr_badge_wrapper .flickr-bottom a,
#footer .widget_links ul li a:hover,
#footer .widget_pages ul li a:hover,
#footer .widget_categories ul li a:hover,
#footer .widget_nav_menu ul li a:hover,
#footer .widget_meta ul li a:hover,
#footer .widget_archive ul li a:hover,
.bwp-rc-widget li.sidebar-comment a:hover {
	color:<?php echo $link_color; ?>;
}
#header .mobile-nav a.menu-btn,
#main-nav ul li a:hover,
.widget_links ul li a:hover,
.widget_pages ul li a:hover,
.widget_categories ul li a:hover,
.widget_nav_menu ul li a:hover,
.widget_meta ul li a:hover,
.widget_archive ul li a:hover,
input#submit,
input.wpcf7-submit,
.jetpack_subscription_widget form#subscribe-blog input[type="submit"],
#content .wp-pagenavi a.page,
#content .wp-pagenavi a.nextpostslink,
#content .wp-pagenavi a.previouspostslink,
#content .wp-pagenavi a.first,
#content .wp-pagenavi a.last,
#content .wp-pagenavi span.current,
.flickr_badge_wrapper a img:hover {
	background:<?php echo $link_color; ?>;
}
a.more-link {background:<?php echo $link_color; ?> url(<?php echo get_template_directory_uri(); ?>/images/arrow-right.png) 0 0 no-repeat;}
</style>
<?php
}
add_action( 'wp_head', 'pohutukawa_print_link_color_style' );


/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current Widget Headline color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_print_widget_headline_color_style() {
	$options = pohutukawa_get_theme_options();
	$widget_headline_color = $options['widget_headline_color'];

	$default_options = pohutukawa_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['widget_headline_color'] == $widget_headline_color )
		return;
?>
<style type="text/css">
/* Custom Widget Headline Color */
#content .format-quote blockquote, #content .single-posts-meta ul li span, #content .page-header h1.page-title, #main-nav h3, .widget h3.widget-title, .widget_get_recent_comments h1.widget-title { color:<?php echo $widget_headline_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'pohutukawa_print_widget_headline_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Add a style block to the theme for the current footer widget background color.
/*
/* This function is attached to the wp_head action hook.
/*-----------------------------------------------------------------------------------*/

function pohutukawa_print_footerwidget_color_style() {
	$options = pohutukawa_get_theme_options();
	$footerwidget_color = $options['footerwidget_color'];

	$default_options = pohutukawa_get_default_theme_options();

	// Don't do anything if the current  footer widget background color is the default.
	if ( $default_options['footerwidget_color'] == $footerwidget_color )
		return;
?>
<style type="text/css">
/* Custom Footer Widget Background Color */
#footer-widgets-wrap, #footer-widget-area { background:<?php echo $footerwidget_color; ?>;}
</style>
<?php
}
add_action( 'wp_head', 'pohutukawa_print_footerwidget_color_style' );

/*-----------------------------------------------------------------------------------*/
/* Adds Pohutukawa layout classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
function pohutukawa_layout_classes( $existing_classes ) {
	$options = pohutukawa_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar' ) ) )
		$classes = array( 'two-column' );
	else
		$classes = array( 'one-column' );

	$classes[] = $current_layout;

	$classes = apply_filters( 'pohutukawa_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'pohutukawa_layout_classes' );
