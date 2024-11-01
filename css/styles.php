
.nm-button, .nm-breadcrumb, .nm-woostore .productprice, .nm-woostore #sliderBlock, .nm-btn-bar #search {
	background-color: <?php echo $mct_staticBgColor; ?> !important;
	color: <?php echo $mct_staticTextColor; ?> !important;
}
.nm-button:hover, .nm-btn-bar #search:hover {
	background-color: <?php echo $mct_hoverBgColor; ?> !important;
	color: <?php echo $mct_hoverTextColor; ?> !important;
}
input::-webkit-input-placeholder {
   color: white;
}

input:-moz-placeholder { /* Firefox 18- */
   color: white;  
}

input::-moz-placeholder {  /* Firefox 19+ */
   color: white;  
}

input:-ms-input-placeholder {  
   color: white;
}

.products-contents {
    <!-- border: 1px solid #e3e3e3 !important;
    padding: 10px;
    margin-top: 10px;  -->
}
.single_product img{
    /*float: left;*/
}
<!-- datatable styles  -->

.cat-area > .form-inline{
    margin: 2px 10px 0 0 !important;
}
#select-cat-area {
    <!-- display: none; -->
}
.cat-area > .form-inline{
    margin: 2px 10px 0 0 !important;
}
.table-top, .cat-area {
    font-size: 15px;
}
.table-top input, .table-top select {
    height: 34px;
    border-radius: 4px;
    border: 1px solid #e3e3e3;
}
.table-top label,.cat-area label  {
    font-weight: 100;
}
#mct-wrapper #mct-product-table tbody tr img {
    width: 70px !important;
    height: 70px !important;
}
.mct-product-table .col-add-to-cart {
    text-align: right;
}
.mct-product-table .cart {
    border: none!important;
    padding: 0!important;
    margin: 0!important;
}
.mct-product-table .multi-cart .multi-cart-check {
    position: absolute;
    top: .25em;
    right: 0;
}
.mct-product-table td>:last-child {
    margin-bottom: 0!important;
}
.mct-product-table .multi-cart {
    position: relative;
    padding-right: 34px;
    min-height: 28px;
}
.col-add-to-cart .cart .mct-simple-add-to-cart {
    margin-left: 3px;
    /*position: absolute;*/
}

.mct-product-table .cart .single_add_to_cart_button {
    margin-top: 3px!important;
    margin-bottom: 3px!important;
}
.mct-product-table-wrapper .screen-reader-text {
    clip: rect(1px,1px,1px,1px);
    height: 1px;
    overflow: hidden;
    position: absolute!important;
    width: 1px;
    word-wrap: normal!important;
}
.mct-product-table .cart .quantity .qty {
    max-height: 100%;
    min-height: 0;
    text-align: center;
}
.mct-product-table .cart .quantity, .mct-product-table .cart .single_add_to_cart_button, .mct-product-table .cart .variations select, .mct-product-table .product-details-button, .mct-product-table a[data-product_id] {
    margin: 0!important;
    box-sizing: border-box!important;
    min-height: 0!important;
    height: 2em!important;
    line-height: 1.9!important;
    padding-top: 0!important;
    padding-bottom: 0!important;
    font-size: inherit!important;
    vertical-align: top;
    white-space: nowrap;
    display: inline-block!important;
    float: none!important;
    min-width: 0;
}
.mct-product-table .cart .quantity {
    margin: 3px 0!important;
    opacity: 1;
    position: relative;
    width: auto!important;
}
.mct-product-table .cart .quantity .qty {
    box-sizing: border-box;
    padding: 4px 3px!important;
    margin: 0;
    line-height: normal;
    vertical-align: top!important;
    min-width: 3.2em;
    height: 100%;
}
.mct-product-table tr td .quantity {
    display: inline-block;
}
.mct-product-table tr td .quantity input {
    max-width: 4.2em;
    max-height: 28px;
    <!-- border: none; -->
}
.mct-product-table tr td a[rel=nofollow] {
    color: #fff;
    background: #000;
}
.select-category {
    float: left;
    margin: 0 15px 0 0;
    display: inline;
    width: auto;
}
.select-category select {
    display: inline;
    width: auto;   
}
#mct-product-table_filter {
    float: right;
}
#mct-product-table_length {
    float: left;
}
#mct-product-table_paginate {
    float: right;
}
#mct-product-table_info {
    float: left;
}