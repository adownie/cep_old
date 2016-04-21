<?php
function featured_leaf_inner($leaf){
	if($leaf['new']){
		$leaf['options']['mode'] = 'text';
		$leaf['options']['cutoff'] = 'excerpt';
		$leaf['options']['read-more-text'] = 'Read More &raquo;';
		$leaf['options']['rotate-limit'] = '3';
		$leaf['options']['animation-type'] = 'fade';
		$leaf['options']['animation-speed'] = '1';
		$leaf['options']['animation-timeout'] = '5';
		
		$leaf['config']['show-title'] = 'on';
	}
	
	if($categories_select): //Fixes select for multiple featured boxes.  Without this it will compound the categories.
		$categories_select = '';
		$categories = '';
		$select_selected = array();
	endif;
	
	$categories = $leaf['options']['categories'];
	$categories_select_query = get_categories();
	foreach($categories_select_query as $category){ 
		if(is_array($categories)){
			if(in_array($category->term_id, $categories)) $select_selected[$category->term_id] = ' selected';
		}

		$categories_select .= '<option value="'.$category->term_id.'"'.$select_selected[$category->term_id].'>'.$category->name.'</option>';

	}

	if($leaf['options']['mode'] != 'images'){
		$display['image-options'] = 'display:none;';
	}
?>
	<ul class="clearfix tabs">
        <li><a href="#options-tab-<?php echo $leaf['id'] ?>">Options</a></li>
        <li><a href="#post-display-tab-<?php echo $leaf['id'] ?>">Post Display</a></li>
        <li><a href="#rotation-tab-<?php echo $leaf['id'] ?>">Rotation</a></li>
        <li><a href="#miscellaneous-tab-<?php echo $leaf['id'] ?>">Miscellaneous</a></li>
    </ul>

	<div id="options-tab-<?php echo $leaf['id'] ?>">
			<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-options">
				<tr>
					<th scope="row"><label>Mode</label></th>
					<td>
							<script type="text/javascript">
								var image_options_<?php echo $leaf['id'] ?> = ".<?php echo $leaf['id'] ?>_image_options";
							</script>
							<p class="radio-container">
								<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][mode]" id="<?php echo $leaf['id'] ?>_mode_text" class="radio headway-visual-editor-input" value="text" onclick="jQuery(image_options_<?php echo $leaf['id'] ?>).hide();"<?php echo headway_radio_value($leaf['options']['mode'], 'text') ?> /><label for="<?php echo $leaf['id'] ?>_mode_recent" class="no-clear">Text Only</label>
							</p>

							<p class="radio-container">
								<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][mode]" id="<?php echo $leaf['id'] ?>_mode_images" class="radio headway-visual-editor-input" value="images" onclick="jQuery(image_options_<?php echo $leaf['id'] ?>).show();"<?php echo headway_radio_value($leaf['options']['mode'], 'images') ?> /><label for="<?php echo $leaf['id'] ?>_mode_feed" class="no-clear">Images</label>
							</p>
					</td>
				</tr>

				<tr style="<?php echo $display['image-options'] ?>" class="<?php echo $leaf['id'] ?>_image_options">
					<td colspan="2">
						<p class="info-box">Use <strong>leaf_<?php echo $leaf['id'] ?>_featured_image</strong> as a custom field on each featured to display an image in this leaf.</p>
					</td>
				</tr>
				
				<tr style="<?php echo $display['image-options'] ?>" class="<?php echo $leaf['id'] ?>_image_options">
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_image_width">Image Width</label></th>
					<td>
						<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][image-width]" id="<?php echo $leaf['id'] ?>_image_width" value="<?php echo $leaf['options']['image-width'] ?>" />
						<small>px</small>
					</td>
				</tr>
				
				<tr style="<?php echo $display['image-options'] ?>" class="<?php echo $leaf['id'] ?>_image_options">
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_image_height">Image Height</label></th>
					<td>
						<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][image-height]" id="<?php echo $leaf['id'] ?>_image_height" value="<?php echo $leaf['options']['image-height'] ?>" />
						<small>px</small>
					</td>
				</tr>
				
				<tr style="<?php echo $display['image-options'] ?>" class="<?php echo $leaf['id'] ?>_image_options">
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_image_location">Image Location</label></th>
					<td>
						<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][image-location]" id="<?php echo $leaf['id'] ?>_image_location">
							<option value="left"<?php echo headway_option_value($leaf['options']['image-location'], 'left') ?>>Left</option>
							<option value="right"<?php echo headway_option_value($leaf['options']['image-location'], 'right') ?>>Right</option>
						</select>
					</td>
				</tr>

				
				<tr class="no-border">
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_categories">Categories</label></th>
					<td>
						<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][categories][]" id="<?php echo $leaf['id'] ?>_categories" multiple size="5">
							<?php echo $categories_select; ?>
						</select>
					</td>
				</tr>
			</table>
	</div>
	
	<div id="post-display-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-post-display">
			
			<tr>
				<th scope="row"><label>Text Cutoff</label></th>
				<td>
						<p class="radio-container">
							<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][cutoff]" id="<?php echo $leaf['id'] ?>_cutoff_excerpt" class="radio headway-visual-editor-input" value="excerpt"<?php echo headway_radio_value($leaf['options']['cutoff'], 'excerpt') ?> /><label for="<?php echo $leaf['id'] ?>_cutoff_excerpt">Excerpt (Limits Characters)</label>
						</p>

						<p class="radio-container">
							<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][cutoff]" id="<?php echo $leaf['id'] ?>_cutoff_read_more" class="radio headway-visual-editor-input" value="read-more"<?php echo headway_radio_value($leaf['options']['cutoff'], 'read-more') ?> /><label for="<?php echo $leaf['id'] ?>_cutoff_read_more" class="no-clear">Depend on read more tag.</label>
						</p>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<p class="info-box">Customize the post meta by inserting the proper variables in the position desired below.</p>
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_read_more_text">Read More Text</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][read-more-text]" id="<?php echo $leaf['id'] ?>_read_more_text" value="<?php echo $leaf['options']['read-more-text'] ?>" />
				</td>
			</tr>
			
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_above_title_left">Above Title - Left</label></th>
				<td>
					<input type="text" clas="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-title-above-left]" id="<?php echo $leaf['id'] ?>_above_title_left" value="<?php echo $leaf['options']['featured-meta-title-above-left'] ?>" />
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_above_title_right">Above Title - Right</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-title-above-right]" id="<?php echo $leaf['id'] ?>_above_title_right" value="<?php echo $leaf['options']['featured-meta-title-above-right'] ?>" />
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_below_title_left">Below Title - Left</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-title-below-left]" id="<?php echo $leaf['id'] ?>_below_title_left" value="<?php echo $leaf['options']['featured-meta-title-below-left'] ?>" />
				</td>
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_below_title_right">Below Title - Right</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-title-below-right]" id="<?php echo $leaf['id'] ?>_below_title_right" value="<?php echo $leaf['options']['featured-meta-title-below-right'] ?>" />
				</td>
			</tr>
			
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_below_content_left">Below Content - Left</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-content-below-left]" id="<?php echo $leaf['id'] ?>_below_content_left" value="<?php echo $leaf['options']['featured-meta-content-below-left'] ?>" />
				</td>
			</tr>
			
			<tr class="no-border">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_below_content_right">Below Content - Right</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-meta-content-below-right]" id="<?php echo $leaf['id'] ?>_below_content_right" value="<?php echo $leaf['options']['featured-meta-content-below-left'] ?>" />
				</td>
			</tr>
			
			
			
		</table>
	</div>
	
	<div id="rotation-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-rotation">
			<tr>	
				<th scope="row"><label for="header-image-size">Post Rotation</label></th>	
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_rotate_posts" name="leaf-options[<?php echo $leaf['id'] ?>][rotate-posts]"<?php echo headway_checkbox_value($leaf['options']['rotate-posts']) ?> />
						<label for="<?php echo $leaf['id'] ?>_rotate_posts">Rotate Posts</label>
					</p>
				</td>	
			</tr>
			
			<tr>
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_rotate_limit">Limit to how many posts?</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][rotate-limit]" id="<?php echo $leaf['id'] ?>_rotate_limit" value="<?php echo $leaf['options']['rotate-limit'] ?>" />
				</td>
			</tr>
			
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
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_animation_timeout">Timeout (How long post sits)</label></th>
				<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][animation-timeout]" id="<?php echo $leaf['id'] ?>_animation_timeout" value="<?php echo $leaf['options']['animation-timeout'] ?>" /><small><code>Second(s)</code></small></td>	
			</tr>
			
			<tr class="no-border">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_next_prev_location">Next/Previous Location</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][next-prev-location]" id="<?php echo $leaf['id'] ?>_next_prev_location">
						<option value="none"<?php echo headway_option_value($leaf['options']['next-prev-location'], 'none') ?>>Do Not Show</option>
						<option value="inside"<?php echo headway_option_value($leaf['options']['next-prev-location'], 'inside') ?>>Inside Post</option>
						<option value="outside"<?php echo headway_option_value($leaf['options']['next-prev-location'], 'outside') ?>>Outside Container</option>
					</select>
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

