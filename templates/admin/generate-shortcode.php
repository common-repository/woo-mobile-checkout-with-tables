<tr>
	<th><?php _e( 'Include or Exclude', 'woo-mct' ); ?></th>
	<td>
		<select class="the_chosen shortcode_select">
			<option value="include"><?php _e( 'Include Following', 'woo-mct' ); ?></option>
			<option value="exclude"><?php _e( 'Exclude Following', 'woo-mct' ); ?></option>
		</select>
	</td>
	<td><?php _e( 'Include or Exclude following categories from shop grid view.', 'woo-mct' ); ?></td>
</tr>
<tr>
	<th><?php _e( 'Categories', 'woo-mct' ); ?></th>
	<td>
		<?php $product_categories = get_terms( 'product_cat');
		?>
		<select class="widefat shortcode_ids" multiple="">
			<?php foreach ($product_categories as $cat) {
				echo '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
			} ?>
		</select>
	</td>
	<td><?php _e( 'Select Categories you want to exclude or include in grid view.', 'woo-mct' ); ?>.</td>
</tr>
<tr>
	<th><?php _e( 'Shortcode', 'woo-mct' ); ?></th>
	<td>
		<input type="text" style="color: green;text-align: center;" value="[wmct]" class="widefat shortcode_ready" disabled="disabled">
	</td>
	<td><?php _e( 'Copy and use this shortcode', 'woo-mct' ); ?>.</td>
</tr>
<script>
	jQuery(document).ready(function($) {
		jQuery('tr').on('change', '.shortcode_select', function(event) {
			event.preventDefault();
			var ids = jQuery('.shortcode_ids').val();
			var inex = jQuery(this).val();
			jQuery('.shortcode_ready').val('[wmct '+inex+'="'+ids+'"]');
		});
		jQuery('tr').on('change', '.shortcode_ids', function(event) {
			event.preventDefault();
			var ids = jQuery(this).val();
			var inex = jQuery('.shortcode_select').val();
			jQuery('.shortcode_ready').val('[wmct '+inex+'="'+ids+'"]');
		});
	});
</script>