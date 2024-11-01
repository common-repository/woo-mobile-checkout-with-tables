<?php

if( ! defined('ABSPATH' ) ){
	die("Direct access not allowed");
}

/**
 * rendering template against shortcode
 */
function mct_shortcodes_render_shortcode_template($atts) {
	
	wp_enqueue_script( 'wc-single-product', WC()->plugin_url() . '/assets/js/frontend/single-product.min.js', array( 'jquery' ), WC()->version, true );
	wp_enqueue_script( 'wc-add-to-cart-variation', WC()->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js', array( 'jquery' ), WC()->version, true );
	wp_enqueue_style( 'wc-pretty-photo-css', WC()->plugin_url() . '/assets/css/prettyPhoto.css');
	wp_enqueue_script( 'pretty-photo-js', WC()->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.min.js', array( 'jquery' ), WC()->version, true );
	wp_enqueue_script( 'pretty-photo-js-init', WC()->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init.min.js', array( 'jquery' ), WC()->version, true );

	/*
	** style for both views
	*/
	wp_enqueue_style( 'mct-styles' );
	

	/*
	* settings get for use in styles.php file
	*/
	$mct_staticBgColor 			=  (mct_get_option('_static_bg_color') != '') ? mct_get_option('_static_bg_color') : '#444444' ;
	$mct_staticTextColor 		=  (mct_get_option('_static_text_color') != '') ? mct_get_option('_static_text_color') : '#FFFFFF' ;
	$mct_hoverBgColor 			=  (mct_get_option('_hover_bg_color') != '') ? mct_get_option('_hover_bg_color') : '#2DB6CF' ;
	$mct_hoverTextColor 		=  (mct_get_option('_hover_text_color') != '') ? mct_get_option('_hover_text_color') : '#FFFFFF' ;
	
	ob_start();
	   include MCT_PATH . '/css/styles.php';
	$mct_custom_css = ob_get_clean();
	wp_add_inline_style( 'mct-styles', $mct_custom_css );
	
	set_transient( 'mct_table_shop_page', get_permalink(), 60 );
	
	$mct_products_view = apply_filters('mct_product_view', 'table_view');
	
	/*
	** template scripts localize
	*/
	mct_localize_script( $mct_products_view, $atts );
	/*
	** set template 
	*/

	$mct_template = mct_get_layout( $mct_products_view );

	ob_start();
		$mct_template;
	$mct_output_string = ob_get_contents();
	ob_end_clean();
		
	return $mct_output_string;
}