<?php
function text_content($leaf){
	$content = stripslashes(base64_decode($leaf['options']['text-content']));
	
	if($leaf['options']['dynamic-content'] && headway_get_write_box_value('dynamic-content')){
		echo headway_parse_php(stripslashes(headway_get_write_box_value('dynamic-content')));
	} else {
		echo headway_parse_php($content);
	}
}

function text_inner($leaf){
	if($leaf['new']){
		$leaf['config']['show-title'] = 'on';
	}
?>
	<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>">
		
		
		<tr class="textarea">
			<td colspan="2"><textarea class="text-content headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][text-content]" id="<?php echo $leaf['id'] ?>_text_content"><?php echo stripslashes(base64_decode($leaf['options']['text-content'])) ?></textarea></td>
		</tr>
		
		<tr>
			<td colspan="2"><p class="info-box">By enabling dynamic content you can add a text leaf to a single post and change what is in the box for each post.  This is useful if you want to put a YouTube video in the sidebar for a certain post.  The options are limitless.</p></td>
		</tr>
		
		<tr>	
			<th scope="row"><label for="<?php echo $leaf['id'] ?>[dynamic-content]">Dynamic Content</label></th>
			<td>
				<p class="radio-container">
					<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_dynamic_content" name="leaf-options[<?php echo $leaf['id'] ?>][dynamic-content]"<?php echo headway_checkbox_value($leaf['options']['dynamic-content']) ?>/>
					<label for="<?php echo $leaf['id'] ?>_dynamic_content">Enable Dynamic Content</label>
				</p>
			</td>	
		</tr>
		
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
<?php
}
$options = array(
		'id' => 'text',
		'name' => 'Text/HTML/PHP',
		'options_callback' => 'text_inner',
		'content_callback' => 'text_content',
		'icon' => get_bloginfo('template_directory').'/library/leafs/icons/default.png'
	);

$text_leaf = new HeadwayLeaf($options);