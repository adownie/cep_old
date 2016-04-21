<?php
function rotator_inner($leaf){
	if($leaf['new']){
		$leaf['options']['animation-type'] = 'fade';
		$leaf['options']['animation-speed'] = '1';
		$leaf['options']['animation-timeout'] = '7';

		$leaf['options']['disable-resizing'] = 'on';
	}
?>
	<ul class="clearfix tabs">
        <li><a href="#images-tab-<?php echo $leaf['id'] ?>">Images</a></li>
        <li><a href="#options-tab-<?php echo $leaf['id'] ?>">Options</a></li>
        <li><a href="#miscellaneous-tab-<?php echo $leaf['id'] ?>">Miscellaneous</a></li>
    </ul>

	<div id="images-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options " id="leaf-options-<?php echo $leaf['id'] ?>">

			<tr>
				<th scope="row" colspan="2" class="<?php echo $leaf['id'] ?>"><a href="#" id="<?php echo $leaf['id'] ?>_rotator_add_image" class="rotator-add-image">Add an image</a></th>
			</tr>
			
			<?php
			if($leaf['options']['images']){
				foreach($leaf['options']['images'] as $image){
					$id = array_search($image, $leaf['options']['images']);
				?>
			
					<tr id="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>" class="image-<?php echo $id ?>">
						<th scope="row"><label for="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>_url">Image <?php echo $id ?></label></th>
						<td>
							<label for="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>_url">Image URL</label><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][images][<?php echo $id ?>][path]" id="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>_url" value="<?php echo $image['path'] ?>" />
						
							<label for="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>_hyperlink">Image Hyperlink</label><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][images][<?php echo $id ?>][hyperlink]" id="<?php echo $leaf['id'] ?>_rotator_image_<?php echo $id ?>_hyperlink" value="<?php echo $image['hyperlink'] ?>" />
						</td>
						<td>
							<a href="" title="Delete This Image" class="rotator-delete-image"><img src="<?php echo get_bloginfo('template_directory') ?>/library/admin/icons/minus.png" /></a>
						</td>
					</tr>	
			
				<?php
				}
			}
			?>
		
		</table> 
	</div>
	
	<div id="options-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-options">
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_animation_type">Animation Type</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][animation-type]" id="<?php echo $leaf['id'] ?>_animation_type">
							<option value="fade"<?php echo headway_option_value($leaf['options']['animation-type'], 'fade') ?>>Fade</option>
							<option value="scrollUp"<?php echo headway_option_value($leaf['options']['animation-type'], 'scrollUp') ?>>Scroll Up</option>
							<option value="scrollRight"<?php echo headway_option_value($leaf['options']['animation-type'], 'scrollRight') ?>>Scroll Right</option>
							<option value="scrollDown"<?php echo headway_option_value($leaf['options']['animation-type'], 'scrollDown') ?>>Scroll Down</option>
							<option value="scrollLeft"<?php echo headway_option_value($leaf['options']['animation-type'], 'scrollLeft') ?>>Scroll Left</option>
					</select>
				</td>
			</tr>
			
			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_animation_speed">Animation Speed</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][animation-speed]" id="<?php echo $leaf['id'] ?>_animation_speed" value="<?php echo $leaf['options']['animation-speed'] ?>" /><small><code>Second(s)</code></small></td>	
			</tr>
			
			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_animation_timeout">Timeout (How long image sits)</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][animation-timeout]" id="<?php echo $leaf['id'] ?>_animation_timeout" value="<?php echo $leaf['options']['animation-timeout'] ?>" /><small><code>Second(s)</code></small></td>	
			</tr>
			
			
			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_disable_resizing">Resizing</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_disable_resizing" name="leaf-options[<?php echo $leaf['id'] ?>][disable-resizing]"<?php echo headway_checkbox_value($leaf['options']['disable-resizing']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_disable_resizing">Disable Image Resizing</label>
					</p>
				</td>	
			</tr>
			
			<tr>
				<td colspan="2"><p class="notice">Before enabling image resizing, all the images in the rotator must be hosted locally.</p></td>
			</tr>
			
			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_randomize_order">Image Order</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_random_order" name="leaf-options[<?php echo $leaf['id'] ?>][randomize-order]"<?php echo headway_checkbox_value($leaf['options']['randomize-order']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_randomize_order">Randomize Order</label>
					</p>
				</td>	
			</tr>
		</table>
	</div>
	
	<div id="miscellaneous-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-miscellaneous">
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_show_title">Leaf Title</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_show_title" name="config[<?php echo $leaf['id'] ?>][show-title]"<?php echo headway_checkbox_value($leaf['config']['show-title']) ?>/><label for="<?php echo $leaf['id'] ?>_show_title">Show Title</label>
					</p>
				</td>	
			</tr>

			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_leaf_title_link">Leaf Title Link</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][leaf-title-link]" id="<?php echo $leaf['id'] ?>_leaf_title_link" value="<?php echo $leaf['config']['title-link'] ?>" /></td>	
			</tr>

			<tr class="no-border">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_custom_css_classes">Custom CSS Class(es)</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][custom-css-classes]" id="<?php echo $leaf['id'] ?>_custom_css_classes" value="<?php echo $leaf['config']['custom-classes'] ?>" /></td>	
			</tr>
		</table>
	</div>
<?php
}

function rotator_content($leaf){
?>
	<div class="rotator-images">
			<?php
				if($leaf['options']['images']){
					foreach($leaf['options']['images'] as $image){
						if($image['path']){
							$width = intval($leaf['config']['width']); 
							$height = ($leaf['config']['show-title']) ? intval($leaf['config']['height'])-20 : intval($leaf['config']['height']);

							if($image['hyperlink']) echo '<a href="'.$image['hyperlink'].'">';
							if($image['path'] && !$leaf['options']['disable-resizing']) echo '<img src="'.get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.urlencode($image['path']).'&amp;w='.$width.'&amp;h='.$height.'&amp;zc=1" alt="" />';
							if($image['path'] && $leaf['options']['disable-resizing']) echo '<img src="'.$image['path'].'" alt="" />';
							if($image['hyperlink']) echo '</a>';
						}
					}
				}
			?>
	</div>
<?php
}
$options = array(
		'id' => 'rotator',
		'name' => 'Image Rotator',
		'options_callback' => 'rotator_inner',
		'content_callback' => 'rotator_content',
		'icon' => get_bloginfo('template_directory').'/library/leafs/icons/image_rotator.png'
	);

$rotator_leaf = new HeadwayLeaf($options);