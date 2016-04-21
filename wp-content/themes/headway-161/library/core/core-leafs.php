<?php
function headway_add_leaf($page, $position, $leaf_config, $leaf_options, $id = false){
	global $wpdb;
		
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	if(is_array($leaf_config)) $leaf_config = serialize($leaf_config);
	if(is_array($leaf_options)) $leaf_options = serialize($leaf_options);
			
	$wpdb->insert( $headway_leafs_table, array( 'id' => $id, 'page' => $page, 'position' => $position, 'config' => $leaf_config, 'options' => $leaf_options ) );
	
	return $wpdb->insert_id;
}

function headway_update_leaf($leaf, $position = false, $leaf_config = false, $leaf_options = false){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	if(is_array($leaf_config)) $leaf_config = serialize($leaf_config);
	if(is_array($leaf_options)) $leaf_options = serialize($leaf_options);
	
	if($leaf_config) $query .= " SET config='$leaf_config'";
	if($leaf_options) $query .= " SET options='$leaf_options'";
	if($position) $query .= " SET position='$position'";
	
 	return $wpdb->query("UPDATE $headway_leafs_table$query WHERE id='$leaf'");
}

function headway_delete_leaf($leaf){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	return $wpdb->query("DELETE FROM $headway_leafs_table WHERE id='$leaf'");
}

function headway_get_leaf($leaf){ 
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$leaf = str_replace('leaf-', '', $leaf);
	$result = $wpdb->get_row("SELECT * FROM $headway_leafs_table WHERE id='$leaf'", ARRAY_A);
	
	return (is_array($result)) ? array_map('maybe_unserialize', $result) : $result;
}


function headway_get_page_leafs($page){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$result = $wpdb->get_results("SELECT * FROM $headway_leafs_table WHERE page='$page' ORDER BY position ASC", ARRAY_A);
	return $result;
}

function headway_build_leafs(){
	$leafs = headway_get_page_leafs(headway_current_page(false, false, true));
	
	if(count($leafs) > 0){												    	
		foreach($leafs as $leaf){ 													// Start foreach loop for every leaf/box.
			$leaf = array_map('maybe_unserialize', $leaf);			
						
			$leaf_config = $leaf['config'];
			$leaf_options = $leaf['options'];
			
			
				$box_classes[$leaf['id']] = array(); //Create empty array. Won't work unless this is here.
				array_push($box_classes[$leaf['id']], $leaf['config']['type']); // Push the leaf type to the classes array.

				if($leaf['config']['custom-classes']){
					$custom_classes[$leaf['id']] = explode(' ', $leaf['config']['custom-classes']);
					
					foreach($custom_classes[$leaf['id']] as $custom_class){
						array_push($box_classes[$leaf['id']], $custom_class);
					}
				}  
				if(!$leaf['config']['show-title']) array_push($box_classes[$leaf['id']], 'box-no-title');
				if($leaf['config']['align-right']) array_push($box_classes[$leaf['id']], 'headway-leaf-right');
				if($leaf['config']['fluid-height']) array_push($box_classes[$leaf['id']], 'fluid-height');
				
				if($leaf_options['horizontal-sidebar']) array_push($box_classes[$leaf['id']], 'horizontal-sidebar');
								
				$box_classes[$leaf['id']] = implode(' ', $box_classes[$leaf['id']]); //Implodes array separating each class with a space so when echoed it doesn't print "Array"
			
									
			echo '<div class="'.$box_classes[$leaf['id']].' headway-leaf" id="leaf-'.$leaf['id'].'">';
			
				do_action('headway_leaf_top');
				do_action('headway_leaf_top_'.$leaf['id']);
				if($leaf_config['show-title']):
					$leaf_title = ($leaf_config['title-link']) ? '<a href="'.$leaf_config['title-link'].'" title="">'.stripslashes(base64_decode($leaf_config['title'])).'</a>' : stripslashes(base64_decode($leaf_config['title']));
					echo '<div class="leaf-top">'.$leaf_title.'</div>';
				endif;
										
				echo '<div class="leaf-content">';
				
				$action = 'headway_custom_leaf_'.$leaf['config']['type'].'_content';
				
				if(isset($_GET['safe-mode']) && headway_can_visually_edit()){
					echo 'You are currently in safe mode.  All leaf content will be disregarded until you leave safe mode.';
				} elseif(!has_action($action)){
					echo 'The requested leaf type does not exist.  Please re-activate the plugin if you wish to use this leaf again.';
				} else {
					do_action($action, $leaf);
				}

				echo '</div>';
				
				do_action('headway_leaf_bottom');
				do_action('headway_leaf_bottom_'.$leaf['id']);
				
				rewind_posts();
					
			echo '</div>';
		}
	}
}

function headway_get_all_leafs(){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$result = $wpdb->get_results("SELECT * FROM $headway_leafs_table ORDER BY id ASC", ARRAY_A);
	return $result;
}

function headway_get_last_leaf_id(){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$result = $wpdb->get_row("SELECT * FROM $headway_leafs_table ORDER BY id DESC LIMIT 1", ARRAY_A);
	return $result['id'];
}

function headway_delete_page_leafs($page){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$wpdb->query("DELETE FROM $headway_leafs_table WHERE page='$page'");
}

function headway_build_default_leafs($pageID, $leafs = false, $force = false){
	$leafs = ($leafs) ? $leafs : headway_get_page_leafs($pageID);
	
	if(count($leafs) < 1 || $force){
		
		if($force){
			global $wpdb;
			$headway_leafs_table = $wpdb->prefix.'headway_leafs';

			$wpdb->query("DELETE FROM $headway_leafs_table WHERE page='$pageID'");
		}
		
		if(headway_get_option('leaf-template-exists')){
			$leafs_from_template = headway_get_page_leafs('leaf-template');

			if(count($leafs_from_template) > 0){
				foreach($leafs_from_template as $leaf){
					$leaf = array_map('maybe_unserialize', $leaf);			

					$leaf_config = $leaf['config'];
					$leaf_options = $leaf['options'];

					$position = $leaf['position'];

					headway_add_leaf($pageID, $position, $leaf_config, $leaf_options);
				}
			}
			
		} else {
			headway_add_leaf($pageID, 1, array(
				'type' => 'content',
				'title' => 'Content',
				'show-title' => false,
				'title-link' => false,
				'width' => str_replace('px', '', headway_get_skin_option('wrapper-width'))-30,
				'height' => 115,
				'fluid-height' => true,
				'align-right' => false,
				'custom-classes' => false
			), array(
				'mode' => 'page',
				'other-page' => false,
				'categories-mode' => 'include',
				'post-limit' => get_option('posts_per_page'),
				'featured-posts' => 1,
				'paginate' => true
			));
		}
		
		headway_generate_cache();
	}
}

function headway_load_leafs(){
	$path = HEADWAYLEAFS;
	$dir_handle = @opendir($path) or die("Unable to open $path");

	while ($file = readdir($dir_handle)) {
		$file = rawurlencode($file);
		$leafs_dir[] = $file;
	}
	$remove_these = array('index.php', '.', '..', '.svn', '.git');
	$leafs = array_diff($leafs_dir, $remove_these);

	closedir($dir_handle);
	
	foreach($leafs as $leaf){
		if(!strpos($leaf, '.php')) continue;
		
		include HEADWAYLEAFS.'/'.$leaf;
	}
}

headway_load_leafs();