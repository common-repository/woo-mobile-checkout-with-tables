<?php

if( ! defined('ABSPATH' ) ){
	die("Direct access not allowed");
}


function mct_pa($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

// loading template files
function mct_load_templates( $template_name, $vars = null) {
    if( $vars != null && is_array($vars) ){
    extract( $vars );
    }

    $template_path =  MCT_PATH . "/templates/{$template_name}";
    if( file_exists( $template_path ) ){
    	include_once( $template_path );
    } else {
     die( "Error while loading file {$template_path}" );
    }
}


/**
 * Rnedred input fields
 */
function mct_render_settings_input($data) {

    $field_id   = $data['id'];
    $type       = $data['type'];
    $plugin_settings = get_option(  MCT_SHORT_NAME.'_settings');
    if(isset($plugin_settings[ $data['id']]) && !is_array($plugin_settings[ $data['id']]))
        $value    = stripslashes( $plugin_settings[ $data['id']] );
    else 
        $value    = isset($plugin_settings[ $data['id']]) ? $plugin_settings[ $data['id']] : '';
    
    $options  = (isset($data['options']) ? $data['options'] : '');

    switch($type) {

        case 'text' :
            echo '<input type="text" name="' . esc_attr( $field_id ) . '" id="' . esc_attr( $field_id ). '" value="' . esc_attr( $value ). '" class="regular-text">';
        break;

        case 'info' :
            echo $data['detail'];
        break;

        case 'textarea':
            echo '<textarea cols="45" rows="6" name="' . esc_attr( $field_id ). '" id="' . esc_attr( $field_id ). '" >'.esc_textarea( $value ).'</textarea>';
        break;

        case 'checkbox':
            foreach($options as $k => $label){
            $label_id = $field_id.'-'.$k;
            echo '<label for="'.esc_attr( $label_id ).'">';
            echo '<input type="checkbox" name="' . esc_attr( $field_id ). '" id="'.esc_attr($label_id ).'" value="' . esc_attr( $k ) . '" '.checked( $value, $k, false).'>';
            printf(__("%s", 'woo-mct'), $label);
            echo '</label>';
            }

        break;
        
      case 'radio':
      
        foreach($options as $k => $label){
            
          $label_id = $field_id.'-'.$k;
          echo '<label for="'.esc_attr( $label_id ).'">';
          echo '<input type="radio" name="' . esc_attr( $field_id ). '" id="'.esc_attr( $label_id ).'" value="' . esc_attr( $k ). '" '.checked( $value, $k, false).'>';
          printf(__("%s", 'woo-mct'), $label);
          echo '</label> ';
        }
      
        break;
        
      case 'select':
        
        $default = (isset($data['default']) ? $data['default'] : 'Select option');
        
        echo '<select name="' . esc_attr( $field_id ). '" id="' . esc_attr( $field_id ). '" class="the_chosen">';
        echo '<option value="">'.esc_html( $default ).'</option>';
        
        foreach($options as $k => $label){
        
          echo '<option value="'.esc_attr( $k).'" '.selected( $value, $k, false).'>'.esc_html($label ).'</option>';
        }
        
        echo '</select>';
        break;
        
      case 'color' :
        echo '<input type="text" name="' . esc_attr( $field_id ). '" id="' . esc_attr( $field_id ). '" value="' . esc_attr( $value ). '" class="wp-color-field">';
        break;
        
      // =========== some special settings ====================
      
      case 'users':
      
        $default = (isset($data['default']) ? $data['default'] : 'Select option');
        
                
        $args = array(  'blog_id'      => $GLOBALS['blog_id'],
                'orderby'      => 'nicename',
                'order'        => 'ASC',);
        
        $wp_users = get_users($args);
        
        $multiple = ($data['multiselect'] == true ? 'multiple' : '');       
        $select_name = $field_id . '[]';
        echo '<select name="' .esc_attr( $select_name ) .'" id="' . esc_attr( $field_id ). '" class="the_chosen" '.esc_attr($multiple).'>';
        echo '<option value="">'.esc_html($default).'</option>';
      
        foreach($wp_users as $user){
          
          if($value){
            if(in_array($user -> ID, $value))
              $selected = 'selected="selected"';
            else
              $selected = '';
          }
                
          $label = $user -> display_name . ' ('.$user -> user_login.')';
          echo '<option value="'.esc_attr( $user -> ID ).'" '.$selected.'>'.esc_html( $label ).'</option>';
        }
      
        echo '</select>';
        break;
        
      case 'categories':
          
        $default = (isset($data['default']) ? $data['default'] : 'Select option');
      
      
        $args = array(  
            'type'                     => 'post',
            'child_of'                 => 0,
            'parent'                   => '',
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => 0,
            'hierarchical'             => 1,);
      
        $wp_cats = get_categories($args);
      
        $multiple = ($data['multiselect'] == true ? 'multiple' : '');
        $select_name = $field_id . '[]';
        echo '<select name="' . esc_attr( $select_name ) .'" id="' . esc_attr( $field_id ). '" class="the_chosen" '.esc_attr( $multiple ). '>';
        echo '<option value="">'.$default.'</option>';
          
        foreach($wp_cats as $cat){
            
          if($value){
            if(in_array($cat -> term_id, $value))
              $selected = 'selected="selected"';
            else
              $selected = '';
          }
      
          $label = $cat -> name . ' ('.$cat -> category_nicename.')';
          echo '<option value="'. esc_attr( $cat -> term_id ).'" '.$selected.'>'.esc_html( $label ).'</option>';
        }
          
        echo '</select>';
        break;
        
      case 'pages':
        
        
        $default = (isset($data['default']) ? $data['default'] : 'Select option');          
          
        $args = array(
            'sort_order' => 'ASC',
            'sort_column' => 'post_title',
            'post_type' => 'page',
            'post_status' => 'publish');
          
        $wp_pages = get_pages($args);
          
        $multiple = ($data['multiselect'] == true ? 'multiple' : '');
        $select_name = $field_id . '[]';
        echo '<select name="' . esc_attr( $select_name ). '" id="' . esc_attr( $field_id ). '" class="the_chosen" '. esc_attr( $multiple ).'>';
        echo '<option value="">'.esc_html( $default ).'</option>';
          
        foreach($wp_pages as $page){
      
          if($value){
            if(in_array($page -> ID, $value))
              $selected = 'selected="selected"';
            else
              $selected = '';
          }
            
          $label = $page -> post_title;
          echo '<option value="'.esc_attr( $page -> ID ).'" '.$selected.'>'.esc_html($label ).'</option>';
        }
          
        echo '</select>';
        break;
        
      case 'media' :
        
        if(function_exists('wp_enqueue_media'))
          wp_enqueue_media();
                
        echo '<input type="text" name="' . esc_attr( $field_id ). '" id="' . esc_attr( $field_id ). '" value="' . esc_attr( $value ). '" class="regular-text">';
        echo '<button class="button nm-media-upload">Select</button>';
        echo ' <a href="javascsript:;" class="remove-media"><i class="fa fa-pencil"></i>'.__('Remove', 'woo-mct').'</a>';
        
        //rendering image thumb
        if($value)
          echo '<br><span class="the-thumb"><img width="75" src="'.esc_url($value ).'"></span>';
        else
          echo '<br><span class="the-thumb"></span>';
        break;
        
      case 'file':
        $file = MCT_PATH .'/templates/admin/'.$data['id'];
        if(file_exists($file))
          include $file;
        else
          echo 'file not exists '.$file;
        break;
        
    }
  }

/*
* this function is get options 
*/
function mct_get_option($key){

    //HINT: $key should be under schore (_) prefix

    $full_key =  MCT_SHORT_NAME. $key;
    $plugin_settings = get_option ( MCT_SHORT_NAME . '_settings' );
    
    $the_option = (isset($plugin_settings[$full_key]) ? $plugin_settings[$full_key]: '');

    if (is_array($the_option))
      return $the_option;
    else
      return stripcslashes( $the_option );
}

/**
** getting products by category
** or all if category not provided
**/
function mct_get_products($cat_id=null){
    $args = array(
        'posts_per_page' => -1,        
        'post_type' => 'product',
        'orderby' => 'title,'
    );

    if( $cat_id != null ) {
      $args['tax_query'] = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                // 'terms' => 'white-wines'
                'terms' => $cat_id
            )
        );
    }

    $products = new WP_Query( $args );
    while ( $products->have_posts() ) {
        $products->the_post();
        $_product = wc_get_product( get_the_id() );
        $all_products[] = array(
              'name' => get_the_title(),
              'id' => get_the_id(),
              'thumbnail' => get_the_post_thumbnail( get_the_id(), 'medium' ),
              'excerpt' => get_the_excerpt(),
              'price' => $_product->get_price_html(),
              'sale_price' => ($_product->get_sale_price()) ? true : false ,
              );
    }

    wp_reset_query();
    return $all_products;
}

