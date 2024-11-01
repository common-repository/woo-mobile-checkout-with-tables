<?php
/**
** get all coulmns to show
**/
$mct_columns = mct_get_columns();

// Show WooCommerce notices
wc_print_notices();
?>

<div id="mct-wrapper">

    <?php do_action('mct_before_price_table');?>
    <!--Call your modal-->
       
    
	<table id="mct-product-table" class="table table-striped table-bordered mct-product-table " cellspacing="0" width="100%">
		<thead>
            <tr>
                <?php
                foreach ( $mct_columns as $key => $column ) {

                    if ( $column == 'id')
                    echo '<th class="col-name" data-name="name" data-data="name" data-orderable="true" data-searchable="true" data-width="20px" data-priority="1" tabindex="0" rowspan="1" colspan="1" style="width: 20px;" aria-label="ID: activate to sort column ascending">ID</th>';
                    if ( $column == 'thumbnail')
                    echo '<th class="col-image all sorting_disabled"  data-name="image" data-data="image" data-orderable="false" data-searchable="false" data-width="70px" data-priority="8" rowspan="1" colspan="110px" style="width: 70px;" aria-label="Image">Thumbnail</th>';
                    if ( $column == 'name')
                    echo '<th class="col-name" data-name="name" data-data="name" data-orderable="true" data-searchable="true" data-width="110px" data-priority="1" tabindex="0" rowspan="1" colspan="1" style="width: 110px;" aria-label="Name: activate to sort column ascending">Name</th>';
                    if ( $column == 'excerpt')
                    echo '<th class="col-short-description sorting_disabled" data-name="short-description" data-data="short-description" data-orderable="false" data-searchable="true" data-priority="11" tabindex="0" rowspan="1" colspan="1" style="width: 148px;" aria-label="Summary: activate to sort column ascending">Detail</th>';
                    if ( $column == 'categories')
                    echo '<th class="col-categories sorting" data-name="categories" data-data="categories" data-orderable="true" data-searchable="true" data-priority="9" tabindex="0" aria-controls="wcpt_7441511ad5edb56a1e0132fcba114f68" rowspan="1" colspan="1" style="width: 121px;" aria-label="Categories: activate to sort column ascending">Categories</th>';
                    if ( $column == 'price')
                    echo '<th class="col-price sorting" data-name="price" data-data="price" data-orderable="true" data-searchable="true" data-priority="2" tabindex="0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Price: activate to sort column ascending">Price</th>  ';
                    if ( $column == 'sale_price')
                    echo '<th class="col-price sorting" data-name="sale_price" data-data="sale_price" data-orderable="true" data-searchable="true" data-priority="2" tabindex="0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Price: activate to sort column ascending">Sale Price</th>';
                    if ( $column == 'product_rating')
                    echo '<th class="col-reviews sorting" data-name="reviews" data-data="reviews" data-orderable="true" data-searchable="true" data-priority="13" tabindex="0" rowspan="1" colspan="1" style="width: 69px;" aria-label="Reviews: activate to sort column ascending">Rating</th>';
                    if ( $column == 'add_to_cart')
                    echo '<th class="col-add-to-cart sorting_disabled" data-name="add-to-cart" data-data="add-to-cart" data-orderable="false" data-searchable="true" data-priority="3" rowspan="1" colspan="1" style="width: 218px;" aria-label="Buy">Add to cart</th>';
                }
                ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
            	<?php 
                foreach ( $mct_columns as $key => $column ) {

                    if ( $column == 'id')
                    echo '<th class="col-name" data-name="name" data-data="name" data-orderable="true" data-searchable="true" data-width="20px" data-priority="1" tabindex="0" rowspan="1" colspan="1" style="width: 20px;" aria-label="ID: activate to sort column ascending">ID</th>';
                    if ( $column == 'thumbnail')
                    echo '<th class="col-image all sorting_disabled"  data-name="image" data-data="image" data-orderable="false" data-searchable="false" data-width="70px" data-priority="8" rowspan="1" colspan="1" style="width: 70px;" aria-label="Image">Thumbnail</th>';
                    if ( $column == 'name')
                    echo '<th class="col-name" data-name="name" data-data="name" data-orderable="true" data-searchable="true" data-width="110px" data-priority="1" tabindex="0" rowspan="1" colspan="1" style="width: 110px;" aria-label="Name: activate to sort column ascending">Name</th>';
                    if ( $column == 'excerpt')
                    echo '<th class="col-short-description sorting_disabled" data-name="short-description" data-data="short-description" data-orderable="false" data-searchable="true" data-priority="11" tabindex="0" rowspan="1" colspan="1" style="width: 148px;" aria-label="Summary: activate to sort column ascending">Detail</th>';
                    if ( $column == 'categories')
                    echo '<th class="col-categories sorting" data-name="categories" data-data="categories" data-orderable="true" data-searchable="true" data-priority="9" tabindex="0" aria-controls="wcpt_7441511ad5edb56a1e0132fcba114f68" rowspan="1" colspan="1" style="width: 121px;" aria-label="Categories: activate to sort column ascending">Categories</th>';
                    if ( $column == 'price')
                    echo '<th class="col-price sorting" data-name="price" data-data="price" data-orderable="true" data-searchable="true" data-priority="2" tabindex="0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Price: activate to sort column ascending">Price</th>  ';
                    if ( $column == 'sale_price')
                    echo '<th class="col-price sorting" data-name="sale_price" data-data="sale_price" data-orderable="true" data-searchable="true" data-priority="2" tabindex="0" rowspan="1" colspan="1" style="width: 86px;" aria-label="Price: activate to sort column ascending">Sale Price</th>';
                    if ( $column == 'product_rating')
                    echo '<th class="col-reviews sorting" data-name="reviews" data-data="reviews" data-orderable="true" data-searchable="true" data-priority="13" tabindex="0" rowspan="1" colspan="1" style="width: 69px;" aria-label="Reviews: activate to sort column ascending">Rating</th>';
                    if ( $column == 'add_to_cart')
                    echo '<th class="col-add-to-cart sorting_disabled" data-name="add-to-cart" data-data="add-to-cart" data-orderable="false" data-searchable="true" data-priority="3" rowspan="1" colspan="1" style="width: 218px;" aria-label="Buy">Add to cart</th>';
                }
                ?>
            </tr>
        </tfoot>
	</table>
	
	<?php do_action('mct_after_price_table');?>
	</div>
