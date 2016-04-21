<?php
function navigation_item_options($id, $name = 'Navigation Item'){
	$nice_id = str_replace('page-item-', '', $id);
	
	$categories = get_post_meta($nice_id, '_headway_category_forward', true);
	$categories_select_query = get_categories();
	foreach($categories_select_query as $category){ 
		if($category->term_id == $categories) $select_selected[$category->term_id] = ' selected';

		$categories_select .= '<option value="'.$category->term_id.'"'.$select_selected[$category->term_id].'>'.$category->name.'</option>';
	}
?>
<h4 class="floaty-box-header"><span><?php echo $name ?></span></h4>
	<table class="navigation-options" id="navigation-item-options-<?php echo $id ?>">
		
		<tr>					
			<th scope="row"><label for="nav_item_<?php echo $id ?>_name">Navigation Item Text</label></th>
			<td><input type="text" class="headway-visual-editor-input" name="nav_item[<?php echo $id ?>][name]" id="nav_item_<?php echo $id ?>_name" value="<?php echo $name ?>" /></td>	
		</tr>


		<tr>
			<th scope="row"><label for="nav_item_<?php echo $id ?>_category">Link To Category</label></th>
			<td>
				<select name="nav_item[<?php echo $id ?>][category]" id="nav_item_<?php echo $id ?>_category" class="headway-visual-editor-input">
					<option value=""></option>
					<?php echo $categories_select ?>
				</select>
			</td>
		</tr>
		
		<tr class="no-border">					
			<th scope="row"><label for="nav_item_<?php echo $id ?>_forward_url"><strong>Or</strong> Redirect URL</label></th>
			<td><input type="text" class="headway-visual-editor-input" name="nav_item[<?php echo $id ?>][forward-url]" id="nav_item_<?php echo $id ?>_forward_url" value="<?php echo get_post_meta($nice_id, '_navigation_url', true) ?>" /></td>	
		</tr>
	
	</table> 
<?php } ?>