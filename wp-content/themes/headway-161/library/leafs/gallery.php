<?php
function gallery_content($leaf){
?>
	<div class="thumbnails-<?php echo $leaf['options']['thumbnail-location'] ?>">

		<?php
		if($leaf['options']['thumbnail-location'] == 'left' || $leaf['options']['thumbnail-location'] == 'right'){
			$big_image_width = $leaf['config']['width']-(($leaf['options']['thumbnail-width']+12+10)*$leaf['options']['thumbnail-columns'])-12;
		} else {
			$big_image_width = $leaf['config']['width'];
		}

		$loader_height = $leaf['config']['height']-40;


		$thumbnail_container_width = ($leaf['options']['thumbnail-location'] == 'left' || $leaf['options']['thumbnail-location'] == 'right') ? ($leaf['options']['thumbnail-width']+12+10)*$leaf['options']['thumbnail-columns'] : $leaf['config']['width']-12;
		$thumbnail_container_height = $leaf['config']['height']-40;	
		?>

		<?php if($leaf['options']['thumbnail-location'] == 'left' || $leaf['options']['thumbnail-location'] == 'right' || $leaf['options']['thumbnail-location'] == 'bottom'){ ?>

			<div id="leaf-<?php echo $leaf['id'] ?>-gallery" class="content">
				<div id="leaf-<?php echo $leaf['id'] ?>-controls" class="controls"></div>
				<div id="leaf-<?php echo $leaf['id'] ?>-loading" class="loader" style="<?php echo 'width: '.$big_image_width.'px !important; height:'.$loader_height.'px !important;' ?>"></div>
				<div id="leaf-<?php echo $leaf['id'] ?>-slideshow" class="slideshow"></div>
				<?php if($leaf['options']['show-titles'] || $leaf['options']['show-captions']): ?>
				<div id="leaf-<?php echo $leaf['id'] ?>-caption"></div>
				<?php endif; ?>
			</div>

		<?php } ?>


		<div id="leaf-<?php echo $leaf['id'] ?>-thumbs" class="navigation" style="width:<?php echo $thumbnail_container_width ?>px">
			<ul class="thumbs noscript" style="width:<?php echo $thumbnail_container_width ?>px">
				<?php
				$photos = headway_taxonomies(array('parent' => $leaf['options']['gallery']));


				if($photos){
					foreach($photos as $photo){
						$photo['content'] = array_map('stripslashes', unserialize($photo['content']));
						$photo = $photo['content'];
				?>
					    <li>
							<?php if(!$leaf['options']['no-resize']){ ?>

								<a class="thumb" href="<?php echo headway_thumbnail(headway_gallery_dir().$photo['filename'], $big_image_width, $leaf['config']['height']-40, $leaf['options']['crop-images']) ?>" title="<?php echo $photo['title'] ?>">

							<?php } else { ?>

								<a class="thumb" href="<?php echo get_bloginfo('wpurl') ?>/wp-content/uploads/headway/gallery/<?php echo $photo['filename'] ?>" title="<?php echo $photo['title'] ?>">

							<?php } ?>
					            <img src="<?php echo headway_thumbnail(headway_gallery_dir().$photo['filename'], $leaf['options']['thumbnail-width'], $leaf['options']['thumbnail-height']) ?>" alt="<?php echo $photo['caption'] ?>" />
					        </a>
							<?php if(($leaf['options']['show-titles'] || $leaf['options']['show-captions']) && ($photo['title'] || $photo['caption'])): ?>
					        	<div class="caption">
					            	<?php if($leaf['options']['show-titles'] && $photo['title']) echo '<h4>'.$photo['title'].'</h4>'; ?>
					            	<?php if($leaf['options']['show-captions'] && $photo['caption']) echo '<p>'.$photo['caption'].'</p>'; ?>
					        	</div>
							<?php endif; ?>
					    </li>
				<?php
					}
				}
				?>
			</ul>
		</div>


		<?php if($leaf['options']['thumbnail-location'] == 'top'){ ?>

			<div id="leaf-<?php echo $leaf['id'] ?>-gallery" class="content">
				<div id="leaf-<?php echo $leaf['id'] ?>-controls" class="controls"></div>
				<div id="leaf-<?php echo $leaf['id'] ?>-loading" class="loader" style="<?php echo 'width: '.$thumbnail_container_width.'px; height:'.$thumbnail_container_height.'px;"' ?>"></div>
				<div id="leaf-<?php echo $leaf['id'] ?>-slideshow" class="slideshow"></div>
				<?php if($leaf['options']['show-titles'] || $leaf['options']['show-captions']): ?>
				<div id="leaf-<?php echo $leaf['id'] ?>-caption"></div>
				<?php endif; ?>
			</div>

		<?php } ?>
		
	</div>
<?php
}

