<?php

if( ! defined('ABSPATH' ) ){
	die("Direct access not allowed");
}
/*
 * saving admin setting in wp option data table
 */
function mct_save_settings(){

    $mct_settings = array(
        "mct_product_page_view"     => sanitize_text_field( $_REQUEST['mct_product_page_view'] ),
        "mct_product_id"            => sanitize_text_field( $_REQUEST['mct_product_id'] ),
        "mct_product_name"          => sanitize_text_field( $_REQUEST['mct_product_name'] ),
        "mct_product_thumb"         => sanitize_text_field( $_REQUEST['mct_product_thumb'] ),
        "mct_product_detail"        => sanitize_text_field( $_REQUEST['mct_product_detail'] ),
        "mct_product_categories"    => sanitize_text_field( $_REQUEST['mct_product_categories'] ),
        "mct_product_price"         => sanitize_text_field( $_REQUEST['mct_product_price'] ),
        "mct_product_s_price"       => sanitize_text_field( $_REQUEST['mct_product_s_price'] ),
        "mct_product_rating"        => sanitize_text_field( $_REQUEST['mct_product_rating'] ),
        );

	update_option( MCT_SHORT_NAME .'_settings', apply_filters("mct_settigns_array", $mct_settings) );
	_e('All options are updated', 'woo-mct');
	die(0);
}

// Getting all products
function mct_get_all_products_table() {
    
    /**
    ** get all coulmns to show
    **/
    $mct_coulmns = mct_get_columns();


    $args = array(
        'posts_per_page' => -1,        
        'post_type' => 'product',
        'orderby' => 'title'
    );
    $mct_cat_id = ( isset($_REQUEST['catid']) && $_REQUEST['catid'] != '0' ) ? intval( $_REQUEST['catid'] ): '';
    
    if( $mct_cat_id != '' ) {
      $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'ID',
                // 'terms' => 'white-wines'
                'terms' => $mct_cat_id,
            )
        );
    }

    $mct_products = new WP_Query( $args );
    while ( $mct_products->have_posts() ) {
        $mct_products->the_post();
        $_product = wc_get_product( get_the_id() );

        $title          = '<a href="'.esc_url($_product->get_permalink()).'">'.get_the_title().'</a>';
        // $add_to_cart     = '<a href="'.esc_url($_product->add_to_cart_url()).'">Add to Cart</a>';
        if (apply_filters('mct_version_check', 'standard') == 'standard') {

            $thumbnail      = '<a class="img-tooltip" data-tooltip-content="#mct-tooltip_content'.esc_attr(get_the_id()).'" href="'.esc_url($_product->get_permalink()).'">'.get_the_post_thumbnail( get_the_id(), 'medium' ).'</a>';
        }elseif ( apply_filters('mct_version_check', 'standard') == 'pro') {
            
            $thumbnail      = '<a class="img-tooltip" data-tooltip-content="#mct-tooltip_content'.esc_attr(get_the_id()).'" href="'.esc_url($_product->get_permalink()).'">'.get_the_post_thumbnail( get_the_id(), 'medium' ).'</a><div class="mct-tooltip-img" style="display:none;padding:0px;"><span style="margin:0px;padding:0px;" id="mct-tooltip_content'.esc_attr(get_the_id()).'">'.get_the_post_thumbnail( get_the_id() ).'</span></div><i style="text-align:  center;display: block;" title="Quick view" class="fa fa-eye get-quick-view" data-modal-title="'.get_the_title().'" data-modal-id="'.esc_attr(get_the_id()).'" aria-hidden="true" ></i></a>';
            $thumbnail      .= '<div class="mct_modal" id="mct-image-'.esc_attr(get_the_id()).'">loading ....</div>';            
        }

        // quantity input html
        $quantity_input = mct_render_quantity_input( $_product );
        $add_to_cart_button = mct_get_add_to_cart_url($_product);
        $quantity_and_addtocart = $quantity_input.' '.$add_to_cart_button;
        // var_dump($product_add_to_cart);
        foreach ($mct_coulmns as $key => $column) {
                
            if ( $column == 'id')
                $product_values['id'] = get_the_id();

            if ( $column == 'thumbnail' )
                $product_values['thumbnail'] = $thumbnail;

            if ( $column == 'name' )
                $product_values['name'] = $title;

            if ( $column == 'excerpt' )
                $product_values['excerpt'] = get_the_excerpt();

            if ( $column == 'price' )
                $product_values['price'] = $_product->get_price_html();

            // if ( $column == 'sale_price' )
            //     $product_values['sale_price'] = ($_product->get_sale_price()) ? true : false;

            if ( $column == 'categories' )
                $product_values['categories'] = wc_get_product_category_list(get_the_id());

            if ( $column == 'product_rating' )
                $product_values['product_rating'] = mct_get_product_rating($_product);;

            // always show cart buttton
            if ( $column == 'add_to_cart' )
                $product_values['add_to_cart'] = $quantity_and_addtocart;   
        }
        $mct_all_products[] = $product_values;
    }
    
    wp_reset_query();

    wp_send_json( array('data'=>$mct_all_products));
}

