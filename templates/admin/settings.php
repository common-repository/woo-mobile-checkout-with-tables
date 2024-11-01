<?php 
/*
 * this file rendering admin options for the plugin
* options are defined in admin/admin-options.php
*/

 // include_once( MCT_PATH . "/templates/admin/options.php");
/*
** mct_settings() get array of sattings from inc/arrays.php
*/
$mct_options = mct_settigns();
?>

<style>
	
	.nm-help{
		font-size: 11px;
	}
	.the-button{
		float: right;
		}
	.nm-saving-settings{
	float: left;
	margin-right: 5px;
	display: block;
	margin-top: 5px;
}
</style>

<h2>
	<?php printf(__("%s", 'woo-mct'), 'WooCommerce Mobile Checkout with Tables');
	
	?>
</h2>
<div id="nm_opw-tabs" class="wrap">
	<ul class='etabs'>
		<?php foreach( $mct_options as $id => $option){
			
			?>

		<li class='tab'><a href="#<?php echo $id?>"><?php echo $option['name']?>
		</a></li>

		<?php }?>
	</ul>

	<form id="nm-admin-form-<?php echo $id?>" class="nm-admin-form">
	<input type="hidden" name="action" value="<?php echo MCT_SHORT_NAME?>_save_settings" />
	
	<?php foreach($mct_options as $id => $options){
		
		// reseting the update data array
		
		?>

	<div id="<?php echo $id; ?>">
		
		<p>
			<?php echo $options['desc']?>
		</p>

		<?php if (isset($options['meat'])): ?>
		<table class="form-table">
				
		<?php foreach($options['meat'] as $key => $data){
			
				$mct_label 		 	= $data['label'];
				$mct_help 			= (isset($data['help']) ? $data['help'] : '');
				$mct_type 			= (isset($data['type']) ? $data['type'] : '');
				$mct_is_pro			= (isset($data['is_pro']) ? $data['is_pro'] : false);
				
				if($mct_type == 'file'){

					// echo '<tr>';
					$file = MCT_PATH .'/templates/admin/'.$data['id'];
					if(file_exists($file))
						include $file;
					else
						echo 'file not exists '.$file;
					
					// echo '</tr>';
				} else {
			?>
				<tr valign="top" class="<?php echo $key; ?>">
					<th scope="row" width="25%"><?php printf(__('%s', 'woo-mct'), $mct_label);?>
						
					</th>
					<td width="30%">
						<?php mct_render_settings_input($data); ?>
					</td>
					<td width="40%">
						<span class="nm-help"><?php echo $mct_help?></span>
						<?php if( $mct_is_pro )  { 
							echo "<span class='mct-get-pro'> It's a PRO Feature.</span>";
						} ?>
						
					</td>
				</tr>
			<?php
				}
			}
			?>
		
		</table>
		<?php endif ?>
	</div>
	
	<?php
	}	
	?>
	<p class="the-button"><button class="button button-primary"><?php _e('Save settings', 'woo-mct')?></button><span class="nm-saving-settings"></span></p>
	</form>
	
	
</div>
