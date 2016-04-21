<?php
function headway_build_admin_input($type, $name_array, $id, $text_left = false, $text_right = false, $value = false, $no_border = false, $show_pixels = false, $tooltip = false){
	if($no_border) $no_border = ' class="no-border"';
	
	if($tooltip){
		$tooltip_class = ' class="tooltip"';
		$tooltip = ' title="'.$tooltip.'"';
	}	
	
	
	
	if($type == 'check' || $type == 'checkbox'){
		$checked = ($value == 'true' || $value == 'on') ? ' checked' : NULL;
		return '
			<tr'.$no_border.'>					
				<th scope="row"><label for="'.$id.'"'.$tooltip.$tooltip_class.'>'.$text_left.'</label></th>					
				<td class="clearfix">
					<p class="radio-container">
						<input type="hidden" name="'.$id.'" value="DELETE" />
						<input type="checkbox" name="'.$id.'" id="'.$id.'" value="on" class="radio"'.$checked.' /><label for="'.$id.'">'.$text_right.'</label>						
					</p>	
				</td>				
			</tr>
		';
	}
	
	
	elseif($type == 'radio'){
		$return = '
			<tr'.$no_border.'>					
				<th scope="row"><label for="'.$id.'"'.$tooltip.$tooltip_class.'>'.$text_left.'</label></th>					
				<td class="clearfix">';
		
		foreach($text_right as $item => $options){
			$checked = ($options['value'] == $value) ? ' checked="checked"' : NULL;
			$return .= '<p class="radio-container"><input type="radio" name="'.$id.'" id="'.$options['id'].'" value="'.$options['value'].'" class="radio"'.$checked.' /><label for="'.$options['id'].'">'.$item.'</label></p>';	
		}
				
		$return .= '</td>				
			</tr>
		';
		
		return $return;
	}
	
	
	elseif($type == 'text'){
		if($show_pixels) $show_pixels = '<small>px</small>';
		
		return '
			<tr'.$no_border.'>					
				<th scope="row"><label for="'.$id.'"'.$tooltip.$tooltip_class.'>'.$text_left.'</label></th>					
				<td><input type="text" name="'.$id.'" id="'.$id.'" value="'.htmlentities($value).'" />'.$show_pixels.'</td>				
			</tr>
		';
	}
	
	
}

function headway_build_checkbox($id, $reverse = false, $disabled = false){
?>
	<?php if(headway_get_option($id) == 1) $checked[$id] = ' checked="checked"'; ?>
	<?php if($reverse): ?>
		<input type="checkbox" value="1" id="<?php echo $id?>" name="<?php echo $id?>"<?php echo $checked[$id]?><?php echo $disabled?> />
		<input type="hidden" value="0" id="<?php echo $id?>-hidden" name="<?php echo $id?>_unchecked"<?php echo $disabled?> />
	<?php else: ?>
		<input type="hidden" value="0" id="<?php echo $id?>-hidden" name="<?php echo $id?>_unchecked"<?php echo $disabled?> />
		<input type="checkbox" value="1" id="<?php echo $id?>" name="<?php echo $id?>"<?php echo $checked[$id]?><?php echo $disabled?> />
	<?php endif; ?>
<?php
}