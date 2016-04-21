<?php
/**
 * Functions to get, update, and delete data from the database.
 *
 * @package Headway
 * @subpackage Data Handling
 * @author Clay Griffiths
 **/

class HeadwayLayoutOption {
	
	
	/**
	 * Set the default group for all of the database functions to get, set, and delete from.
	 **/
	protected static $default_group = 'general';


	/**
	 * Flag for fetching from skin options.
	 **/
	public static $is_skin_option = false;

	public static $current_skin;
	

	public static function init() {

		self::$current_skin = HeadwayOption::get('current-skin', 'general', HEADWAY_DEFAULT_SKIN);

	}

	
	
	public static function format_layout_id($layout) {
		
		//Create array to analyze last part of layout string
		$fragments = explode('-', $layout);
	
		//If it's a single layout
		if ( strpos($layout, 'single') !== false && is_numeric(end($fragments)) )
			$layout = (int)end($fragments);
			
		//If the layout is numeric, check that it's not the blog index or front page 
		if ( is_numeric($layout) && get_option('page_for_posts') == $layout )
			return 'index';
		elseif ( is_numeric($layout) && get_option('page_on_front') == $layout )
			return 'front_page';
		
		return str_replace('-', '_', $layout);
		
	}
	
	
	public static function get($layout = false, $option = null, $group_name = false, $default = null) {
		
		//If there's no option to retrieve, then we have nothing to retrieve.
			if ( $option === null )
				return null;
		
		//If there's no group defined, define it using the default
			if ( !$group_name ) 
				$group_name = self::$default_group;
			
		//Make sure there is a layout to use
			if ( !$layout ) 
				$layout = HeadwayLayout::get_current();
		
		//Retrieve options	
			$layout = self::format_layout_id($layout);
			$options = self::get_wp_option('headway_layout_options_' . $layout);

		//Option does not exist	
			if ( !$options || !isset($options[$group_name][$option]) || !is_array($options) ) 
				return $default;
		
		//Option exists
		return headway_fix_data_type($options[$group_name][$option]);
		
	}


		/**
		 * Format option name
		 **/
		public static function format_wp_option($option) {

			/* Format option name */
				if ( self::$is_skin_option && self::$current_skin != HEADWAY_DEFAULT_SKIN )
					$option = str_replace('headway_', 'headway_|skin=' . self::$current_skin . '|_', $option);

			return $option;

		}


		/**
		 * Function for combing self::format_wp_option() and get_option()
		 **/
		public static function get_wp_option($option) {

			return get_option(self::format_wp_option($option));

		}
	
	
	public static function set($layout = false, $option = null, $value = null, $group_name = false) {
				
		//If there's no option, we can't set anything.
			if ( $option === null )
				return false;
			
		//If there's no value, there's nothing to set.
			if ( $value === null )
				return false;
		
		//If there's no group defined, define it using the default
			if ( !$group_name ) 
				$group_name = self::$default_group;
		
		//Make sure there is a layout to use
			if ( !$layout ) 
				$layout = HeadwayLayout::get_current();
				
		//Format layout ID
			$layout = self::format_layout_id($layout);
														
		//Handle boolean values
			if ( is_bool($value) )
				$value = ( $value === true ) ? 'true' : 'false';
	
		//Retrieve existing options
			$options = self::get_wp_option('headway_layout_options_' . $layout);
		
		//If options aren't set, make it an array
			if( !is_array($options) ) 
				$options = array();
		
		//Make sure group exists
			if ( !isset($options[$group_name]) )
				$options[$group_name] = array();
		
		//Update data on array
			$options[$group_name][$option] = $value;	
																								
		//Send data to DB	
			update_option(self::format_wp_option('headway_layout_options_' . $layout), $options);
					
		return true;
						
		
	}
	
	
	public static function delete($layout, $option = null, $group_name = false) {
		
		//No deleting to be done if we don't have an option to delete
		if ( $option === null )
			return false;
		
		//If there's no group defined, define it using the default
		if ( !$group_name ) 
			$group_name = self::$default_group;
		
		//Make sure there is a layout to use
		if ( !$layout ) 
			$layout = HeadwayLayout::get_current();
			
		//Format layout ID
		$layout = self::format_layout_id($layout);	
				
		//Retrieve options array from DB
		$options = self::get_wp_option('headway_layout_options_' . $layout);
			
		//If DB option doesn't exist, make a default array
		if( !is_array($options) ) 
			$options = array();
				
		//Option or group doesn't exist
		if ( !isset($options[$group_name]) || !isset($options[$group_name][$option]) )	
			return false;
			
		//If option exists, delete the sucker
		unset($options[$group_name][$option]);
		
		//If group is empty, delete it too
		if ( count($options[$group_name]) === 0 )
			unset($options[$group_name]);
						
		//If the options array is empty, delete the entire option
		if ( count($options) === 0 )							
			return delete_option(self::format_wp_option('headway_layout_options_' . $layout));
																			
		return update_option(self::format_wp_option('headway_layout_options_' . $layout), $options);
		
	}


	public static function delete_all_from_layout($layout) {

		$options_deleted = array();

		foreach ( wp_load_alloptions() as $option => $option_value ) {

			/* Don't touch any option that doesn't start with 'headway_' */
			if ( strpos($option, 'headway_') !== 0 )
				continue;

			/* Skip any option that doesn't contain the layout_options_LAYOUTID part */
			if ( strpos($option, '_layout_options_' . self::format_layout_id($layout)) === false )
				continue;

			if ( delete_option($option) )
				$options_deleted[] = $option;

		}

		return $options_deleted;

	}

	
}