function gallery_inner($leaf){
	if($leaf['new']){
		$leaf['options']['thumbnail-rows'] = '4';
		$leaf['options']['thumbnail-columns'] = '3';
		$leaf['options']['thumbnail-width'] = '75';
		$leaf['options']['thumbnail-height'] = '75';		
		$leaf['options']['crop-images'] = 'on';
		$leaf['options']['preload'] = '5';
		$leaf['options']['show-titles'] = 'on';
		$leaf['options']['show-captions'] = 'on';
		$leaf['options']['bottom-pager'] = 'on';
		$leaf['options']['image-navigation'] = 'on';
		$leaf['options']['pager-next-text'] = 'Next &raquo;';
		$leaf['options']['pager-previous-text'] = '&laquo; Previous';
		$leaf['options']['next-link-text'] = 'Next Photo &raquo;';
		$leaf['options']['previous-link-text'] = '&laquo; Previous Photo';
		$leaf['options']['play-link-text'] = 'Play Slideshow';
		$leaf['options']['pause-link-text'] = 'Pause Slideshow';
		$leaf['options']['timeout'] = '4';
	}
	

	if(!$leaf['options']['bottom-pager']){
		$display['bottom-pager'] = 'display: none;';
	}
	
	if(!$leaf['options']['image-navigation']){
		$display['image-navigation'] = 'display: none;';
	}
	
	if(!$leaf['options']['slideshow-controls']){
		$display['slideshow-controls'] = 'display: none;';
	}
?>
	<ul class="clearfix tabs">
        <li><a href="#gallery-tab-<?php echo $leaf['id'] ?>">Gallery Options</a></li>
        <li><a href="#features-tab-<?php echo $leaf['id'] ?>">Features</a></li>
        <li><a href="#slideshow-tab-<?php echo $leaf['id'] ?>">Slideshow</a></li>
        <li><a href="#miscellaneous-tab-<?php echo $leaf['id'] ?>">Miscellaneous</a></li>
    </ul>



	<div id="gallery-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-gallery">
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_gallery">Gallery</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][gallery]" id="<?php echo $leaf['id'] ?>_gallery">
						<?php
						$galleries = headway_taxonomies(array('type' => 'gallery'));
						if(count($galleries) > 0){
							foreach($galleries as $options){
								$options = array_map('maybe_unserialize', $options);
								$selected[$options['id']] = ($leaf['options']['gallery'] == $options['id']) ? ' selected' : NULL;
								echo '<option value="'.$options['id'].'"'.$selected[$options['id']].'>'.$options['content']['name'].'</option>';
							}
						}
						else {
							echo '<option value="">No galleries exist.&nbsp;Create one!</option>';
						}
						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_thumbnail_rows">Thumbnail Rows</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][thumbnail-rows]" id="<?php echo $leaf['id'] ?>_thumbnail_rows">
							<option value="1"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '1') ?>>1</option>
							<option value="2"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '2') ?>>2</option>
							<option value="3"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '3') ?>>3</option>
							<option value="4"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '4') ?>>4</option>
							<option value="5"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '5') ?>>5</option>
							<option value="6"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '6') ?>>6</option>
							<option value="7"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '7') ?>>7</option>
							<option value="8"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '8') ?>>8</option>
							<option value="9"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '9') ?>>9</option>
							<option value="10"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '10') ?>>10</option>
							<option value="11"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '11') ?>>11</option>
							<option value="12"<?php echo headway_option_value($leaf['options']['thumbnail-rows'], '12') ?>>12</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_thumbnail_columns">Thumbnail Columns</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][thumbnail-columns]" id="<?php echo $leaf['id'] ?>_thumbnail_columns">
							<option value="1"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '1') ?>>1</option>
							<option value="2"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '2') ?>>2</option>
							<option value="3"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '3') ?>>3</option>
							<option value="4"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '4') ?>>4</option>
							<option value="5"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '5') ?>>5</option>
							<option value="6"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '6') ?>>6</option>
							<option value="7"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '7') ?>>7</option>
							<option value="8"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '8') ?>>8</option>
							<option value="9"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '9') ?>>9</option>
							<option value="10"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '10') ?>>10</option>
							<option value="11"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '11') ?>>11</option>
							<option value="12"<?php echo headway_option_value($leaf['options']['thumbnail-columns'], '12') ?>>12</option>
					</select>
				</td>
			</tr>
			
			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_thumbnail_width">Thumbnail Width</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][thumbnail-width]" id="<?php echo $leaf['id'] ?>_thumbnail_width" value="<?php echo $leaf['options']['thumbnail-width'] ?>" /><small><code>px</code></small></td>	
			</tr>
			
			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_thumbnail_height">Thumbnail Height</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][thumbnail-height]" id="<?php echo $leaf['id'] ?>_thumbnail_height" value="<?php echo $leaf['options']['thumbnail-height'] ?>" /><small><code>px</code></small></td>	
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_thumbnail_location">Thumbnail Container Location</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][thumbnail-location]" id="<?php echo $leaf['id'] ?>_thumbnail_location">
							<option value="left"<?php echo headway_option_value($leaf['options']['thumbnail-location'], 'left') ?>>Left</option>
							<option value="top"<?php echo headway_option_value($leaf['options']['thumbnail-location'], 'top') ?>>Top</option>
							<option value="right"<?php echo headway_option_value($leaf['options']['thumbnail-location'], 'right') ?>>Right</option>
							<option value="bottom"<?php echo headway_option_value($leaf['options']['thumbnail-location'], 'bottom') ?>>Bottom</option>
					</select>
				</td>
			</tr>
			
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_crop_images">Crop Images</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_crop_images" name="leaf-options[<?php echo $leaf['id'] ?>][crop-images]"<?php echo headway_checkbox_value($leaf['options']['crop-images']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_crop_images">Crop images to fill image container.</label>
					</p>
				</td>	
			</tr>
			
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_no_resize">Image Resizing</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_no_resize" name="leaf-options[<?php echo $leaf['id'] ?>][no-resize]"<?php echo headway_checkbox_value($leaf['options']['no-resize']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_no_resize">Do Not Resize Images</label>
					</p>
				</td>	
			</tr>
			
			
			<tr class="no-border">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_preload">Image Preloading (How many?  Bigger is not always better.)</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][preload]" id="<?php echo $leaf['id'] ?>_preload">
							<option value="1"<?php echo headway_option_value($leaf['options']['preload'], '1') ?>>1</option>
							<option value="2"<?php echo headway_option_value($leaf['options']['preload'], '2') ?>>2</option>
							<option value="3"<?php echo headway_option_value($leaf['options']['preload'], '3') ?>>3</option>
							<option value="4"<?php echo headway_option_value($leaf['options']['preload'], '4') ?>>4</option>
							<option value="5"<?php echo headway_option_value($leaf['options']['preload'], '5') ?>>5</option>
							<option value="6"<?php echo headway_option_value($leaf['options']['preload'], '6') ?>>6</option>
							<option value="7"<?php echo headway_option_value($leaf['options']['preload'], '7') ?>>7</option>
							<option value="8"<?php echo headway_option_value($leaf['options']['preload'], '8') ?>>8</option>
							<option value="9"<?php echo headway_option_value($leaf['options']['preload'], '9') ?>>9</option>
							<option value="10"<?php echo headway_option_value($leaf['options']['preload'], '10') ?>>10</option>
					</select>
				</td>
			</tr>
		
			
		</table>
	</div>
			
	
	
	<div id="features-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-features">
			
			
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_show_captions">Image/Photo Titles</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_show_titles" name="leaf-options[<?php echo $leaf['id'] ?>][show-titles]"<?php echo headway_checkbox_value($leaf['options']['show-titles']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_show_titles">Show Titles</label>
					</p>
				</td>	
			</tr>

			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_show_captions">Captions</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_show_captions" name="leaf-options[<?php echo $leaf['id'] ?>][show-captions]"<?php echo headway_checkbox_value($leaf['options']['show-captions']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_show_captions">Show Captions</label>
					</p>
				</td>	
			</tr>
			

			
			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_top_pager">Thumbnails Top Pager</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_top_pager" name="leaf-options[<?php echo $leaf['id'] ?>][top-pager]"<?php echo headway_checkbox_value($leaf['options']['top-pager']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_top_pager">Show Top Pager</label>
					</p>
				</td>	
			</tr>
			

			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_bottom_pager">Thumbnails Bottom Pager</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_bottom_pager" name="leaf-options[<?php echo $leaf['id'] ?>][bottom-pager]" onclick="bottom_pager_inputs_<?php echo $leaf['id'] ?>.toggle();"<?php echo headway_checkbox_value($leaf['options']['bottom-pager']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_bottom_pager">Show Bottom Pager</label>
					</p>
				</td>	
			</tr>
			
			
			<tr class="no-border">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_pager_next_text">Pager Next Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][pager-next-text]" id="<?php echo $leaf['id'] ?>_pager_next_text" value="<?php echo $leaf['options']['pager-next-text'] ?>" /></td>	
			</tr>
			
			<tr class="no-border">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_pager_previous_text">Pager Previous Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][pager-previous-text]" id="<?php echo $leaf['id'] ?>_pager_previous_text" value="<?php echo $leaf['options']['pager-previous-text'] ?>" /></td>	
			</tr>
			
			
			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_disable_opacity_fade">Opacity Fade</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_disable_opacity_fade" name="leaf-options[<?php echo $leaf['id'] ?>][disable-opacity-fade]"<?php echo headway_checkbox_value($leaf['options']['disable-opacity-fade']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_disable_opacity_fade">Disable Opacity Fade</label>
					</p>
				</td>	
			</tr>
			
			
		</table>
	</div>


	<div id="slideshow-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-slideshow">
			
			<script type="text/javascript">
				var image_navigation_inputs_<?php echo $leaf['id'] ?> = jQuery('.<?php echo $leaf['id'] ?>-image-navigation-inputs');
			</script>
			
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_image_navigation">Image Navigation</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_image_navigation" name="leaf-options[<?php echo $leaf['id'] ?>][image-navigation]" onclick="image_navigation_inputs_<?php echo $leaf['id'] ?>.toggle();"<?php echo headway_checkbox_value($leaf['options']['image-navigation']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_image_navigation">Show Image Next/Previous Links</label>
					</p>
				</td>	
			</tr>
			
			
			<tr class="no-border <?php echo $leaf['id'] ?>-image-navigation-inputs" style="<?php echo $display['image-navigation'] ?>">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_next_link_text">Next Link Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][next-link-text]" id="<?php echo $leaf['id'] ?>_next_link_text" value="<?php echo $leaf['options']['next-link-text'] ?>" /></td>	
			</tr>
			
			<tr class="<?php echo $leaf['id'] ?>-image-navigation-inputs" style="<?php echo $display['image-navigation'] ?>">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_previous_link_text">Previous Link Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][previous-link-text]" id="<?php echo $leaf['id'] ?>_previous_link_text" value="<?php echo $leaf['options']['previous-link-text'] ?>" /></td>	
			</tr>
			
			<script type="text/javascript">
				var slideshow_controls_inputs_<?php echo $leaf['id'] ?> = jQuery('.<?php echo $leaf['id'] ?>-slideshow-controls-inputs');
			</script>
			
			<tr>	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_slideshow_controls">Slideshow Controls</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_slideshow_controls" name="leaf-options[<?php echo $leaf['id'] ?>][slideshow-controls]" onclick="slideshow_controls_inputs_<?php echo $leaf['id'] ?>.toggle();"<?php echo headway_checkbox_value($leaf['options']['slideshow-controls']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_slideshow_controls">Show Play/Pause Controls</label>
					</p>
				</td>	
			</tr>
		
		
			<tr class="no-border <?php echo $leaf['id'] ?>-slideshow-controls-inputs" style="<?php echo $display['slideshow-controls'] ?>">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_play_link_text">Play Link Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][play-link-text]" id="<?php echo $leaf['id'] ?>_play_link_text" value="<?php echo $leaf['options']['play-link-text'] ?>" /></td>	
			</tr>
			
			<tr class="<?php echo $leaf['id'] ?>-slideshow-controls-inputs" style="<?php echo $display['slideshow-controls'] ?>">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_pause_link_text">Pause Link Text</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][pause-link-text]" id="<?php echo $leaf['id'] ?>_pause_link_text" value="<?php echo $leaf['options']['pause-link-text'] ?>" /></td>	
			</tr>
			

		
			<tr>					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_timeout">Timeout (How long between images)</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][timeout]" id="<?php echo $leaf['id'] ?>_timeout" value="<?php echo $leaf['options']['timeout'] ?>" /><small><code>Second(s)</code></small></td>	
			</tr>
			
			
			<tr class="no-border">	
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_autostart">Autostart</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_autostart" name="leaf-options[<?php echo $leaf['id'] ?>][autostart]"<?php echo headway_checkbox_value($leaf['options']['autostart']) ?>/>
						<label for="<?php echo $leaf['id'] ?>_autostart">Autostart Slideshow</label>
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
				<td><input type="text" class"headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][leaf-title-link]" id="<?php echo $leaf['id'] ?>_leaf_title_link" value="<?php echo $leaf['config']['title-link'] ?>" /></td>	
			</tr>

			<tr class="no-border">					
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_custom_css_classes">Custom CSS Class(es)</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][custom-css-classes]" id="<?php echo $leaf['id'] ?>_custom_css_classes" value="<?php echo $leaf['config']['custom-classes'] ?>" /></td>	
			</tr>
		</table>
	</div>
<?php
}
$options = array(
		'id' => 'gallery',
		'name' => 'Photo Gallery',
		'options_callback' => 'gallery_inner',
		'content_callback' => 'gallery_content',
		'icon' => get_bloginfo('template_directory').'/library/leafs/icons/gallery.png'
	);

$gallery_leaf = new HeadwayLeaf($options);