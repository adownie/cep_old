<?php
function create_visual_editor_widget($id, $title, $content){
	echo '<div id="'.$id.'-widget" class="collapsable collapsed">
		<h4 class="collapsable-header"><a href="#">'.$title.'</a></h4>

		<div class="collapsable-content">';
		
		call_user_func($content);
			
	echo '</div>
	</div>';
}

function create_visual_editor_widget_break(){
	echo '<div class="collapsable break"></div>';
}

function layout_chooser_slider_form_action(){
	if($_POST['switch-layout']){
		if($_POST['layout-page']){
			$sign = (strpos(get_permalink($_POST['layout-page']), '?')) ? '&' : '?';
			header('Location: '.get_permalink($_POST['layout-page']).'/'.$sign.'visual-editor=true');
		}
		elseif($_POST['layout-system-page']){
			if($_POST['layout-system-page'] == 'category') $system_page_link = get_category_link(1);
			if($_POST['layout-system-page'] == 'four04') $system_page_link = get_bloginfo('wpurl').'/'.rand(10000, 50000);
			if($_POST['layout-system-page'] == 'archives'){ 
				preg_match('/href=\'(.*)\'/', wp_get_archives( array('type' => 'monthly', 'limit' => 1, 'format' => 'link', 'echo' => 0) ), $regs);
				$system_page_link =  $regs[1];
			}
			if($_POST['layout-system-page'] == 'single'){ 
				global $post;
				$single_loop = get_posts('showposts=1&post_type=post');
				foreach($single_loop as $post) $system_page_link = get_permalink(get_the_id());
			}
			if($_POST['layout-system-page'] == 'index'){ 
				if(get_option('show_on_front') == 'page'){
					$system_page_link = get_permalink(get_option('page_for_posts'));
				}
				else
				{
					$system_page_link = get_bloginfo('wpurl');
				}
			}
			if($_POST['layout-system-page'] == 'tag') { 
										
				$tags = get_tags(false);
				
				foreach($tags as $tag){
					$tag_id = $tag->term_id;
					break;
				}
						
				$system_page_link = get_tag_link($tag_id);
								
			}
			if($_POST['layout-system-page'] == 'author') $system_page_link = get_bloginfo('wpurl').'/?author=1';
			if($_POST['layout-system-page'] == 'search') $system_page_link = get_bloginfo('wpurl').'/?s=%20';			

			
			$sign = (strpos($system_page_link, '?')) ? '&' : '?';
			$sign = (strpos(get_option('permalink_structure'), '/') && !strpos($system_page_link, '?')) ? '?' : $sign;
			header('Location: '.$system_page_link.$sign.'visual-editor=true&visual-editor-system-page='.$_POST['layout-system-page']);
		}
	}
}

function headway_build_visual_editor_input($type, $name_array, $id, $text_left = false, $text_right = false, $value = false, $no_border = false, $show_pixels = false, $tooltip = false){
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
						<input type="hidden" class="headway-visual-editor-input" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" value="DELETE" />
						<input type="checkbox" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" id="'.$id.'" value="on" class="radio headway-visual-editor-input"'.$checked.headway_disabled_input($id).' /><label for="'.$id.'">'.$text_right.'</label>						
					</p>	
				</td>				
			</tr>
		';
	}
	
	
	elseif($type == 'check-alt' || $type == 'checkbox-alt'){
		$checked = ($value == 'true' || $value == 'on') ? ' checked' : NULL;
		return '
					<p class="radio-container">
						<input type="hidden" class="headway-visual-editor-input" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" value="DELETE" />
						<input type="checkbox" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" id="'.$id.'" value="on" class="headway-visual-editor-input radio"'.$checked.headway_disabled_input($id).' /><label for="'.$id.'">'.$text_right.'</label>						
					</p>	
		';
	}
	
	
	elseif($type == 'radio'){
		$return = '
			<tr'.$no_border.'>					
				<th scope="row"><label for="'.$id.'"'.$tooltip.$tooltip_class.'>'.$text_left.'</label></th>					
				<td class="clearfix">
				<input type="hidden" class="headway-visual-editor-input" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" value="'.$value.'" id="'.$id.'-hidden" />
				';
		
		foreach($text_right as $item => $options){
			$checked = ($options['value'] == $value) ? ' checked="checked"' : NULL;
			$return .= '<p class="radio-container"><input type="radio" id="'.$options['id'].'" name="'.$id.'" onclick="jQuery(\'#\' + jQuery(this).attr(\'name\') + \'-hidden\').val(jQuery(this).val());" value="'.$options['value'].'" class="radio"'.$checked.headway_disabled_input($id).' /><label for="'.$options['id'].'">'.$item.'</label></p>';	
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
				<td><input type="text" class="headway-visual-editor-input" name="headway-config'.headway_disabled_input_name($id).'['.$id.']" id="'.$id.'" value="'.htmlentities($value).'"'.headway_disabled_input($id).' />'.$show_pixels.'</td>				
			</tr>
		';
	}
	
	
}