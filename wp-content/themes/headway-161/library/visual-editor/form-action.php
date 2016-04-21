<?php
if(!headway_can_visually_edit()) die('You have insufficient privileges to use the visual editor.');

global $wpdb;

$navigation = $_POST['nav_order'];
$do_not_change = array();

if(isset($_POST['nav_order'])){
	foreach($navigation as $position => $items){
	
		if($position == 'main' || $position == 'inactive'){
			if($items != 'unserialized') {
				$items = explode('|', $items);
		
				if($position == 'inactive'){
					headway_update_option('excluded_pages', $items);
				} else {
					foreach($items as $item){
						if(!in_array($item, $do_not_change)){
							$position = array_search($item, $items);
				
							$nav_update[$item]  = "UPDATE $wpdb->posts SET post_parent='0', menu_order='$position' WHERE ID='$item'";						
									
							$wpdb->query($nav_update[$item]);
						}
					}
				}	
			}	
		} elseif($position == 'child') {
			foreach($items as $parent => $children){
				if($children != 'unserialized' && $children) {
			
					$children = explode('|', $children);		
					$parent = str_replace('page-', '', $parent);
			
					foreach($children as $child){
						$position = array_search($child, $children);
						$position = $position+1;
					
						array_push($do_not_change, $child);

						$nav_child_update[$child]  = "UPDATE $wpdb->posts SET post_parent='$parent', menu_order='$position' WHERE ID='$child'";
										
						$wpdb->query($nav_child_update[$child]);
					}
			
				}
		
			}
		}
	}
}

if($_POST['color']){
	foreach($_POST['color'] as $element => $properties){
		foreach($properties as $property => $value){
			headway_update_element_style($element, 'color', $property, $value);
		}
	}
}

if($_POST['fonts']){	
	foreach($_POST['fonts'] as $element => $properties){
		foreach($properties as $property => $value){
			headway_update_element_style($element, 'font', $property, $value);
		}
	}
}

if($_POST['width']){	
	foreach($_POST['width'] as $element => $properties){
		foreach($properties as $property => $value){
			$value = ($value == '0') ? 'zero' : $value; /* For sizing property type. Won't save zeros without this. */
			headway_update_element_style($element, 'sizing', $property, $value);
		}
	}
}



if($_POST['delete']){
	foreach($_POST['delete'] as $leaf => $delete){
		if($delete){
			headway_delete_leaf(str_replace('leaf-', '', $leaf));
		}
	}
}

if($_POST['layout-order'] != 'unserialized'){
	$order = explode('|', str_replace('&', '|', str_replace('leaf[]=', '', $_POST['layout-order'])));
	
	$leaf_position = 1;
	
	foreach($order as $leaf){
		headway_update_leaf($leaf, $leaf_position);
		$leaf_position++;
	}
		
}


if($_POST['add']){	
	$order = explode('|', str_replace('&', '|', str_replace('leaf[]=', '', $_POST['layout-order'])));
	
	foreach($_POST['add'] as $leaf => $class){		
		$leaf_id = str_replace('leaf-', '', $leaf);
		$position[$leaf_id] = array_search($leaf_id, $order);
		$options[$leaf_id] = $_POST['leaf-options'][$leaf_id];
		$config[$leaf_id] = $_POST['config'][$leaf_id];
			
		if($options[$leaf_id]['text-content']) $options[$leaf_id]['text-content'] = base64_encode($options[$leaf_id]['text-content']);
		if($options[$leaf_id]['blurb']) $options[$leaf_id]['blurb'] = base64_encode($options[$leaf_id]['blurb']);
					
		headway_add_leaf($_POST['current-page'], $position[$leaf_id]+1, array(
			'type' => $class,
			'title' => base64_encode($_POST['title'][$leaf]),
			'show-title' => $config[$leaf_id]['show-title'],
			'title-link' => $config[$leaf_id]['leaf-title-link'],
			'width' => $_POST['dimensions'][$leaf]['width'],
			'height' => $_POST['dimensions'][$leaf]['height'],
			'fluid-height' => true,
			'align-right' => false,
			'custom-classes' => $config[$leaf_id]['custom-css-classes']
		), $options[$leaf_id], $leaf_id);
	}
}


if(is_array($_POST['title'])){
	$add_array = ($_POST['add']) ? $_POST['add'] : array();
	
	foreach($_POST['title'] as $leaf => $title){
		
		if(!in_array($leaf_id, $add_array)){
			$leaf_id = str_replace('leaf-', '', $leaf);
			$config[$leaf_id] = headway_get_leaf($leaf_id);
			$config[$leaf_id] = $config[$leaf_id]['config'];
		
			$config[$leaf_id]['title'] = base64_encode($title);
				
			headway_update_leaf($leaf_id, false, $config[$leaf_id]);
		}
	}
}

