<?php
/**
 * The template for displaying search results.
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
		<main id="main">
			<?php global $post;
			if( have_posts() ) {
				while( have_posts() ) {
					the_post(); ?>
				<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<article class="post-format">
						<header class="entry-header">
							<h2 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
							<?php the_title(); ?> </a> </h2> <!-- .entry-title -->
						</header>
						<div class="entry-content clearfix">
							<?php the_excerpt(); ?>
						</div>
					</article>
				</section>
				<?php }
			} else { ?>
			<h2 class="entry-title">
				<?php get_search_form(); ?>
				<p>&nbsp; </p>
				<?php esc_html_e( 'No Posts Found.', 'pixgraphy' ); ?>
			</h2>
			<?php } ?>
		</main> <!-- #main -->
		<?php get_template_part( 'pagination', 'none' );
		if( 'default' == $layout ) { //Settings from customizer
			if(($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'nosidebar') && ($pixgraphy_settings['pixgraphy_sidebar_layout_options'] != 'fullwidth')): ?>
		</div> <!-- #primary -->
	<?php endif;
	}
get_sidebar();
get_footer(); ?>