/**
  * this function will search woocommerce for current theme other use woocommerce plugin template file
  * */
function mct_get_single_product_template(){

    // first checking in theme
    $single_product_template = get_template_directory() . '/woocommerce/templates/content-single-product.php';

    if( file_exists($single_product_template) ){
      return $single_product_template;
    } else {
      // if not found in theme then return woocommerce plugin
      return WC()->plugin_path() . '/templates/content-single-product.php';
    }
}


function mct_redirect_link_product_page(){
    $product_id = get_transient('mct_product_id');
    delete_transient('mct_product_id');
    echo '<a href="'.get_permalink($product_id).'" class="single_add_to_cart_button button alt">'.__('Select options', 'woo-mct').'</a>';
}


function mct_render_quantity_input( $product ){
  
  ob_start();
  if ( $product->is_type( 'grouped' ) ) {

    woocommerce_quantity_input( array(
      'input_name'  => 'quantity[' . $grouped_product->get_id() . ']',
      'input_value' => isset( $_POST['quantity'][ $grouped_product->get_id() ] ) ? wc_stock_amount( $_POST['quantity'][ $grouped_product->get_id() ] ) : 0,
      'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product ),
      'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product ),
    ) );
  }else{

    woocommerce_quantity_input( array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
      ) );    
  }
  return ob_get_clean();
}

