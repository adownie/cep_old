<?php
/**
 * Functions to get, update, and delete data from the database.
 *
 * @package Headway
 * @subpackage Data Handling
 * @author Clay Griffiths
 **/


/**
 * Simplifies the get_post_meta function for the Headway custom write box class.
 *
 * @uses get_post_meta()
 * 
 * @param string $name Meta row to be queried.
 * @param bool $echo
 * @param int $id
 * 
 * @return void|mixed If $echo, then return the meta value.
 **/
function headway_get_write_box_value($name, $echo = false, $id = false){
	if(!$id):
	 global $post;
	 $id = $post->ID;
	endif;
	
	if($echo):
		echo get_post_meta($id, '_'.$name, true);
	else:
		return get_post_meta($id, '_'.$name, true);
	endif;
	
}

/**
 * Simply changes "zero" to 0
 *
 * @param array Array to be filtered.
 * @return array
 **/
function headway_change_zeros($array){
	$array['value'] = ($array['value'] == 'zero') ? '0' : $array['value'];
	
	return $array;
}


/**
 * Queries the Headway options table for the desired option.
 *
 * @global object $wpdb
 * 
 * @uses headway_delete_option()
 * 
 * @param string $option Option to be queried.
 * @param bool $unserialize Whether or not to unserialize the value returned.
 * 
 * @return mixed $data The value row.
 **/
function headway_get_option($option, $unserialize = true, $force_query = false){
	global $wpdb;
	global $headway_options_cached;
	global $headway_force_queries;

	$headway_options_table = $wpdb->prefix.'headway_options';
	
	if(!$force_query && !$headway_force_queries){
		
		if(!$headway_options_cached){
			$headway_options_result = $wpdb->get_results("SELECT * FROM $headway_options_table ORDER BY id ASC", ARRAY_A);
	
			if($headway_options_result){
				foreach($headway_options_result as $row){						
					$headway_options_cached[$row['option']] = $row['value'];
				}
			}
		}
	
		//Keep errors from popping up during activation.
		if(!$headway_options_cached){
			return false;
		}
	
		$data = ($unserialize) ? maybe_unserialize(stripslashes($headway_options_cached[$option])) : stripslashes($headway_options_cached[$option]);
		
	} else {
		
		$data = ($unserialize) ? maybe_unserialize(stripslashes($wpdb->get_var("SELECT `value` FROM $headway_options_table WHERE `option`='$option'"))) : stripslashes($wpdb->get_var("SELECT `value` FROM $headway_options_table WHERE `option`='$option'"));
		
	}

	if($data == 'DELETE' || $data == 'CREATEROW'){ 
		headway_delete_option($option);
		
		return false;
	}
	
	return ($data == 'off' || ($data == 'DELETE' || $data == 'delete') || $data == '') ? false : $data;			
}


/**
 * Updates the Headway options table.
 *
 * @global object $wpdb
 * 
 * @param string $option Option to update.
 * @param mixed $value Value to update the row with.
 * 
 * @return bool
 **/
function headway_update_option($option, $value){
	global $wpdb;
	global $headway_options_cached;

	$headway_options_table = $wpdb->prefix.'headway_options';
	
	if(!$wpdb->get_var("SELECT `option` FROM $headway_options_table WHERE `option`='$option'")){
		if(!is_array($value)){
			$value = $wpdb->escape((string)$value);
		} else {
			$value = serialize($value);
		}
		
		return headway_add_option($option, $value);
	} else {
		$value = (!is_array($value)) ? $wpdb->escape($value) : serialize($value);
		return $wpdb->query("UPDATE $headway_options_table SET `value`='$value' WHERE `option`='$option'");
	}
	
	$headway_options_cached = false;
}


/**
 * Adds a row to the Headway options table.
 * 
 * @global object $wpdb
 * 
 * @param string $option Option to be inserted.
 * @param mixed $value Value to be inserted.
 *
 * @return bool
 **/
function headway_add_option($option, $value = false){
	global $wpdb;

	$headway_options_table = $wpdb->prefix.'headway_options';
	
	return $wpdb->query("INSERT INTO $headway_options_table (`option`, `value`) VALUES('$option', '$value')");
}


/**
 * Deletes a row from the Headway options table.
 * 
 * @global object $wpdb
 * 
 * @param string $options Option to be deleted.
 *
 * @return bool
 **/
function headway_delete_option($option){
	global $wpdb;

	$headway_options_table = $wpdb->prefix.'headway_options';
	
	return $wpdb->query("DELETE FROM $headway_options_table WHERE `option`='$option'");
}


/**
 * Queries the database for the element rows.
 * 
 * If all params are false, it will return everything from the table.  If the property type param is the only one, then it will only fetch those.  Likewise with the element param.  If all three params are present, it will return the value for the specific row.
 * 
 * @global object $wpdb
 * 
 * @uses headway_change_zeros()
 * 
 * @param string $element
 * @param string $property_type
 * @param string $property
 *
 * @return mixed
 **/
