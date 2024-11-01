<?php

if( ! defined('ABSPATH' ) ){
	die("Direct access not allowed");
}

/**
 * menu array is set here and
 * use in inc/hooks.php file
 * function mct_hooks_add_menu_pages() to add menus
 */
function mct_menu_pages() {
	$mct_menus	=	array(
						array(	
							'page_title'	=> 'Woo MCT',
							'menu_title'	=> 'Woo MCT',
							'cap'			=> 'manage_options',
							'slug'			=> MCT_SHORT_NAME,
							'callback'		=> 'mct_settings',
							'parent_slug'		=> '',
						),
					);
	return $mct_menus;
}

/**
 * admin scripts
 */
function mct_admin_scripts() {
	return array(
		
				array(	'script_name'	=> 'scripts-chosen',
						'script_source'	=> 'js/chosen/chosen.jquery.min.js',
						'localized'		=> false,
						'type'			=> 'js',
						'page_slug'		=> MCT_SHORT_NAME,
						'depends' => array ('jquery'),
					),
				
				array (
						'script_name' => 'chosen-style',
						'script_source' => 'js/chosen/chosen.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => MCT_SHORT_NAME,
				),

				array(	'script_name'	=> 'scripts-admin',
						'script_source'	=> 'js/admin.js',
						'localized'		=> true,
						'type'			=> 'js',
						'page_slug'		=> MCT_SHORT_NAME,
						'depends' => array (
								'jquery',
								'jquery-ui-tabs',
								'wp-color-picker',
								//'media-upload',
								//'thickbox'
						),
						'in_footer'	=> true,
				),
				
				
				array (
						'script_name' => 'ui-style',
						'script_source' => 'js/ui/css/smoothness/jquery-ui-1.10.3.custom.min.css',
						'localized' => false,
						'type' => 'style',
						'page_slug' => MCT_SHORT_NAME,
				),
				
				array (
						'script_name' => 'thickbox',
						'script_source' => 'shipped',
						'localized' => false,
						'type' => 'style',
						'page_slug' => MCT_SHORT_NAME,
				),
				
				array (
						'script_name' => 'wp-color-picker',
						'script_source' => 'shipped',
						'localized' => false,
						'type' => 'style',
						'page_slug' => array (
								MCT_SHORT_NAME,
						)
				),
				
				
		);
}

/**
 * setitngs option
 */

function mct_settigns() {

	$mct_meatGeneral = array(
		'product_page_view' => array(
			'label' => __( 'Porducts view', 'woo-mct' ),
			'desc' => __( 'Select the view of products', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_page_view',
			'type' => 'select',
			'default' => __( 'Select View', 'woo-mct' ),
			'help' => __( 'Default is table view.Get Pro for both views.', 'woo-mct' ),
			'options' => array(
							'grid_view' 	=> __( 'Grid view', 'woo-mct' ),
							'table_view' 	=> __( 'Table view', 'woo-mct' ), 
						)
		),
	);


	
	$mct_meattableviewsettings = array(
		'product_id' => array(
			'label' => __( 'Product ID', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_id',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> true,
		),

		'product_name' => array(
			'label' => __( 'Product Name', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_name',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> false,
		),
		'product_thumb' => array(
			'label' => __( 'Product Thumbnail', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_thumb',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> false,
		),
		'product_detail' => array(
			'label' => __( 'Product Detail', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_detail',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> true,
		),
		'product_categories' => array(
			'label' => __( 'Product Categories', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_categories',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> true,
		),
		'product_price' => array(
			'label' => __( 'Product Price', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_price',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> false,
		),
		'product_s_price' => array(
			'label' => __( 'Sale Price', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_s_price',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> true,
		),

		'product_rating' => array(
			'label' => __( 'Ratings', 'woo-mct' ),
			'desc' => __( '', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_product_rating',
			'type' => 'checkbox',
			'options' => array(
						'yes' => __( 'show in table', 'woo-mct' ),
			),
			'help' => __( '', 'woo-mct' ),
			'is_pro'	=> true,
		),

	);

	$mct_meatShortcode = array(
		'products_shortcode' => array(
			'label' => __( 'Our shortcode is ', 'woo-mct' ),
			'id' => MCT_SHORT_NAME . '_products_shortcode_copy_btn',
			'type' => 'info',
			'detail' => __( '[wmct]', 'woo-mct' ),
			'help' => __( 'Copy and use this shortcode.', 'woo-mct' ),
		),
	);


	$mct_options = array(
		'general_settings' => array(
			'name' => __( 'General Settings', 'woo-mct' ),
			'type' => 'tab',
			'desc' => __( 'Set view for Products.', 'woo-mct' ),
			'meat' => $mct_meatGeneral
		),
		'table_meta_settings' => array(
			'name' => __( 'Table view settings', 'woo-mct' ),
			'type' => 'tab',
			'desc' => __( 'set table view settigns', 'woo-mct' ),
			'meat' => $mct_meattableviewsettings
		),
		'mct_help' => array(
			'name' => __( 'Shortcode Help', 'woo-mct' ),
			'type' => 'tab',
			'desc' => __( 'Shortcode settings', 'woo-mct' ),
			'meat' => $mct_meatShortcode
		),
	);

	return apply_filters('mct_options', $mct_options);
}

/**
 * ajaxcallback urls
 */
function mct_ajax_callbacks(){
	
	return array(
		'mct_save_settings'			=> true,
		'mct_get_single_product'	=> false,
		'mct_add_to_cart'			=> false,
		'mct_get_cart_template'		=> false,
		'mct_delete_item_from_cart'	=> false,
		'mct_apply_coupon_code'		=> false,
		'mct_remove_coupon_code('	=> false,
		'mct_get_checkout_template' => false,
		'mct_empty_cart'			=> false,
		'mct_get_all_products_table'=> false,
		'mct_quick_view'			=> false,
	);
}


// Return message for Localization
function mct_array_messages() {
	
	$messages = array('loading_products'	=> __("Loading Products ...", "woo-mct"));
	
	return apply_filters('mct_messages', $messages);
}