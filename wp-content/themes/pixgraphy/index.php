<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */

get_header();
	$pixgraphy_settings = pixgraphy_get_theme_options();
	if($pixgraphy_settings['pixgraphy_photography_layout'] != 'photography_layout'){
	global $post;	
	global $pixgraphy_content_layout;
	if( $post ) {
		$layout = get_post_meta( $post->ID, 'pixgraphy_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}
	if( 'default' == $layout ) { //Settings from customizer
		if(($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'nosidebar') && ($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'fullwidth')){ ?>
			<div id="primary">
				<?php }
	}?>
				<main id="main" class="site-main clearfix">
					<?php global $post;
					if( have_posts() ) {
						while( have_posts() ) {
							the_post();
							get_template_part( 'content', get_post_format() );
						}
					}
					else { ?>
					<h2 class="entry-title"> <?php esc_html_e( 'No Posts Found.', 'pixgraphy' ); ?> </h2>
					<?php } ?>
					<?php get_template_part( 'pagination', 'none' ); ?>
				</main> <!-- #main -->
	<?php
	if( 'default' == $layout ) { //Settings from customizer
		if(($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'nosidebar') && ($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'fullwidth')): ?>
			</div> <!-- #primary -->
			<?php endif;
	}
get_sidebar();
}else{ ?>
	<!-- post_masonry ============================================= -->
<section id="post_masonry" class="<?php echo esc_attr($pixgraphy_settings['pixgraphy_column_post']);?>-column-post clearfix">
	<?php	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			get_template_part( 'content');
		}
	} ?>
</section>
<?php get_template_part( 'pagination', 'none' ); ?>
<!-- end #post_masonry -->
<?php }
get_footer(); ?>