// Get add to cart URL
function mct_get_add_to_cart_url( $product ) {
  
  
  $cart_url = add_query_arg(array('add-to-cart'=>$product->get_id()), get_transient('mct_table_shop_page'));
  $cart_url = apply_filters('mct_add_to_cart_url', $cart_url, $product);
  
  
  $mct_addtocart_url = apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
		esc_url( $cart_url ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		esc_html( $product->add_to_cart_text() )
	), $product);
	
	return $mct_addtocart_url;
}

// Get Product rating
function mct_get_product_rating( $product ) {
  
    $rating_count = $product->get_rating_count();
    $review_count = $product->get_review_count();
    $average      = $product->get_average_rating();

    $rating_html = '';
    if ( $rating_count > 0 ) :

    $rating_html = '<div class="woocommerce-product-rating">';
    	$rating_html .= wc_get_rating_html( $average, $rating_count );
    	if ( comments_open() ) {
    	  $product_reviews_link = get_permalink($product->get_id()) . '#reviews';
    	  $rating_html .= '<a href="'.esc_url($product_reviews_link).'" class="mct-table-review" rel="nofollow">';
    	  $rating_html .= "(".sprintf( _n( '%s customer review', '%s customer reviews', $review_count, 'woo-mct' ), '<span class=\"count\">' . esc_html( $review_count ) . '</span>') .")";
    	  $rating_html .= '</a>';
    }
    $rating_html .= '</div>';
    endif;

    return $rating_html;
}

/*
** set layout of plugin
*/
function mct_get_layout( $products_view )  {

    if ( $products_view == 'grid_view' ) {
        
        /*
        ** enqeue script for grid view
        */
        wp_enqueue_script( 'mct-script' );
        
        // render grid template 
        $template = mct_load_templates('render-shop.php');

    } elseif ( $products_view == 'table_view' ) {
        
        /*
        ** enque script for table view
        */
        wp_enqueue_script( 'mct-tbale-script' );
        wp_enqueue_script( 'mct-data-tbale' );
        wp_enqueue_script( 'mct-bootstrap-data-tbale' );

        if (apply_filters('mct_version_check', 'standard') != 'standard') {
            wp_enqueue_script( 'mct-modal-js' );
            wp_enqueue_script( 'mct-tooltip-js' );
            wp_enqueue_style( 'mct-izi-modal' );
        }
        wp_enqueue_style( 'mct-bootstrap-table-styles' );
        wp_enqueue_style( 'mct-tooltip' );

        
        // render table template
        $template = mct_load_templates('product-table.php'); 
    }

    return $template;
}

