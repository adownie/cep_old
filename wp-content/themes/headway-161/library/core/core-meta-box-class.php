<?php
class HeadwayMetaBox
{
		
	var $id;
	var $name;
	var $options;
	var $defaults;
	var $info = NULL;
	var $type = 'both';


	function HeadwayMetaBox($id, $name, $options, $defaults, $info, $type){
		
		$this->id = $id;
		$this->name = $name;
	    $this->options = $options;
		$this->defaults = $defaults;
		if(isset($info)) $this->info = $info;
		if(isset($type)) $this->type = $type;
		
		
		add_action('admin_menu', array(&$this, 'BuildBox'));
		add_action('save_post', array(&$this, 'SaveData'), 10, 2);	
		add_action('publish_post', array(&$this, 'SaveData'), 10, 2);	
		
	}
	
	
	
	function BuildBox(){		
		if($this->type == 'post') add_meta_box( $this->id, $this->name, array($this, 'BoxContent'), 'post', 'advanced', 'low' );
		if($this->type == 'page') add_meta_box( $this->id, $this->name, array($this, 'BoxContent'), 'page', 'advanced', 'low' );
		
		if($this->type == 'both'):
			add_meta_box( $this->id, $this->name, array($this, 'BoxContent'), 'post', 'advanced', 'low' );
			add_meta_box( $this->id, $this->name, array($this, 'BoxContent'), 'page', 'advanced', 'low' );
		endif;	
	}
	
	
	
	
	function BoxContent(){
		
		
		global $post;
		
		
		
		echo '<input type="hidden" name="'.$this->id.'_nonce" id="'.$this->id.'_nonce" value="' . wp_create_nonce( base64_encode(md5($this->id)) ) . '" />';


		foreach($this->options as $option):
		
			if(get_post_meta($post->ID, '_'.$option['id'], true) || get_post_meta($post->ID, '_'.$option['id'], true) == '0'):
				$value = get_post_meta($post->ID, '_'.$option['id'], true);
			else:
				$value = $this->defaults[$option['id']];
			endif;
		
			
			
			
			if($value == '1') $data[$option['id']] = ' checked="checked" ';
			elseif($value != '1') $data[$option['id']] = $value;
		endforeach;


		if($this->info) echo '<p class="notice">'.$this->info.'</p>';
		
		
		foreach($this->options as $key => $value):
		
			$input_options['id'] = $value['id'];
			$input_options['name'] = $value['name'];
			$input_options['type'] = $value['type'];
			$input_options['defaults'] = $value['defaults'];
			$input_options['options'] = $value['options'];
			$input_options['description'] = $value['description'];

			
			$id = $input_options['id'];
						
				
			
				if($input_options['type'] == 'text'){

					$options .= '<tr class="label"><th valign="top" scope="row"><label for="'.$this->id.'_'.$input_options['id'].'">'.$input_options['name'].'</label></th></tr>
								 <tr><td><input type="text" style="width: 95%;" value="'.$data[$id].'" size="50" id="'.$this->id.'_'.$input_options['id'].'" name="'.$this->id.'['.$input_options['id'].']"/></td></tr>';
								
					if($input_options['description']){ $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>'; }

				} elseif($input_options['type'] == 'textarea') {
				
					$options .= '<tr class="label"><th valign="top" scope="row"><label for="'.$this->id.'_'.$input_options['id'].'">'.$input_options['name'].'</label></th></tr>
								<tr><td><textarea style="width: 95%;" rows="6" cols="50" id="'.$this->id.'_'.$input_options['id'].'" name="'.$this->id.'['.$input_options['id'].']">'.$data[$id].'</textarea></td></tr>';
								
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
				
				
				} elseif($input_options['type'] == 'checkbox') {
					$value = ($normal_data[$id] == 1) ? 1 : 0;
					
					$options .= '<input type="hidden" name="'.$this->id.'['.$input_options['id'].'_unchecked]" value="0" /> ';
					$options .= '<tr><td colspan="2"><label class="selectit" for="'.$this->id.'_'.$input_options['id'].'"> <input type="checkbox" id="'.$this->id.'_'.$input_options['id'].'" value="1" name="'.$this->id.'['.$input_options['id'].']" class="check" '.$data[$id].'/> '.$input_options['name'].'</label></td></tr>';
					
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
				
					
				} elseif($input_options['type'] == 'show_navigation') {
					
					if(in_array($post->ID, array_values((array)headway_get_option('excluded_pages')))){
						$data[$id] = 'hide';
					} else {
						$data[$id] = 'show';
					}

					$options .= '<tr><td colspan="2">
					
										<input type="radio" id="'.$this->id.'_'.$input_options['id'].'_show" value="show" name="'.$this->id.'['.$input_options['id'].']" class="check" '.headway_radio_value($data[$id], 'show').'/> 
											<label class="selectit" for="'.$this->id.'_'.$input_options['id'].'_show"> 
												Show In Navigation
											</label>
										
										<br />
										
										<input type="radio" id="'.$this->id.'_'.$input_options['id'].'_hide" value="hide" name="'.$this->id.'['.$input_options['id'].']" class="check" '.headway_radio_value($data[$id], 'hide').'/> 
											<label class="selectit" for="'.$this->id.'_'.$input_options['id'].'_hide"> 
												Hide From Navigation
											</label>
											
								</td></tr>';
								
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
					
								
				
				} elseif($input_options['type'] == 'radio') {


					$options .= '<tr><td colspan="2">';

					$count = 1;
					
					$possible_options = array_values($input_options['options']);
					
					foreach($input_options['options'] as $label => $value) {
						if($count == 1 && !(in_array($data[$id], $possible_options))) $checked[$count] = 'checked="checked" ';
						
						$options .= '<input type="radio" id="'.$this->id.'_'.$input_options['id'].'_'.$value.'" value="'.$value.'" name="'.$this->id.'['.$input_options['id'].']" class="check" '.headway_radio_value($data[$id], $value).$checked[$count].'/> 
							<label class="selectit" for="'.$this->id.'_'.$input_options['id'].'_'.$value.'"> 
								'.$label.'
							</label>

						<br />';
						
						$count++;
					}
								

					$options .= '			</td></tr>';
					
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
				

				
				
				} elseif($input_options['type'] == 'page-select') {
				
					
					$options .= '<tr class="label"><th valign="top" scope="row"><label for="'.$this->id.'_'.$input_options['id'].'">'.$input_options['name'].'</label></th></tr>
								 <tr><td>'.wp_dropdown_pages(array('selected' => $data[$id], 'name' => $this->id.'['.$input_options['id'].']', 'show_option_none' => '   ', 'sort_column'=> 'menu_order, post_title', 'echo' => false)).'</td></tr>';
								
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
					
				
				
				} elseif($input_options['type'] == 'system-page-select') {
				
					$current_system_page_link[$data[$id]] = ' selected';
					
					$options .= '<tr class="label"><th valign="top" scope="row"><label for="'.$this->id.'_'.$input_options['id'].'">'.$input_options['name'].'</label></th></tr>
								 <tr><td>
									<select name="'.$this->id.'['.$input_options['id'].']" id="'.$this->id.'_'.$input_options['id'].'"">
										<option value="DELETE"></option>
										<option value="index"'.$current_system_page_link['index'].'>Blog Index</option>
										<option value="single"'.$current_system_page_link['single'].'>Single Post</option>
										<option value="category"'.$current_system_page_link['category'].'>Category Archive</option>
										<option value="archives"'.$current_system_page_link['archives'].'>Archives</option>
										<option value="tag"'.$current_system_page_link['tag'].'>Tag Archive</option>
										<option value="author"'.$current_system_page_link['author'].'>Author Archive</option>
										<option value="search"'.$current_system_page_link['search'].'>Search</option>
										<option value="four04"'.$current_system_page_link['four04'].'>404 Page</option>
									</select>
								</td></tr>';
								
					if($input_options['description']) $options .= '<tr class="description"><td><p>'.$input_options['description'].'</p></td></tr>';
				
				 
				
				}
			
			
						

		endforeach;
		

		  echo '<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
			<tbody>
			'.$options.'
		  </tbody></table>';
		
		
	}
	
	
	
	function SaveData( $post_ID, $post ){
		if ($post->post_type == 'revision') return;
			
			
		$post_ID = $post->ID;
		
		
		$encrypt = base64_encode(md5($this->id));
		if ( !wp_verify_nonce( $_POST[$this->id.'_nonce'], $encrypt )) {
		  return;
		}
		
		
		

		if ( 'page' == $_POST['post_type'] ) {
		  if ( !current_user_can( 'edit_page', $post_ID ))
		    return $post_ID;
		} else {
		  if ( !current_user_can( 'edit_post', $post_ID ))
		    return $post_ID;
		}

		
		foreach($_POST[$this->id] as $key => $value):		
		
			if($value == '' || $value == '0'){
				
				if(strpos($key, '_unchecked')){
					$key = str_replace('_unchecked', '', $key);
					if(!$_POST[$this->id][$key]) update_post_meta($post_ID, '_'.$key, '0');

				}else{
					delete_post_meta($post_ID, '_'.$key);
				}


			}elseif($value != get_post_meta($post_ID, '_'.$key, true)){
				
				update_post_meta($post_ID, '_'.$key, $value); 
				
				if($key == 'show_navigation'){
							
					if($value == 'show'){
						
						$excluded_pages = (is_array(headway_get_option('excluded_pages'))) ? headway_get_option('excluded_pages') : array();
												
						if($excluded_pages){
							foreach($excluded_pages as $key => $page){
								if($page == $post_ID) unset($excluded_pages[$key]);
							}
						}

						global $wpdb;
						$headway_options_table = $wpdb->prefix.'headway_options';
												
						$excluded_pages = serialize($excluded_pages);
												
						$wpdb->query("UPDATE $headway_options_table SET `value`='$excluded_pages' WHERE `option`='excluded_pages'");
												
					} else {
						
						$excluded_pages = (is_array(headway_get_option('excluded_pages'))) ? headway_get_option('excluded_pages') : array();
													 		
												
						if(!in_array($post_ID, $excluded_pages)) array_push($excluded_pages, $post_ID);
						
				
						global $wpdb;
						$headway_options_table = $wpdb->prefix.'headway_options';
						
						$excluded_pages = serialize($excluded_pages);
												
						$wpdb->query("UPDATE $headway_options_table SET `value`='$excluded_pages' WHERE `option`='excluded_pages'");
						
					}

										
				}

			}
			elseif(!get_post_meta($post_ID, '_'.$key, true) && $value != NULL){
				add_post_meta($post_ID, '_'.$key, $value); 
			}
		endforeach;
	
		
		
	}
   

}