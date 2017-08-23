<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */

/********************* PIXGRAPHY RESPONSIVE AND CUSTOM CSS OPTIONS ***********************************/
function pixgraphy_resp_and_custom_css() {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	if( $pixgraphy_settings['pixgraphy_responsive'] == 'on' ) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php } else{ ?>
	<meta name="viewport" content="width=1070" />
	<?php  }
	if (!empty($pixgraphy_settings['pixgraphy_custom_css'] ) ){
		$pixgraphy_internal_css = '<!-- Custom CSS -->'."\n";
		$pixgraphy_internal_css .= '<style type="text/css" media="screen">'."\n";
		if (!empty($pixgraphy_settings['pixgraphy_custom_css']) ) {
			$pixgraphy_internal_css .= $pixgraphy_settings['pixgraphy_custom_css']."\n";
		}
		$pixgraphy_internal_css .= '</style>'."\n";
	}
	if (isset($pixgraphy_internal_css)) {
		echo $pixgraphy_internal_css;
	}
}
add_filter( 'wp_head', 'pixgraphy_resp_and_custom_css');

/******************************** EXCERPT LENGTH *********************************/
function pixgraphy_excerpt_length($length) {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	$pixgraphy_excerpt_length = $pixgraphy_settings['pixgraphy_excerpt_length'];
	return absint($pixgraphy_excerpt_length);// this will return 30 words in the excerpt
}
add_filter('excerpt_length', 'pixgraphy_excerpt_length');

/********************* CONTINUE READING LINKS FOR EXCERPT *********************************/
function pixgraphy_continue_reading() {
	 return '&hellip; '; 
}
add_filter('excerpt_more', 'pixgraphy_continue_reading');

/***************** USED CLASS FOR BODY TAGS ******************************/
function pixgraphy_body_class($classes) {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	$pixgraphy_photography_layout = $pixgraphy_settings['pixgraphy_photography_layout'];
	$pixgraphy_site_layout = $pixgraphy_settings['pixgraphy_design_layout'];
	if(is_home() || (is_home() && is_front_page())){
		if($pixgraphy_settings['pixgraphy_border_column'] == 'on'){
			$classes[] = 'border-column';
		}
	}
	if (is_page_template('page-templates/page-template-contact.php')) {
			$classes[] = 'contact';
	}
	if ($pixgraphy_site_layout =='boxed-layout') {
		$classes[] = 'boxed-layout';
	}
	if ($pixgraphy_site_layout =='small-boxed-layout') {
		$classes[] = 'boxed-layout-small';
	}
	if (($pixgraphy_photography_layout == 'photography_layout' && is_archive()) || ($pixgraphy_photography_layout == 'photography_layout' && !is_page() && !is_single() )){
		$classes[] = "photography";
		if($pixgraphy_settings['pixgraphy_border_column'] == 'on'){
			$classes[] = 'border-column';
		}
	}elseif ($pixgraphy_photography_layout == 'medium_image_display'){
			$classes[] = "small_image_blog";
	}
	return $classes;
}
add_filter('body_class', 'pixgraphy_body_class');

/********************** SCRIPTS FOR DONATE/ UPGRADE BUTTON ******************************/
function pixgraphy_customize_scripts() {
	if(!class_exists('Pixgraphy_Plus_Features')){
	wp_enqueue_script( 'pixgraphy_customizer_custom', get_template_directory_uri() . '/inc/js/customizer-custom-scripts.js', array( 'jquery' ), '20140108', true );

	$pixgraphy_upgrade_links = array(
							'upgrade_link'              => esc_url('http://themefreesia.com/themes/pixgraphy'),
							'upgrade_text'              => __( 'Upgrade to Pro', 'pixgraphy' ),
							);
		wp_localize_script( 'pixgraphy_customizer_custom', 'pixgraphy_upgrade_links', $pixgraphy_upgrade_links );
		wp_enqueue_script( 'pixgraphy_customizer_custom' );
	wp_enqueue_style( 'pixgraphy_customizer_custom', get_template_directory_uri() . '/inc/js/pixgraphy-customizer.css');wp_enqueue_script( 'pixgraphy_customizer_custom' );
	}
}
add_action( 'customize_controls_print_scripts', 'pixgraphy_customize_scripts');

