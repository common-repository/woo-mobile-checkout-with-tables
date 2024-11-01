var mct_product_table = '';
jQuery( document ).ready(function($) {
    
    if( $.blockUI ){
        
            var ajaxBlock = function() { $.blockUI( mct_get_ui_options(mct_vars_table.messages.loading_products) );
        };
        
        $(document).ajaxStart(ajaxBlock).ajaxStop($.unblockUI);
    }
    
    mct_fetch_table_products();

    jQuery("div.select-category").html(mct_vars_table.category_dropdown);
    $("#mct-product-table_wrapper").on("change", "#mct-table-categories", function(){

        // alert($(this).val());
        var ajax_url = mct_get_table_url() + '&catid='+$(this).val();
        mct_product_table.ajax.url( ajax_url ).load( function(){
            // it is work again when url load
            // because image tooltip and izi mopdel not work when ajax_url change
            $('.img-tooltip').tooltipster({
                side : 'top'
            });
            var modal = $(".mct_modal").iziModal({
                padding: 20,
                width: '600px',
                openFullscreen : true
            });
        } );
    });
});

function mct_fetch_table_products() {
    
    jQuery.blockUI(mct_get_ui_options(mct_vars_table.messages.loading_products));
    
    var columns = get_columns();
    var ajax_url = mct_get_table_url();
    
    mct_product_table = jQuery('#mct-product-table').DataTable({
    
        "ajax": ajax_url,
        "columns": columns,
        "autoWidth": false,
        "destroy": true,
        "initComplete": function(oSettings, json) {
            
            jQuery.unblockUI();
            /*
            ** check if mct_vars_table.version != standard
            ** then not use model and tooltip
            ** because their fiels not exists
            */
            if ( mct_vars_table.version != 'standard') {
    
                jQuery('.img-tooltip').tooltipster({
                    side : 'top'
                });
    
                var modal = jQuery(".mct_modal").iziModal({
                    padding: 20,
                    width: '600px',
                    openFullscreen : true
                });
                
                jQuery('.get-quick-view').on('click', function (event) {
                    event.preventDefault();
                    var mct_modal_id = jQuery(this).data('modal-id');
                    var mct_modal_title = jQuery(this).data('modal-title');
                    jQuery('#mct-image-'+mct_modal_id).iziModal('setTitle', mct_modal_title);
    
                    jQuery('#mct-image-'+mct_modal_id).on('opening', function (e) {
                        var ajax_url = mct_vars_table.ajaxurl;
                        var data = {
                            action : 'mct_quick_view',
                            product_id      : mct_modal_id
                        };
                        jQuery.post( ajax_url, data, function(resp) {
                            var content_area = jQuery('#mct-image-'+mct_modal_id).find('.iziModal-content');
                            content_area.html(resp);
                            jQuery('.woocommerce .images').css('opacity','1');
                        }).fail(function() {
    
                            alert( "error" );
                        });
                    });
                    jQuery('#mct-image-'+mct_modal_id).iziModal('open');
                });
            };
        },
        "dom": '<"select-category">flr<"clear">tip<"clear">',
        "language": {
            "lengthMenu": "Show _MENU_ Products",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing Page _PAGE_ of _PAGES_ Pages ",
            "infoEmpty": "No Products available",
            "infoFiltered": "(_MAX_ products in total))"
        },
    
    });
    
    
}


function mct_get_ui_options(message) {
    
    var ui_block = {
        message:  message,
                css: { 
                    border: 'none', 
                    padding: '15px',
                    backgroundColor: '#000', 
                    '-webkit-border-radius': '10px', 
                    '-moz-border-radius': '10px', 
                    opacity: .5, 
                    color: '#fff' 
                }
    }
    
    return ui_block;
}

function mct_get_table_url() {
    
    return mct_vars_table.ajaxurl+'?action=mct_get_all_products_table';
}

function get_columns() {

    var columns = [];
    jQuery.each( mct_vars_table.columns, function( key, value ) {
      
      columns.push({ "data": value });
    });

    return columns;
}