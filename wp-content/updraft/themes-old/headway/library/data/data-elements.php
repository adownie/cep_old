<?php
class HeadwayElementsData {


	public static function init() {

		add_action('headway_visual_editor_save', array(__CLASS__, 'merge_core_default_design_data'));

	}


	/* Used to merge in the global defaults for backwards compatibility */
	public static function get_raw_data($defaults = array()) {

		return headway_array_merge_recursive_simple(self::get_legacy_default_data(), HeadwaySkinOption::get('properties', 'design', $defaults));

	}
	
	
	/* Mass Get */
	public static function get_all_elements() {
				
		$elements = self::get_raw_data();
			
		//Move default elements to the top
		foreach ( $elements as $element_id => $element_options ) {
			
			$element = HeadwayElementAPI::get_element($element_id);
			
			if ( !isset($element['default-element']) || $element['default-element'] === false )
				continue;
				
			$temp_id = $element_id;
			$temp_options = $element_options;
			
			unset($elements[$element_id]);
			
			$elements = array_merge(array($temp_id => $temp_options), $elements);
			
		}
					
		return $elements;
		
	}
	
	
	public static function get_element_properties($element) {
		
		//Get element ID
		$element_id = is_array($element) ? $element['id'] : $element;
			
		$element = headway_get($element_id, self::get_raw_data());
		
		if ( !isset($element['properties']) || !is_array($element['properties']) )
			$element['properties'] = array();
		
		$properties = $element['properties'];
		
		//Fetch the property
		return ( is_array($properties) && count($properties) > 0 ) ? $properties : array();
		
	}
	
	
	public static function get_special_element_properties($args) {

		$defaults = array(
			'element' => null,
			'se_type' => null,
			'se_meta' => null
		);
		
		extract(array_merge($defaults, $args));

		//Get element ID
		$element_id = is_array($element) ? $element['id'] : $element;
				
		$element = headway_get($element_id, self::get_raw_data(), array(
			'special-element-' . $se_type => array()
		));

		if ( !isset($element['special-element-' . $se_type][$se_meta]) || !is_array($element['special-element-' . $se_type][$se_meta]) )
			$element['special-element-' . $se_type][$se_meta] = array();
		
		$properties =& $element['special-element-' . $se_type][$se_meta];
			
		//Return the data
		return ( is_array($properties) && count($properties) > 0 ) ? $properties : array();
		
	}
	

	/* Single Get */
	public static function get_property($element_id, $property_id, $default = null, $element_group = null) {
		
		$properties = self::get_element_properties($element_id);
		
		if ( $properties !== null && !is_wp_error($properties) && isset($properties[$property_id]) && (headway_fix_data_type($properties[$property_id]) || headway_fix_data_type($properties[$property_id]) === 0) )
			return headway_fix_data_type($properties[$property_id]);
			
		else
			return $default;
		
	}
	
	
	public static function get_special_element_property($element_id, $se_type, $se_meta, $property_id, $default = null, $element_group = null) {
		
		$properties = self::get_special_element_properties(array(
			'element' => $element_id, 
			'se_type' => $se_type, 
			'se_meta' => $se_meta
		));
		
		if ( $properties !== null && !is_wp_error($properties) && isset($properties[$property_id]) && (headway_fix_data_type($properties[$property_id]) || headway_fix_data_type($properties[$property_id]) === 0) )
			return headway_fix_data_type($properties[$property_id]);
			
		else
			return $default;
		
	}
	
	
	public static function get_inherited_property($element_id, $property_id, $default = null) {
		
		//Check for normal property first.  Need this for recursion and for instances/states.
		if ( $normal_property = self::get_property($element_id, $property_id) )
			return $normal_property;
		
		//Check for inherit location right away.
		$inherit_location = HeadwayElementAPI::get_inherit_location($element_id);
		
		//If inherit location does not exist, go straight to default.
		if ( !$inherit_location )
			return $default;
		
		//If it does exist, loop this function through again	
		else
			return self::get_inherited_property($inherit_location, $property_id, $default);
			
	}
	
	
	/* Setting */
	public static function set_property($element_group = null, $element_id, $property_id, $value) {

		/* Pass the torch onto self::delete_property() if the value is 'delete' */
			if ( strtolower($value) == 'delete' )
				return self::delete_property($element_id, $property_id);

		$all_properties = HeadwaySkinOption::get('properties', 'design', array());

		/* Insure array exists for element that property is being set for */
		if ( !isset($all_properties[$element_id]) || !is_array($all_properties[$element_id]) )
			$all_properties[$element_id] = array('properties' => array());

		/* Set the property */
		if ( $value == 'null' )
			$value = null;

		$all_properties[$element_id]['properties'][$property_id] = $value;
		
		/* Send it back to DB */
		return HeadwaySkinOption::set('properties', $all_properties, 'design');
		
	}
	

