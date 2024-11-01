<?php 
/**
 * Plugin Name: WooCommerce Mobile Checkout with Tables
 * Plugin URI: https://najeebmedia.com/wordpress-plugin/woocommerce-mobile-checkout-table
 * Description: WooCommerce Mobile Checkout with Table display all WooCommerce products in Table View. 
 * Version: 1.2
 * Author: N-Media
 * Author URI: najeebmedia.com
 * Text Domain: woo-mct
 * WC requires at least: 3.0.0
 * WC tested up to: 3.5.0
 * License: GPL2
 */
if( ! defined('ABSPATH' ) ){
	exit;
}

define( 'MCT_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define( 'MCT_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define( 'MCT_SHORT_NAME', 'mct' );
define( 'MCT_VERSION', '1.0' );

/* ======= plugin includes =========== */
if( file_exists( dirname(__FILE__).'/inc/arrays.php' )) include_once dirname(__FILE__).'/inc/arrays.php';
if( file_exists( dirname(__FILE__).'/inc/callback-functions.php' )) include_once dirname(__FILE__).'/inc/callback-functions.php';
if( file_exists( dirname(__FILE__).'/inc/helpers.php' )) include_once dirname(__FILE__).'/inc/helpers.php';
if( file_exists( dirname(__FILE__).'/inc/cpt.php' )) include_once dirname(__FILE__).'/inc/cpt.php';
if( file_exists( dirname(__FILE__).'/inc/hooks.php' )) include_once dirname(__FILE__).'/inc/hooks.php';
if( file_exists( dirname(__FILE__).'/inc/admin.php' )) include_once dirname(__FILE__).'/inc/admin.php';
if( file_exists( dirname(__FILE__).'/inc/helper.php' )) include_once dirname(__FILE__).'/inc/helper.php';
if( file_exists( dirname(__FILE__).'/inc/shortcodes.php' )) include_once dirname(__FILE__).'/inc/shortcodes.php';

class NM_WMCT {

	function __construct(){
		/*
		 * plugin main shortcode if needed
		 */
		add_shortcode('wmct', 'mct_shortcodes_render_shortcode_template');
		/*
		 * hooking up scripts for front-end
		*/
		add_action('wp_enqueue_scripts', 'mct_hooks_load_scripts');
		/**
		 * add settings in main menu page
		 */
		add_action('admin_menu', 'mct_hooks_add_menu_pages');
		/**
		 * laoding admin scripts only for plugin pages
		 */
		add_action( 'admin_enqueue_scripts', 'mct_hooks_load_scripts_admin');
		/*
		 * registering callbacks
		*/
		mct_hooks_do_callbacks();
		
		// Print notices
		add_action('mct_before_price_table', 'wc_print_notices', 10);
		
		// Add to cart URL
		add_filter('mct_add_to_cart_url', 'mct_hooks_add_to_cart_url', 10, 2);
	}
}
// lets start plugin
add_action('woocommerce_init', 'mct_start');
function mct_start() {

	return new NM_WMCT();
}