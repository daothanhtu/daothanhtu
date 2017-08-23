<?php
/**
 * The template for displaying 404 pages
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */
get_header();
$pixgraphy_settings = pixgraphy_get_theme_options();
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
	<article id="post-0" class="post error404 not-found">
		<?php if ( is_active_sidebar( 'pixgraphy_404_page' ) ) :
			dynamic_sidebar( 'pixgraphy_404_page' );
		else:?>
		<section class="error-404 not-found">
			<header class="page-header">
				<h2 class="page-title"> <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'pixgraphy' ); ?> </h2>
			</header> <!-- .page-header -->
			<div class="page-content">
				<p> <?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'pixgraphy' ); ?> </p>
					<?php get_search_form(); ?>
			</div> <!-- .page-content -->
		</section> <!-- .error-404 -->
	<?php endif; ?>
	</article> <!-- #post-0 .post .error404 .not-found -->
</main> <!-- #main -->
<?php 
if( 'default' == $layout ) { //Settings from customizer
	if(($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'nosidebar') && ($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'fullwidth')): ?>
</div> <!-- #primary -->
<?php endif;
}
get_sidebar();
get_footer(); ?>