if($_POST['dimensions']){
	$add_array = ($_POST['add']) ? $_POST['add'] : array();
	
	foreach($_POST['dimensions'] as $leaf => $dimensions){
		
		if(!in_array($leaf_id, $add_array)){
			$leaf_id = str_replace('leaf-', '', $leaf);
			
			$config[$leaf_id] = headway_get_leaf($leaf_id);
			$config[$leaf_id] = $config[$leaf_id]['config'];

			$config[$leaf_id]['width'] = $dimensions['width'];
			$config[$leaf_id]['height'] = ($_POST['dimensions'][$leaf]['height-changed'] == 'true') ? $dimensions['height'] : $config[$leaf_id]['height'];

			headway_update_leaf($leaf_id, false, $config[$leaf_id]);
		}
	}
}


if($_POST['leaf-options']){
	$add_array = ($_POST['add']) ? $_POST['add'] : array();
	
	foreach($_POST['leaf-options'] as $leaf => $options){
				
		if($options['text-content']) $options['text-content'] = base64_encode($options['text-content']);
		if($options['blurb']) $options['blurb'] = base64_encode($options['blurb']);
				
		if(!in_array(str_replace('leaf-', '', $leaf), $add_array)){						
			headway_update_leaf($leaf, false, false, $options);
		}
		
	}
}


if($_POST['leaf-switches']){
	foreach($_POST['leaf-switches'] as $leaf => $options){
		$leaf = str_replace('leaf-', '', $leaf);
		
		$config[$leaf] = headway_get_leaf($leaf);
		$config[$leaf] = $config[$leaf]['config'];
				
		$config[$leaf]['align-right'] = ($options['align-right'] == 'true') ? true : false;
		$config[$leaf]['fluid-height'] = ($options['fluid-height'] == 'true') ? true : false;
						
		headway_update_leaf($leaf, false, $config[$leaf]);
	}
}

if($_POST['config']){
	$add_array = ($_POST['add']) ? $_POST['add'] : array();
	
	foreach($_POST['config'] as $leaf => $config_post){
		
		if(!in_array(str_replace('leaf-', '', $leaf), $add_array)){
			$config[$leaf] = headway_get_leaf($leaf);
			$config[$leaf] = $config[$leaf]['config'];
			
			if($_POST['title']['leaf-'+$leaf]) $config[$leaf]['title'] = base64_encode($_POST['title']['leaf-'+$leaf]);
			
			if($_POST['dimensions']['leaf-'+$leaf]['width']) $config[$leaf]['width'] = $_POST['dimensions']['leaf-'+$leaf]['width'];
			if($_POST['dimensions']['leaf-'+$leaf]['height'] && $_POST['dimensions']['leaf-'+$leaf]['height-changed'] == 'true') $config[$leaf]['height'] = $_POST['dimensions']['leaf-'+$leaf]['height'];
			
			$config[$leaf]['show-title'] = $config_post['show-title'];
			$config[$leaf]['title-link'] = $config_post['leaf-title-link'];
			$config[$leaf]['custom-classes'] = $config_post['custom-css-classes'];


			headway_update_leaf($leaf, false, $config[$leaf]);
		}
		
	}
}

if($_POST['headway-config']){
	foreach($_POST['headway-config'] as $key => $value){
		$value = (!$value && $key != 'header-image-url' && $key != 'body-background-image-url') ? 'DELETE' : $value;
		
		if($key == 'header-image' && $_POST['headway-config']['header-image'] == headway_get_option('header-image')){
			continue;
		} elseif($key == 'header-image-url' && $value && $value != headway_get_option('header-image')){
			$key = 'header-image';
		}
		
		
		if($key == 'body-background-image' && $_POST['headway-config']['body-background-image'] == headway_get_option('body-background-image')){
			continue;
		} elseif($key == 'body-background-image-url' && $value && $value != headway_get_option('body-background-image')){
			$key = 'body-background-image';
		}
				
		headway_update_option($key, $value);
	}
}


if($_POST['header-order']){
	if($_POST['header-order'] != 'unserialized'){
		$order = explode('|', str_replace('-container', '', str_replace('headerOrder[]=', '', str_replace('&headerOrder[]=', '|', $_POST['header-order']))));

		headway_update_option('header-order', $order);
	}
}


if($_POST['nav_item']){
	foreach($_POST['nav_item'] as $page => $options){
		
		$page = str_replace('page-item-', '', $page);
		
		foreach($options as $option => $value){
			if($option == 'name'){
				$page_name_query[$page] = "UPDATE $wpdb->posts SET post_title='".$value."' WHERE ID='$page'";
				
				$wpdb->query($page_name_query[$page]);
			}
			
			if($option == 'forward-url'){
				update_post_meta($page, '_navigation_url', $value);
			}
			
			if($option == 'category'){
				update_post_meta($page, '_headway_category_forward', $value);
			}
		}
	}

}