/*
** 
*/
function mct_quick_view(){
	//setting the product_id
    $product_id = intval( $_REQUEST['product_id'] );
    
    /* ============ this block is to make plugin compatibel with other plugins ======== */
        
        // check for plugin using plugin name
        if (  is_ppom_plugin_active() ) {
          
            remove_action ( 'woocommerce_before_add_to_cart_button', 'ppom_woocommerce_show_fields', 15 );
    		
    		//check plugin if meta is attached
    		if( $ppom_meta_id = ppom_has_product_meta($product_id) ){
    		    
    		    set_transient('mct_product_id', $product_id);
    		    add_action('woocommerce_after_add_to_cart_form', 'mct_redirect_link_product_page');
    		    
    		    //now hiding the add to cart button
    		    echo '<script type="text/javascript">jQuery("form.cart").hide();</script>';
    		}
        }
        
        /*if ( is_plugin_active('woo-product-designer/index.php')) {
          
            global $nm_wcpd;
            
            remove_action ( 'woocommerce_before_add_to_cart_button', array (
    				$nm_wcpd,
    				'render_product_designer' 
    		), 15 );
    		
    		//check plugin if meta is attached
    		$design_attched = get_post_meta ( $product_id, 'wcpd_design_id', true );
    		if(isset($design_attched) && $design_attched != 0){
    		    add_action('woocommerce_after_add_to_cart_form', 'mct_redirect_link_product_page');
    		    
    		    //now hiding the add to cart button
    		    echo '<script type="text/javascript">jQuery("form.cart").hide();</script>';
    		}
        }*/
                    
        
    /* ============ --block ends-- ======== */
    
    /*$args = array('p'   => $product_id, 'post_type' => array('product'));

    $thepost = new WP_Query( $args );

    if ( $thepost->have_posts() ) : while ( $thepost->have_posts() ) : $thepost -> the_post();
    
    $GLOBALS['withcomments'] = 0;
    $GLOBALS['withreviews'] = 0;

    ob_start();
    
    wc_get_template_part( 'content', 'single-product');
    $output_string = ob_get_contents();
    ob_end_clean();
    
    $output_string = '<div class="woocommerce">'.$output_string.'</div>';
    // echo apply_filters( 'the_content', $output_string );
    
    
    endwhile;
    else:
    endif;

    wp_reset_query();*/
    echo do_shortcode('[product_page id="'.$product_id.'"]');

    die(0);
}


    
/*
 * add an item in cart with quantity and update on menu
 */

function mct_add_to_cart(){
	parse_str($_REQUEST['formData']);

    $variation_id   = intval( $variation_id );
    $quantity       = intval( $quantity );
    $variation      = sanitize_text_field( $variation );
    $product_id     = intval( $product_id );

	if (isset($variation_id)) {
		
		$wc_variation = json_decode( stripslashes( $variation ), true );
		//var_dump( $wc_variation ); exit;

		WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $wc_variation );
		
	} else {
        // var_dump("else");
		WC()->cart->add_to_cart( $product_id, $quantity );
	}

	WC()->cart->calculate_totals();
	
 	echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'woo-mct'),
	WC()->cart->cart_contents_count) . ' - '.WC()->cart->get_cart_total();
	die(0);
}

