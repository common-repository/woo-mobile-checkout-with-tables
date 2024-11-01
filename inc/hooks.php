<?php

if( ! defined('ABSPATH' ) ){
	die("Direct access not allowed");
}
/**
 * Register all scripts befor enque
*/
function mct_hooks_load_scripts() {
	
	wp_register_script( 'angular-js', MCT_URL .'/js/angular.min.js', array('jquery'));
	wp_register_script( 'mct-script', MCT_URL .'/js/ngwoostore.js', array('angular-js'));
	wp_register_script( 'mct-tbale-script', MCT_URL .'/js/ngwoostore-table.js', array('jquery'));
	wp_register_script( 'mct-data-tbale', MCT_URL .'/js/jquery.dataTables.min.js', array('jquery'));
	wp_register_script( 'mct-modal-js', MCT_URL .'/js/iziModal.min.js', array('jquery'));
	wp_register_script( 'mct-tooltip-js', MCT_URL .'/js/tooltipster.bundle.min.js', array('jquery'));
	wp_register_script( 'mct-bootstrap-data-tbale', MCT_URL .'/js/dataTables.bootstrap4.min.js', array('jquery'));
	wp_register_style( 'font-awesome', MCT_URL .'/font-awesome/css/font-awesome.min.css' );
	wp_register_style( 'mct-styles', MCT_URL .'/css/plugin.styles.css', array('font-awesome') );
	wp_register_style( 'mct-izi-modal', MCT_URL .'/css/iziModal.min.css' );
	wp_register_style( 'mct-tooltip', MCT_URL .'/css/tooltipster.bundle.min.css' );
	// wp_register_style( 'mct-data-table-styles', MCT_URL .'/css/bootstrap4.min.css' );
	wp_register_style( 'mct-bootstrap-table-styles', MCT_URL .'/css/dataTables.bootstrap4.min.css' );
	
	/*wp_enqueue_script( 'wc-single-product');
    wp_enqueue_script( 'wc-add-to-cart-variation');*/
	
}
	
/*
* add menu pages
*/
function mct_hooks_add_menu_pages(){
	/*
	* mct_menu_pages() get the array of menu pages
	* form inc/arrays.php
	*/
    $mct_menu = mct_menu_pages();

    foreach ( $mct_menu as $page){
        
      	if ($page['parent_slug'] == ''){

	        $menu = add_menu_page(
	           __($page['page_title'].' Settings', 'woo-mct'),
	        	__($page['menu_title'].' Settings', 'woo-mct'),
	            $page['cap'],
	            $page['slug'],
	            $page['callback']
	        );

      	}else{

	        $menu = add_submenu_page($page['parent_slug'],
	        	__($page['page_title'].' Settings', 'woo-mct'),
	        	__($page['menu_title'].' Settings', 'woo-mct'),
	            $page['cap'],
	            $page['slug'],
	            $page['callback']
	        );
     	}
    
    }
}

/**
 * settigns for plugin
 */
function mct_settings(){

	mct_load_templates('admin/settings.php');
}

/**
 * load scripts for admin 
 */
function mct_hooks_load_scripts_admin( $hook ) {

	/**
	 * mct_admin_scripts() get array of admin scripts
	 * in inc/arrays.php
	 */
	$mct_admin_scripts = mct_admin_scripts();

	foreach ( $mct_admin_scripts as $script ) {
	
		$attach_script = false;
		if (is_array ( $script ['page_slug'] )) {
				
			
			foreach( $script ['page_slug'] as $page){
				/**
				 * its very important var, when menu page is loaded as submenu of current plugin
				 * then it has different hook_suffix
				 */
				$plugin_sublevel = "THE_PLUGIN_HOOK".$page;
				$plugin_toplevel = "toplevel_page_".$page;
				
				if ( $hook == $plugin_toplevel || $hook == $plugin_sublevel){
					$attach_script = true;
				}
			}	
		} else {
			/**
				 * its very important var, when menu page is loaded as submenu of current plugin
				 * then it has different hook_suffix
				 */
				$plugin_sublevel = "THE_PLUGIN_HOOK".$script ['page_slug'];
				$plugin_toplevel = "toplevel_page_".$script ['page_slug'];
				
				if ( $hook == $plugin_toplevel || $hook == $plugin_sublevel){
					
					$attach_script = true;
				}
		}
		//echo 'script page '.$script_pages;
		if( $attach_script ){
			
			// adding media upload scripts (WP 3.5+)
			wp_enqueue_media();
			
			// localized vars in js
			$arrLocalizedVars = array (
					'plugin_url' => MCT_URL,
					'doing' => MCT_URL . '/images/loading.gif',
					'plugin_admin_page' => admin_url ( 'options-general.php?page=nm_opw' )
			);
			
			// checking if it is style
			if ($script ['type'] == 'js') {
				$depends = (isset($script['depends']) ? $script['depends'] : NULL);
				$in_footer = (isset($script['in_footer']) ? $script['in_footer'] : false);
				wp_enqueue_script ( MCT_SHORT_NAME . '-' . $script ['script_name'], MCT_URL . '/' . $script ['script_source'], $depends, MCT_VERSION, $in_footer );
					
				// if localized
				if ($script ['localized'])
					wp_localize_script ( MCT_SHORT_NAME . '-' . $script ['script_name'], 'mct_vars', $arrLocalizedVars );
			} else {
					
				if ($script ['script_source'] == 'shipped')
					wp_enqueue_style ( $script ['script_name'] );
				else
					wp_enqueue_style ( MCT_SHORT_NAME . '-' . $script ['script_name'], MCT_URL. '/'. $script ['script_source'] );
			}
		}
	}
}

// Add to cart URL
function mct_hooks_add_to_cart_url( $url, $product ) {
	
	$selected_meta_id = '';
	$product_id = $product->get_id();
	
	if( function_exists('ppom_has_product_meta') ) {
		
		$product_id = ppom_get_product_id($product);
	  	if( ! $selected_meta_id = ppom_has_product_meta( $product_id ) ) {
			// if( ! ppom_has_category_meta( $product_id ) ){
				
			// }
			return $url;
		}
	}

  	if ( !in_array($product->get_type(), array('variable', 'grouped', 'external')) ) {
  		// only if can be purchased
  		if ($selected_meta_id) {
  			return get_permalink($product_id);
  		}
  	}
  	
  	return $url;
}

/**
 * registering callback
 */
function mct_hooks_do_callbacks(){
	/*
	** mct_ajax_callbacks() get array of calbacks
	** in inc/arrays.php
	*/
	$ajax_callbacks = mct_ajax_callbacks();
	/*
	** all calback function in inc/calbacks-functions.php
	*/
	foreach ($ajax_callbacks  as $callback => $viewer){
		add_action( 'wp_ajax_'.$callback, $callback );

		// if logged in user can see
		if(!$viewer)
			add_action( 'wp_ajax_nopriv_'.$callback, $callback );
	}
}