/**************************** SOCIAL MENU *********************************************/
function pixgraphy_social_links() { ?>
	<div class="social-links clearfix">
		<ul>
		<?php
		$pixgraphy_settings = pixgraphy_get_theme_options();
		if( !empty($pixgraphy_settings['pixgraphy_social_facebook']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_facebook']).'"><i class="fa fa-facebook"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_twitter']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_twitter']).'"><i class="fa fa-twitter"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_pinterest']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_pinterest']).'"><i class="fa fa-pinterest-p"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_dribbble']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_dribbble']).'"><i class="fa fa-dribbble"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_instagram']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_instagram']).'"><i class="fa fa-instagram"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_flickr']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_flickr']).'"><i class="fa fa-flickr"></i></a></li>';
		endif;
		if( !empty($pixgraphy_settings['pixgraphy_social_googleplus']) ):
			echo '<li><a target="_blank" href="'.esc_url($pixgraphy_settings['pixgraphy_social_googleplus']).'"><i class="fa fa-google-plus"></i></a></li>';
		endif;
		if(class_exists('Pixgraphy_Plus_Features')){
			do_action ('social_Plus_links');
		}
			?>
		</ul>

	</div><!-- end .social-links -->
<?php }
add_action ('social_links', 'pixgraphy_social_links');

/******************* DISPLAY BREADCRUMBS ******************************/
function pixgraphy_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb home">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}

/*********************** pixgraphy PAGE SLIDERS ***********************************/
function pixgraphy_page_sliders() {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	$excerpt = get_the_excerpt();
	global $pixgraphy_excerpt_length;
	global $post;
	$pixgraphy_page_sliders_display = '';
	$pixgraphy_total_page_no 		= 0; 
	$pixgraphy_list_page				= array();
	for( $i = 1; $i <= $pixgraphy_settings['pixgraphy_slider_no']; $i++ ){
		if( isset ( $pixgraphy_settings['pixgraphy_featured_page_slider_' . $i] ) && $pixgraphy_settings['pixgraphy_featured_page_slider_' . $i] > 0 ){
			$pixgraphy_total_page_no++;
			$pixgraphy_list_page	=	array_merge( $pixgraphy_list_page, array( esc_attr($pixgraphy_settings['pixgraphy_featured_page_slider_' . $i] )) );
		}
	}
		if ( !empty( $pixgraphy_list_page ) && $pixgraphy_total_page_no > 0 ) {
			$pixgraphy_page_sliders_display 	.= '<div class="main-slider clearfix"> <div class="layer-slider">';
					$get_featured_posts 		= new WP_Query(array( 'posts_per_page'=> $pixgraphy_settings['pixgraphy_slider_no'], 'post_type' => array('page'), 'post__in' => $pixgraphy_list_page, 'orderby' => 'post__in', ));
					$j=1; $i=0;
			while ($get_featured_posts->have_posts()):$get_featured_posts->the_post();
			$attachment_id = get_post_thumbnail_id();
			$image_attributes = wp_get_attachment_image_src($attachment_id,'pixgraphy_slider_image');
						$i++;
						$title_attribute       	 	 = apply_filters('the_title', get_the_title($post->ID));
						$excerpt               	 	 = substr(get_the_excerpt(), 0 , 160);
						if (1 == $i) {$classes   	 = "slides show-display";} else { $classes = "slides hide-display";}
				$pixgraphy_page_sliders_display    	.= '<div class="'.$classes.'">';
				if ($image_attributes) {
					$pixgraphy_page_sliders_display 	.= '<div class="image-slider clearfix" title="'.the_title('', '', false).'"' .' style="background-image:url(' ."'" .esc_url($image_attributes[0])."'" .')">';
				}
				if ($title_attribute != '' || $excerpt != '') {
					$pixgraphy_page_sliders_display 	.= '<div class="container">';
					if($j == 1){
					$pixgraphy_page_sliders_display 	.= '<article class="slider-content clearfix pixgraphy-animation fadeInRight">';
					}else{
						$pixgraphy_page_sliders_display 	.= '<article class="slider-content clearfix">';
					}
				
				$remove_link = $pixgraphy_settings['pixgraphy_slider_link'];
					if($remove_link == 0){
						if ($title_attribute != '') {
							$pixgraphy_page_sliders_display .= '<h2 class="slider-title"><a href="'.get_permalink().'" title="'.the_title('', '', false).'" rel="bookmark">'.get_the_title().'</a></h2><!-- .slider-title -->';
						}
					}else{
						$pixgraphy_page_sliders_display .= '<h2 class="slider-title">'.get_the_title().'</h2><!-- .slider-title -->';
					}
					if ($excerpt != '') {
						$excerpt_text = $pixgraphy_settings['pixgraphy_tag_text'];
						$pixgraphy_page_sliders_display .= '<div class="slider-text">';
						$pixgraphy_page_sliders_display .= '<h3>'.$excerpt.' </h3></div><!-- end .slider-text -->';
						}
						$pixgraphy_page_sliders_display 	.='</article><!-- end .slider-content --> </div><!-- end .container -->';
				}
				if ($image_attributes) {
					$pixgraphy_page_sliders_display 	.='</div><!-- end .image-slider -->';
				}
				$pixgraphy_page_sliders_display 	.='</div><!-- end .slides -->';
				$j++;
			endwhile;
			wp_reset_postdata();
			$pixgraphy_page_sliders_display .= '</div>	  <!-- end .layer-slider -->
					<a class="slider-prev" id="prev2" href="#"><i class="fa fa-angle-left"></i></a> <a class="slider-next" id="next2" href="#"><i class="fa fa-angle-right"></i></a>
  <nav class="slider-button"> </nav>
  <!-- end .slider-button -->
</div>
<!-- end .main-slider -->';
		}
				echo $pixgraphy_page_sliders_display;
}