if($_POST['link-pages']){
	if($_POST['link-pages']['pages']){
		foreach($_POST['link-pages']['pages'] as $pages){
			if($_POST['is-system-page'] == 'true'){
				update_post_meta($pages, '_leaf_system_template', $_POST['current-page']);
				delete_post_meta($pages, '_leaf_template');
			} else {
				update_post_meta($pages, '_leaf_template', $_POST['current-page']);
				delete_post_meta($pages, '_leaf_system_template');
			}
		}
	}
	if($_POST['link-pages']['system-pages']){
		foreach($_POST['link-pages']['system-pages'] as $system_page){
			if($_POST['is-system-page'] == 'true'){
				headway_update_option('leaf-template-system-page-'.$system_page, $_POST['current-page']);
				headway_delete_option('leaf-template-page-'.$system_page);
			} else {
				headway_update_option('leaf-template-page-'.$system_page, $_POST['current-page']);
				headway_delete_option('leaf-template-system-page-'.$system_page);
			}
		}
	}
}
elseif($_POST['leafs-link-page'] || $_POST['leafs-link-system-page']){
	
	if($_POST['leafs-link-page'] != 'DELETE'){
		if($_POST['is-system-page'] == 'true'){
			headway_update_option('leaf-template-page-'.$_POST['current-real-page'], $_POST['leafs-link-page']);
			headway_delete_option('leaf-template-system-page-'.$_POST['current-real-page']);
		} else {
			update_post_meta($_POST['current-real-page'], '_leaf_template', $_POST['leafs-link-page']);
			delete_post_meta($_POST['current-real-page'], '_leaf_system_template');
		}
	} elseif($_POST['leafs-link-page'] == 'DELETE') {
		if($_POST['is-system-page'] == 'false'){
			if($_POST['leafs-link-system-page'] == 'DELETE') delete_post_meta($_POST['current-real-page'], '_leaf_system_template');
			delete_post_meta($_POST['current-real-page'], '_leaf_template');
		} else {
			headway_delete_option('leaf-template-page-'.$_POST['current-real-page']);
		}
	}
	
	if($_POST['leafs-link-system-page'] != 'DELETE'){
		if($_POST['is-system-page'] == 'true'){
			headway_update_option('leaf-template-system-page-'.$_POST['current-real-page'], $_POST['leafs-link-system-page']);
			headway_delete_option('leaf-template-page-'.$_POST['current-real-page']);
		} else {
			update_post_meta($_POST['current-real-page'], '_leaf_system_template', $_POST['leafs-link-system-page']);
			delete_post_meta($_POST['current-real-page'], '_leaf_template');
		}
	} elseif($_POST['leafs-link-system-page'] == 'DELETE') {
		if($_POST['is-system-page'] == 'false'){
			if($_POST['leafs-link-page'] == 'DELETE') delete_post_meta($_POST['current-real-page'], '_leaf_system_template');
		} else {
			headway_delete_option('leaf-template-system-page-'.$_POST['current-real-page']);
		}
	}
	
	
	if($_POST['leafs-link-page'] == 'DELETE' && $_POST['leafs-link-system-page'] == 'DELETE'){
		headway_delete_option('leaf-template-system-page-'.$_POST['current-real-page']);
		headway_delete_option('leaf-template-page-'.$_POST['current-real-page']);
				
		delete_post_meta($_POST['current-real-page'], '_leaf_template');
		delete_post_meta($_POST['current-real-page'], '_leaf_system_template');
	}

}

if($_POST['set-default-leafs']){
	$leafs = headway_get_page_leafs($_POST['current-real-page']);
	
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	
	$wpdb->query("DELETE FROM $headway_leafs_table WHERE page='leaf-template'");
	
	if(count($leafs) > 0){
		foreach($leafs as $leaf){
			$leaf = array_map('maybe_unserialize', $leaf);			
						
			$leaf_config = $leaf['config'];
			$leaf_options = $leaf['options'];
			
			if($leaf_config['type'] == 'sidebar' && !$leaf_options['duplicate-id']){
				$leaf_options['duplicate-id'] = $leaf['id'];
			}
			
			$position = $leaf['position'];

			headway_add_leaf('leaf-template', $position, $leaf_config, $leaf_options);
		}
	}
	
	headway_update_option('leaf-template-exists', 'true');
}

if($_POST['reset-leafs']){
	headway_build_default_leafs($_POST['current-real-page'], false, true);
	
	headway_clear_cache();
	
	headway_update_option('cleared-cache', 'true');
}

if($_POST['headway-config']){
	headway_clear_cache();
	
	headway_update_option('css-last-updated', mktime()+1);
	
	headway_update_option('cleared-cache', 'true');
}