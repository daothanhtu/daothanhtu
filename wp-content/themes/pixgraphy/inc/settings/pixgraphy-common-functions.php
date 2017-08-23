<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */

/****************** PIXGRAPHY DISPLAY COMMENT NAVIGATION *******************************/
function pixgraphy_comment_nav() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'pixgraphy' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'pixgraphy' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;
				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'pixgraphy' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
/******************** Remove div and replace with ul**************************************/
add_filter('wp_page_menu', 'pixgraphy_wp_page_menu');
function pixgraphy_wp_page_menu($page_markup) {
	preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
	$divclass   = $matches[1];
	$replace    = array('<div class="'.$divclass.'">', '</div>');
	$new_markup = str_replace($replace, '', $page_markup);
	$new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
	return $new_markup;
}
/***************Pass slider effect  parameters from php files to jquery file ********************/
function pixgraphy_slider_value() {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	$pixgraphy_transition_effect   = esc_attr($pixgraphy_settings['pixgraphy_transition_effect']);
	$pixgraphy_transition_delay    = absint($pixgraphy_settings['pixgraphy_transition_delay'])*1000;
	$pixgraphy_transition_duration = absint($pixgraphy_settings['pixgraphy_transition_duration'])*1000;
	wp_localize_script(
		'pixgraphy_slider',
		'pixgraphy_slider_value',
		array(
			'transition_effect'   => $pixgraphy_transition_effect,
			'transition_delay'    => $pixgraphy_transition_delay,
			'transition_duration' => $pixgraphy_transition_duration,
		)
	);
}
/********************* Used wp_page_menu filter hook *********************************************/
	function pixgraphy_wp_page_menu_filter($text) {
		$replace = array(
			'current_page_item' => 'current-menu-item',
		);
		$text = str_replace(array_keys($replace), $replace, $text);
		return $text;
	}
add_filter('wp_page_menu', 'pixgraphy_wp_page_menu_filter');

/**************************************************************************************/
function pixgraphy_get_featured_posts() {
	return apply_filters( 'pixgraphy_get_featured_posts', array() );
}
/************ Return bool if there are featured Posts ********************************/
function pixgraphy_has_featured_posts() {
	return ! is_paged() && (bool) pixgraphy_get_featured_posts();
}

/**************************** Display Header Title ***********************************/
function pixgraphy_header_title() {
	$format = get_post_format();
	$pixgraphy_settings = pixgraphy_get_theme_options();
	$pixgraphy_header_title='';
	if( is_archive() ) {
		if ( is_category() ) :
			$pixgraphy_header_title = single_cat_title( '', FALSE );
		elseif ( is_tag() ) :
			if($pixgraphy_settings['pixgraphy_photography_layout'] != 'photography_layout' ):
				$pixgraphy_header_title = single_tag_title( '', FALSE );
			endif;
		elseif ( is_author() ) :
			the_post();
			$pixgraphy_header_title =  sprintf( __( 'Author: %s', 'pixgraphy' ), '<span class="vcard">' . get_the_author() . '</span>' );
			rewind_posts();
		elseif ( is_day() ) :
			$pixgraphy_header_title = sprintf( __( 'Day: %s', 'pixgraphy' ), '<span>' . get_the_date() . '</span>' );
		elseif ( is_month() ) :
			$pixgraphy_header_title = sprintf( __( 'Month: %s', 'pixgraphy' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		elseif ( is_year() ) :
			$pixgraphy_header_title = sprintf( __( 'Year: %s', 'pixgraphy' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		elseif ( $format == 'audio' ) :
			$pixgraphy_header_title = __( 'Audios', 'pixgraphy' );
		elseif ( $format =='aside' ) :
			$pixgraphy_header_title = __( 'Asides', 'pixgraphy');
		elseif ( $format =='image' ) :
			$pixgraphy_header_title = __( 'Images', 'pixgraphy' );
		elseif ( $format =='gallery' ) :
			$pixgraphy_header_title = __( 'Galleries', 'pixgraphy' );
		elseif ( $format =='video' ) :
			$pixgraphy_header_title = __( 'Videos', 'pixgraphy' );
		elseif ( $format =='status' ) :
			$pixgraphy_header_title = __( 'Status', 'pixgraphy' );
		elseif ( $format =='quote' ) :
			$pixgraphy_header_title = __( 'Quotes', 'pixgraphy' );
		elseif ( $format =='link' ) :
			$pixgraphy_header_title = __( 'links', 'pixgraphy' );
		elseif ( $format =='chat' ) :
			$pixgraphy_header_title = __( 'Chats', 'pixgraphy' );
		elseif ( class_exists('WooCommerce') && is_shop() ||is_product_category()) :
  			$pixgraphy_header_title = woocommerce_page_title( false );
  		elseif ( class_exists('bbPress') && is_bbpress()) :
  			$pixgraphy_header_title = get_the_title();
		else :
			$pixgraphy_header_title = __( 'Archives', 'pixgraphy' );
		endif;
	} elseif (is_home()){
		$pixgraphy_header_title = get_the_title( get_option( 'page_for_posts' ) );
	} elseif (is_404()) {
		$pixgraphy_header_title = __('Page NOT Found', 'pixgraphy');
	} elseif (is_search()) {
		$pixgraphy_header_title = __('Search Results', 'pixgraphy');
	} elseif (is_page_template()) {
		$pixgraphy_header_title = get_the_title();
	} else {
		$pixgraphy_header_title = get_the_title();
	}
	return $pixgraphy_header_title;
}
/********************* Custom Header setup ************************************/
function pixgraphy_custom_header_setup() {
	$args = array(
		'default-text-color'     => '',
		'default-image'          => '',
		'height'                 => apply_filters( 'pixgraphy_header_image_height', 400 ),
		'width'                  => apply_filters( 'pixgraphy_header_image_width', 2500 ),
		'random-default'         => false,
		'max-width'              => 2500,
		'flex-height'            => true,
		'flex-width'             => true,
		'random-default'         => false,
		'header-text'				 => false,
		'uploads'				 => true,
		'wp-head-callback'       => '',
		'admin-preview-callback' => 'pixgraphy_admin_header_image',
		'default-image' => '',
	);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'pixgraphy_custom_header_setup' );
?>