/*************************** ENQUEING STYLES AND SCRIPTS ****************************************/
function pixgraphy_scripts() {
	$pixgraphy_settings = pixgraphy_get_theme_options();
	wp_enqueue_style( 'pixgraphy-style', get_stylesheet_uri() );
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/font-awesome/css/font-awesome.min.css');
	if( $pixgraphy_settings['pixgraphy_animate_css'] == 'on' ) {
		wp_enqueue_style('pixgraphy-animate', get_template_directory_uri().'/assets/wow/css/animate.min.css');
		wp_enqueue_script('wow', get_template_directory_uri().'/assets/wow/js/wow.min.js', array('jquery'), false, true);
		wp_enqueue_script('wow-settings', get_template_directory_uri().'/assets/wow/js/wow-settings.js', array('jquery'),false, true);
	}
	wp_enqueue_script('jquery_cycle_all', get_template_directory_uri().'/js/jquery.cycle.all.js', array('jquery'), false, true);
	wp_enqueue_script('pixgraphy_slider', get_template_directory_uri().'/js/pixgraphy-slider-setting.js', array('jquery_cycle_all'), false, true);
	wp_enqueue_script('pixgraphy-main', get_template_directory_uri().'/js/pixgraphy-main.js', array('jquery'), false, true);
	if ( !is_admin() ) {
		wp_enqueue_script( 'masonry' );
		wp_enqueue_script('pixgraphy-masonry', get_template_directory_uri().'/js/pixgraphy-masonry.js', array('jquery'), false, true);
	}
	$pixgraphy_stick_menu = $pixgraphy_settings['pixgraphy_stick_menu'];
	if($pixgraphy_stick_menu != 1):
		wp_enqueue_script('jquery_sticky', get_template_directory_uri().'/assets/sticky/jquery.sticky.min.js', array('jquery'), false, true);
	wp_enqueue_script('sticky_settings', get_template_directory_uri().'/assets/sticky/sticky-settings.js', array('jquery'), false, true);
	endif;

	// Load the html5 shiv.
	wp_enqueue_script( 'pixgraphy-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'pixgraphy-html5', 'conditional', 'lt IE 9' );
	
	wp_style_add_data('pixgraphy-ie', 'conditional', 'lt IE 9');
	if( $pixgraphy_settings['pixgraphy_responsive'] == 'on' ) {
		wp_enqueue_style('pixgraphy-responsive', get_template_directory_uri().'/css/responsive.css');
	}

	/********* Adding Multiple Fonts ********************/
	$pixgraphy_googlefont = array();
	array_push( $pixgraphy_googlefont, 'Open+Sans:400,400italic,600');
	array_push( $pixgraphy_googlefont, 'Merriweather:400');
	$pixgraphy_googlefonts = implode("|", $pixgraphy_googlefont);
	wp_register_style( 'pixgraphy_google_fonts', '//fonts.googleapis.com/css?family='.$pixgraphy_googlefonts);
	wp_enqueue_style( 'pixgraphy_google_fonts' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pixgraphy_scripts' );
?>