		public static function delete_property($element_id, $property_id) {

			$all_properties = HeadwaySkinOption::get('properties', 'design', array());

			/* Delete the property */
				if ( !empty($all_properties[$element_id]['properties']) && isset($all_properties[$element_id]['properties'][$property_id]) )
					unset($all_properties[$element_id]['properties'][$property_id]);

			/* Send it back to DB */
			return HeadwaySkinOption::set('properties', $all_properties, 'design');
			
		}

	
	public static function set_special_element_property($element_group = null, $element_id, $special_element_type, $special_element_meta, $property_id, $value) {

		/* Pass the torch onto self::delete_special_element_property() if the value is 'delete' */
			if ( strtolower($value) == 'delete' )
				return self::delete_special_element_property(null, $element_id, $special_element_type, $special_element_meta, $property_id);

		$all_properties = HeadwaySkinOption::get('properties', 'design', array());

		/* Insure array exists for element that property is being set for */
		if ( !isset($all_properties[$element_id]) || !is_array($all_properties[$element_id]) )
			$all_properties[$element_id] = array('special-element-' . $special_element_type => array(
				$special_element_meta => array()
			));

		/* Set the property */
		if ( $value == 'null' )
			$value = null;

		$all_properties[$element_id]['special-element-' . $special_element_type][$special_element_meta][$property_id] = $value;
		
		/* Send it back to DB */
		return HeadwaySkinOption::set('properties', $all_properties, 'design');
		
	}


		public static function delete_special_element_property($element_group = null, $element_id, $special_element_type, $special_element_meta, $property_id) {

			$all_properties = HeadwaySkinOption::get('properties', 'design', array());

			if ( isset($all_properties[$element_id]['special-element-' . $special_element_type][$special_element_meta][$property_id]) )
				unset($all_properties[$element_id]['special-element-' . $special_element_type][$special_element_meta][$property_id]);
			
			/* Send it back to DB */
			return HeadwaySkinOption::set('properties', $all_properties, 'design');

		}


		public static function delete_special_element_properties($element_group = null, $element_id, $special_element_type, $special_element_meta) {

			$all_properties = HeadwaySkinOption::get('properties', 'design', array());

			/* Delete all special elements matching the meta and type */
				if ( isset($all_properties[$element_id]['special-element-' . $special_element_type][$special_element_meta]) )
					unset($all_properties[$element_id]['special-element-' . $special_element_type][$special_element_meta]);

			/* Send it back to DB */
			return HeadwaySkinOption::set('properties', $all_properties, 'design');

		}


	/* Defaults */
		public static function get_default_data() {

			global $headway_core_default_element_data;

			return $headway_core_default_element_data;

		}


			public static function get_legacy_default_data() {

				global $headway_default_element_data;

				if ( !isset($headway_default_element_data) || !is_array($headway_default_element_data) )
					$headway_default_element_data = array();

				return apply_filters('headway_element_data_defaults', $headway_default_element_data);

			}


		/**
		 * Merge in default design data.  This will be ran upon save and upgrade to Headway 3.6
		 */
		public static function merge_core_default_design_data() {

			return self::merge_default_design_data(HeadwayElementsData::get_default_data(), 'core');

		}


			/* This function accepts data as well as ID that way it can be used by Headway plugins */
			public static function merge_default_design_data($default_data, $id) {

				$merge_id = 'merged-default-design-data-' . strtolower(str_replace(array(' ', '-'), '_', $id));

				/* Only merge if it hasn't been merged before. */
				if ( !HeadwaySkinOption::get($merge_id, 'general', false) ) {

					$design_data = HeadwaySkinOption::get('properties', 'design', array());
					$design_data_with_defaults = headway_array_merge_recursive_simple($default_data, $design_data);

					HeadwaySkinOption::set($merge_id, true, 'general');

					return HeadwaySkinOption::set('properties', $design_data_with_defaults, 'design');

				}

				/* Already merged, return false */
				return false;

			} 


		public static function upgrade_to_36_data_scheme() {

			$combined_design_settings = array();

			//Fetch all options in wp_options and get old Headway design options
			foreach ( wp_load_alloptions() as $option => $option_value ) {
							
				if ( strpos($option, 'headway_option_group_design-editor-group') !== 0 )
					continue;

				$combined_design_settings = array_merge($combined_design_settings, get_option($option));

			}

			HeadwaySkinOption::set('properties', $combined_design_settings, 'design');

			HeadwayElementsData::merge_core_default_design_data();

		}


}