/*
** 
*/
function mct_get_single_product(){
    //setting the product_id
    $product_id = intval( $_REQUEST['product_id'] );
    
    /* ============ this block is to make plugin compatibel with other plugins ======== */
        
        // first thing is first, checking if PPOM plugin is activated.
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // check for plugin using plugin name
        if ( is_plugin_active( 'nm-woocommerce-personalized-product/index.php' ) ) {
          
            global $nmpersonalizedproduct;
            
            remove_action ( 'woocommerce_before_add_to_cart_button', array (
                    $nmpersonalizedproduct,
                    'render_product_meta' 
            ), 15 );
            
            //check plugin if meta is attached
            $meta_attched = get_post_meta ( $product_id, '_product_meta_id', true );
            if(isset($meta_attched) && $meta_attched != 0){
                add_action('woocommerce_after_add_to_cart_form', 'mct_redirect_link_product_page');
                
                //now hiding the add to cart button
                echo '<script type="text/javascript">jQuery("form.cart").hide();</script>';
            }
        }
        
        if ( is_plugin_active('woo-product-designer/index.php')) {
          
            global $nm_wcpd;
            
            remove_action ( 'woocommerce_before_add_to_cart_button', array (
                    $nm_wcpd,
                    'render_product_designer' 
            ), 15 );
            
            //check plugin if meta is attached
            $design_attched = get_post_meta ( $product_id, 'wcpd_design_id', true );
            if(isset($design_attched) && $design_attched != 0){
                add_action('woocommerce_after_add_to_cart_form', 'mct_redirect_link_product_page');
                
                //now hiding the add to cart button
                echo '<script type="text/javascript">jQuery("form.cart").hide();</script>';
            }
        }
                    
        
    /* ============ --block ends-- ======== */
    
    global $product, $post;
    
    $args = array('p'   => $product_id, 'post_type' => array('product'));

    $thepost = new WP_Query( $args );

    if ( $thepost->have_posts() ) : while ( $thepost->have_posts() ) : $thepost -> the_post();
    
    $GLOBALS['withcomments'] = 1;

    ob_start();

    $woocommerce_product_template = mct_get_single_product_template();
    if( file_exists($woocommerce_product_template) ){
        include_once( $woocommerce_product_template);
    }else{
        die('help me to find '.$woocommerce_product_template);
    }

    $output_string = ob_get_contents();
    ob_end_clean();
            
    echo $output_string;
    endwhile;
    else:
    endif;

    wp_reset_query();

    die(0);
}
/*
 * Get Full Cart Template
 */

function mct_get_cart_template(){

	
	if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
		define( 'WOOCOMMERCE_CART', true );
	}
	

	WC()->cart->calculate_totals();

	if ( WC()->cart->get_cart_contents_count() == 0 ) {
	    echo '<p>Your cart is currently empty.</p><br><a class="button nmreturn">Return to Shop</a>';
	} else {
		$path = WC()->plugin_path() . '/templates/cart/cart.php';
		echo load_template( $path );
	}

	die(0);
}

/*
 * delete item from cart
 */

function mct_delete_item_from_cart(){
	extract($_REQUEST);

    $key = sanitize_text_field($key);
	WC()->cart->remove_cart_item( $key );

	// Updating menu button
	echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'woo-mct'),
	WC()->cart->cart_contents_count) . ' - '.WC()->cart->get_cart_total();
	die(0);
}

/*
 * Apply coupon
 */
function mct_apply_coupon_code(){
    extract($_REQUEST);
    
    $code  = sanitize_text_field($code);

    if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
        define( 'WOOCOMMERCE_CART', true );
    }
    WC()->cart->add_discount( $code );
    
    WC()->cart->calculate_totals();

    $path = WC()->plugin_path() . '/templates/cart/cart.php';
    echo load_template( $path );
    die(0);
}

/*
 * Remove coupon
 */
function mct_remove_coupon_code(){
    extract($_REQUEST);
    $code  = sanitize_text_field($code);
    if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
        define( 'WOOCOMMERCE_CART', true );
    }
    WC()->cart->remove_coupon( $code );

    WC()->cart->calculate_totals();

    $path = WC()->plugin_path() . '/templates/cart/cart.php';
    echo load_template( $path );
    die(0);
}

/**
 * Get Checkout Template
 */

function mct_get_checkout_template(){

    
    if ( ! defined( 'WOOCOMMERCE_CHECKOUT' ) ) {
        define( 'WOOCOMMERCE_CHECKOUT', true );
    }

    // Get checkout object
    $checkout = WC()->checkout();
    wc_get_template( 'checkout/form-checkout.php', array( 'checkout' => $checkout ) );

    // $path = WC()->plugin_path() . '/templates/checkout/form-checkout.php';

    // echo load_template( $path );
    die(0);
}

/*
 * empty cart
 */

function mct_empty_cart(){
    if ( ! defined( 'WOOCOMMERCE_CART' ) ) {
        define( 'WOOCOMMERCE_CART', true );
    }
    

    WC()->cart->empty_cart();

    if ( WC()->cart->get_cart_contents_count() == 0 ) {
        echo '<p>Your cart is currently empty.</p><br><a class="button nmreturn">Return to Shop</a>';
    } else {
        $path = WC()->plugin_path() . '/templates/cart/cart.php';
        echo load_template( $path );
    }

    die(0);
}