function featured_leaf_content($leaf){
?>
	<div class="featured-leaf-content">
			<?php						
			if(!$leaf['options']['rotate-limit']):
				$rotate_limit = 1;
			else:
				$rotate_limit = ($leaf['options']['rotate-posts']) ? $leaf['options']['rotate-limit'] : 1;
			endif;


			if($leaf['options']['categories'] && $leaf['options']['categories'][0] != NULL){
				$featured_loop[$leaf['id']] = new WP_Query(array('category__in' => $leaf['options']['categories'], 'showposts' => $rotate_limit));
			} else {
				$featured_loop[$leaf['id']] = new WP_Query(array('showposts' => $rotate_limit));
			}

			global $more;
			$more = 0;
			?>
			<?php while ( $featured_loop[$leaf['id']]->have_posts() ) : $featured_loop[$leaf['id']]->the_post() ?>
				<div class="featured-post" id="featured-post-<?php the_id() ?>">
					<?php
					if(get_post_meta(get_the_id(), 'leaf_'.$leaf['id'].'_featured_image', true) && $leaf['options']['mode'] == 'images'){

						if($leaf['options']['image-width'] && $leaf['options']['image-height']){
							$image[get_the_id()] = '<div class="featured-image featured-image-'.$leaf['options']['image-location'].'" style="width:'.$leaf['options']['image-width'].'px"><img src="'.get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.urlencode(get_post_meta(get_the_id(), 'leaf_'.$leaf['id'].'_featured_image', true)).'&amp;w='.$leaf['options']['image-width'].'&amp;h='.$leaf['options']['image-height'].'&amp;zc=1" alt="'.get_the_title().'" /></div>';
						} else {
							$image[get_the_id()] = '<div class="featured-image featured-image-'.$leaf['options']['image-location'].'"><img src="'.get_post_meta(get_the_id(), 'leaf_'.$leaf['id'].'_featured_image', true).'" alt="'.get_the_title().'" /></div>';
						}

						

						if($leaf['options']['image-location'] == 'left') $post_left[get_the_id()] .= $image[get_the_id()];
						if($leaf['options']['image-location'] == 'right') $post_right[get_the_id()] .= $image[get_the_id()];
						


						$count++;

						$container_width = $leaf['config']['width']-$leaf['options']['image-width']-30;
						$container_width = ' style="width:'.$container_width.'px"';

					} else {
						$container_width = '';
					}
					?>

					<?php echo $post_left[get_the_id()]?>

				      <?php do_action('headway_above_post') ?>
					  <div class="featured-post-container"<?php echo $container_width?>>
						<?php headway_post_meta('title', 'above', true, $leaf['options']['featured-meta-title-above-left'], $leaf['options']['featured-meta-title-above-right']); ?>
						<h3 class="featured-entry-title entry-title"><a href="<?php the_permalink() ?>" title="<?php echo get_the_title();?>" rel="bookmark"><?php the_title() ?></a></h3>
						<?php headway_post_meta('title', 'below', true, $leaf['options']['featured-meta-title-below-left'], $leaf['options']['featured-meta-title-below-right']); ?>



						<div class="featured-entry-content">
							<?php
								if($leaf['options']['cutoff'] == 'read-more') the_content(false);
								if($leaf['options']['cutoff'] == 'excerpt') the_excerpt();
								echo '<a href="'.get_permalink().'" title="'.get_the_title().'" class="more-link featured-more-link">'.$leaf['options']['read-more-text'].'</a>';

							?>
						</div>

						<?php headway_post_meta('content', 'below', true, $leaf['options']['featured-meta-content-below-left'], $leaf['options']['featured-meta-content-below-right']); ?>
					  </div>



					<?php echo $post_right[get_the_id()]?>

					<?php if($leaf['options']['next-prev-location'] == 'inside' && $leaf['options']['rotate-posts']): ?>
						<a href="#" class="<?php echo $leaf['id'] ?>_featured_prev featured_prev featured_inside_prev">Previous</a>
						<a href="#" class="<?php echo $leaf['id'] ?>_featured_next featured_next featured_inside_next">Next</a>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php if($leaf['options']['next-prev-location'] == 'outside' && $leaf['options']['rotate-posts']): ?>
			<a href="#" id="<?php echo $leaf['id'] ?>_featured_prev" class="featured_prev featured_outside_prev">Previous</a>
			<a href="#" id="<?php echo $leaf['id'] ?>_featured_next" class="featured_next featured_outside_next">Next</a>
		<?php endif; ?>
<?php
}
$options = array(
		'id' => 'featured',
		'name' => 'Featured Posts',
		'options_callback' => 'featured_leaf_inner',
		'content_callback' => 'featured_leaf_content',
		'icon' => get_bloginfo('template_directory').'/library/leafs/icons/featured.png'
	);

$featured_leaf = new HeadwayLeaf($options);