<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Pixgraphy
 * @since Pixgraphy 1.0
 */
/******************** PIXGRAPHY SLIDER SETTINGS ******************************************/
$pixgraphy_settings = pixgraphy_get_theme_options();
$wp_customize->add_section( 'featured_content', array(
	'title' => __( 'Slider Settings', 'pixgraphy' ),
	'priority' => 140,
	'panel' => 'pixgraphy_featuredcontent_panel'
));
$wp_customize->add_setting( 'pixgraphy_theme_options[pixgraphy_enable_slider]', array(
	'default' => $pixgraphy_settings['pixgraphy_enable_slider'],
	'sanitize_callback' => 'pixgraphy_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'pixgraphy_theme_options[pixgraphy_enable_slider]', array(
	'priority'=>12,
	'label' => __('Enable Slider', 'pixgraphy'),
	'section' => 'featured_content',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
	'frontpage' => __('Front Page','pixgraphy'),
	'enitresite' => __('Entire Site','pixgraphy'),
	'disable' => __('Disable Slider','pixgraphy'),
),
));
$wp_customize->add_section( 'pixgraphy_page_post_options', array(
	'title' => __('Display Page Slider','pixgraphy'),
	'priority' => 200,
	'panel' =>'pixgraphy_featuredcontent_panel'
));
for ( $i=1; $i <= $pixgraphy_settings['pixgraphy_slider_no'] ; $i++ ) {
	$wp_customize->add_setting('pixgraphy_theme_options[pixgraphy_featured_page_slider_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'pixgraphy_sanitize_page',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'pixgraphy_theme_options[pixgraphy_featured_page_slider_'. $i .']', array(
		'priority' => 220 . $i,
		'label' => __(' Page Slider #', 'pixgraphy') . ' ' . $i ,
		'section' => 'pixgraphy_page_post_options',
		'type' => 'dropdown-pages',
	));
}       
?>