function headway_get_element_styles($element = false, $property_type = false, $property = false){
	global $wpdb;
				
	$headway_elements_table = $wpdb->prefix.'headway_elements';
	
	if(!$property_type && !$element && !$property){
		$value = $wpdb->get_results("SELECT * FROM $headway_elements_table", ARRAY_A);
				
		return (is_array($value)) ? array_map('headway_change_zeros', $value) : $value;
	}
	elseif($property_type && !$element && !$property){
		$value = $wpdb->get_results("SELECT * FROM $headway_elements_table WHERE property_type='$property_type'", ARRAY_A);	
		
		return (is_array($value)) ? array_map('headway_change_zeros', $value) : $value;
	}
	elseif($element && !$property_type && !$property){		
		$value = $wpdb->get_results("SELECT * FROM $headway_elements_table WHERE element='$element'", ARRAY_A);		
		
		return $value;
	}
	else{
		$value = $wpdb->get_var("SELECT value FROM $headway_elements_table WHERE element='$element' AND property_type='$property_type' AND property='$property'");		
						
		if($value == 'zero') $value = '0';
		
		return $value;
	}	
}


/**
 * Simplifies headway_get_element_styles() to return one value.
 *
 * @uses headway_get_element_styles()
 * 
 * @param string $property_type
 * @param string $element
 * @param string $property
 * 
 * @return mixed
 **/
function headway_get_element_property($property_type, $element, $property){
	return headway_get_element_styles($element, $property_type, $property);
}


/**
 * Updates or inserts an element row.
 * 
 * @global object $wpdb
 * 
 * @uses headway_get_element_styles()
 * 
 * @param string $element
 * @param string $property_type
 * @param string $property
 * @param mixed $value
 *
 * @return bool
 **/
function headway_update_element_style($element = false, $property_type = false, $property = false, $value = false){
	global $wpdb;
				
	$headway_elements_table = $wpdb->prefix.'headway_elements';
	
	if($value){	
		$value = (string)$value;
		
		$wpdb->query("DELETE FROM $headway_elements_table WHERE `element`='$element' AND `property_type`='$property_type' AND `property`='$property'");	
		$wpdb->query("INSERT INTO $headway_elements_table (`element`, `property_type`, `property`, `value`) VALUES('$element', '$property_type', '$property', '$value')");
		
		return true;
	}
}


/**
 * Gets, sets, and deletes values from the Headway taxonomies table.
 *	
 * @global object $wpdb
 * 
 * @param array $args
 * 
 * @todo Rewrite this function and make it not suck.
 * 
 * @return mixed
 **/
function headway_taxonomies($args){
	global $wpdb;
	
	// $type
	// $content
	// $parent
	// $id
	// $delete
	
	extract($args);
	
	$headway_taxonomies_table = $wpdb->prefix.'headway_misc';
	
	
	if($id && !$delete && !$content && !$type){
		$array = $wpdb->get_row("SELECT * FROM $headway_taxonomies_table WHERE id='$id'", ARRAY_A);
		if($array){
			return array_map('maybe_unserialize', $array);
		} else {
			return false;
		}
	}
	elseif($type && !$parent && !$id){
		return $wpdb->get_results("SELECT * FROM $headway_taxonomies_table WHERE `type`='$type' ORDER BY timestamp ASC", ARRAY_A);
	}
	elseif($parent && !$type && !$id){
		return $wpdb->get_results("SELECT * FROM $headway_taxonomies_table WHERE `parent_id`='$parent' ORDER BY timestamp ASC", ARRAY_A);
	}
	elseif($parent && $type && !$id){
		return $wpdb->get_results("SELECT * FROM $headway_taxonomies_table WHERE `parent_id`='$parent' AND `type`='$type' ORDER BY timestamp ASC", ARRAY_A);
	}
	elseif($content && !$delete){
		$content = maybe_serialize($content);
		$content = addslashes($content);
		
		
		if($id == 'NEW'){
			$wpdb->query("INSERT INTO $headway_taxonomies_table (`type`, `content`, `parent_id`, `timestamp`) VALUES('$type', '$content', '$parent', ".time().")");
		} elseif($type && $content && $parent) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET (`type`, `content`, `parent_id`) VALUES('$type', '$content', '$parent') WHERE `id`='$id'");		
		} elseif($type && $content) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET (`type`, `content`) VALUES('$type', '$content') WHERE `id`='$id'");		
		} elseif($type && $parent) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET (`type`, `parent_id`) VALUES('$type', '$parent') WHERE `id`='$id'");		
		} elseif($content && $type) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET (`type`, `content`) VALUES('$type', '$content') WHERE `id`='$id'");		
		} elseif($content && $parent) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET (`content`, `parent_id`) VALUES('$content', '$parent') WHERE `id`='$id'");		
		} elseif($content) {
			$wpdb->query("UPDATE $headway_taxonomies_table SET `content`='$content' WHERE `id`='$id'");		
		}
		
	}
	elseif($id && $parent && $delete){
		$wpdb->query("DELETE FROM $headway_taxonomies_table WHERE `id`='$id'");
		$wpdb->query("DELETE FROM $headway_taxonomies_table WHERE `parent_id`='$parent'");
	}
	elseif($id && $delete){
		$wpdb->query("DELETE FROM $headway_taxonomies_table WHERE `id`='$id'");
	}
}