/*
** get columns for table view
*/
function mct_get_columns() {
    $mct_version = apply_filters('mct_version_check', 'standard');
    // var_dump($mct_version);
    if ( $mct_version == 'standard' ) {

        $mct_product_thumb       = (mct_get_option('_product_thumb') != '') ? mct_get_option('_product_thumb') : '' ;
        $mct_product_name        = (mct_get_option('_product_name') != '') ? mct_get_option('_product_name') : '' ;
        $mct_product_price       = (mct_get_option('_product_price') != '') ? mct_get_option('_product_price') : '' ;

        if( $mct_product_thumb == 'yes' ) {
            $mct_columns[] = 'thumbnail';
        }
        if ( $mct_product_name == 'yes' ) {
            $mct_columns[] = 'name';
        }
        if( $mct_product_price == 'yes' ) {
            $mct_columns[] = 'price';
        }
        $mct_columns[] = 'add_to_cart';

    } elseif( $mct_version == 'pro' ) {

        /*
        ** Product Table
        */
        $mct_product_id          = (mct_get_option('_product_id') != '') ? mct_get_option('_product_id') : '' ;
        $mct_product_thumb       = (mct_get_option('_product_thumb') != '') ? mct_get_option('_product_thumb') : '' ;
        $mct_product_name        = (mct_get_option('_product_name') != '') ? mct_get_option('_product_name') : '' ;
        $mct_product_detail      = (mct_get_option('_product_detail') != '') ? mct_get_option('_product_detail') : '' ;
        $mct_product_categories  = (mct_get_option('_product_categories') != '') ? mct_get_option('_product_categories') : '' ;
        $mct_product_price       = (mct_get_option('_product_price') != '') ? mct_get_option('_product_price') : '' ;
        $mct_product_s_price     = (mct_get_option('_product_s_price') != '') ? mct_get_option('_product_s_price') : '' ;
        $mct_product_rating      = (mct_get_option('_product_rating') != '') ? mct_get_option('_product_rating') : '' ;
        
        if ( $mct_product_id == 'yes' ) {
            $mct_columns[] = 'id';
        }
        if( $mct_product_thumb == 'yes' ) {
            $mct_columns[] = 'thumbnail';
        }
        if ( $mct_product_name == 'yes' ) {
            $mct_columns[] = 'name';
        }
        if( $mct_product_detail == 'yes' ) {
            $mct_columns[] = 'excerpt';
        }
        if ( $mct_product_categories == 'yes' ) {
            $mct_columns[] = 'categories';
        }
        if( $mct_product_price == 'yes' ) {
            $mct_columns[] = 'price';
        }
        if( $mct_product_s_price == 'yes' ) {
            $mct_columns[] = 'sale_price';
        }
        if( $mct_product_rating == 'yes' ) {
            $mct_columns[] = 'product_rating';
        }
        $mct_columns[] = 'add_to_cart';
    }

    return $mct_columns;
}
/*
** localized variables for views
*/
function mct_localize_script( $products_view , $atts ) {

    $mct_product_categories = apply_filters( 'mct_get_categories_settings', $atts);
    $mct_cat_count = count($mct_product_categories);
    
    if ( $mct_cat_count > 0 && $mct_product_categories != "" && $mct_product_categories != null ){
        foreach ( $mct_product_categories as $product_category ) {
            $categories[] = array(
                            'name' => $product_category->name,
                            'desc' => $product_category->description,
                            'id' => $product_category->term_id,
                            'totalproducts' => $product_category->count,
                            'thumbnail' => wp_get_attachment_url(get_woocommerce_term_meta($product_category->term_id, 'thumbnail_id', true)),
                            'products' => mct_get_products($product_category->slug),
                        );
        }
    }

    if ( $products_view == 'grid_view' ) {
        // Woo Scripts
        $single_product_script = WC()->plugin_url() . '/assets/js/frontend/single-product.min.js';
        $single_vari_script = WC()->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js';
        $checkout_script = WC()->plugin_url() . '/assets/js/frontend/checkout.min.js';
        $pretty_photo = WC()->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init.min.js';

        /*
        ** localize script for grid view
        */
        wp_localize_script( 'mct-script', 'woostore', array(
                                            'cats' => $categories,
                                            'ajaxurl' => admin_url( 'admin-ajax.php' ),
                                            'tabscript' => $single_product_script,
                                            'variation' => $single_vari_script,
                                            'checkout' => $checkout_script,
                                            'update_shipping_method_nonce' => wp_create_nonce( "update-shipping-method" ),
                                            'pretty_photo' => $pretty_photo,
                                            )
        );

    } elseif ($products_view == 'table_view') {
        /*
        ** get settings for localized
        */
        $plugin_settings        =   get_option ( MCT_SHORT_NAME . '_settings' );
        
        /*
        ** localiz script for table view
        */
        wp_localize_script( 'mct-tbale-script', 'mct_vars_table', array(
                                            'version'=> apply_filters('mct_version_check', 'standard'),
                                            'category_dropdown'=> apply_filters('mct_category_dropdown', $mct_product_categories),
                                            'ajaxurl' => admin_url( 'admin-ajax.php' ),
                                            'plugin_settings' => $plugin_settings,
                                            'columns'          => mct_get_columns(),
                                            'messages'  => mct_array_messages(),
                                            )
        ); 
    }
}

if( ! function_exists('is_ppom_plugin_active') ) {
  function is_ppom_plugin_active() {
    
    $return = false;
    // first thing is first, checking if PPOM plugin is activated.
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active( 'nm-woocommerce-personalized-product/woocommerce-product-addon.php' ))
      $return = true;
      
    /**
     * Check free version of PPOM
     * @since 2.1
     **/
    if( is_plugin_active( 'woocommerce-product-addon/woocommerce-product-addon.php' ))
      $return = true;
      
    // var_dump($return);
    return $return;
  }
}