<?php
class HeadwayBlocksData {
	

	protected static $schema_cache = array();

	
	public static function schema_blocks_by_id($use_cache = false) {

		if ( $use_cache && $cached = headway_get('blocks-by-id', self::$schema_cache) )
			return $cached;

		/* Retrieve the option from DB */
		$blocks_by_id = HeadwaySkinOption::get('blocks-by-id', 'blocks', array());

		/* Cache it */
		self::$schema_cache['blocks-by-id'] = $blocks_by_id;
				
		/* Return it */
	 	return $blocks_by_id;
		
	}
	
	
	public static function schema_blocks_by_type() {
				
		/* Retrieve the option from DB */
		$blocks_by_type = HeadwaySkinOption::get('blocks-by-type', 'blocks', array());
				
		/* Return it */
	 	return $blocks_by_type;
	 			
	}
	
	
	public static function schema_blocks_by_layout() {

		/* Retrieve the option from DB */
		$blocks_by_layout = HeadwaySkinOption::get('blocks-by-layout', 'blocks', array());
				
		/* Return it */
	 	return $blocks_by_layout;
				
	}
	
	
	public static function schema_layout_blocks($layout_id) {

		/* Retrieve the option from DB */
		$layout_blocks = HeadwaySkinLayoutOption::get($layout_id, 'blocks', false, array());
				
		/* Return it */
	 	return $layout_blocks;
	 			
	}
	
	
	public static function add_block($layout_id, $args) {

		if ( !$args || !is_array($args) )
			return false;
		
		//Lots of defaults here.			
		$defaults = array(
			'type' => null,
			'wrapper' => null,
			
			'position' => array(
				'top' => 0,
				'left' => 0
			),
			
			'dimensions' => array(
				'width' => 0,
				'height' => 0
			),

			'settings' => array()
		);
		
		//Merge defaults with arguments
		$block_settings = array_merge($defaults, $args);
		
		//Check requirements for block
		if ( $block_settings['type'] === $defaults['type'] )
			return false;
		
		//Figure out block ID
		$block_id = ( isset($block_settings['id']) && !self::block_exists($block_settings['id'], false) ) ? $block_settings['id'] : self::get_available_block_id(array(), false);
		
		//Re-add block ID to array
		$block_settings['id'] = $block_id;
		
		//Get existing blocks from layout
		$layout_blocks = self::schema_layout_blocks($layout_id);
				
		//Fetch the big boy option that all blocks belong to
		$blocks_by_type = self::schema_blocks_by_type();		
		$blocks_by_id = self::schema_blocks_by_id();		
		$blocks_by_layout = self::schema_blocks_by_layout();		
		
		//Add the block to the layout's block array
		$layout_blocks[$block_id] = $block_settings;
		
		//Add block to global array(s)
		$blocks_by_type[$block_settings['type']][$block_id] = $layout_id;
		$blocks_by_id[$block_id] = array('layout' => $layout_id, 'type' => $block_settings['type']);
		$blocks_by_layout[$layout_id][$block_id] = true;
		
		//Update database
		HeadwaySkinLayoutOption::set($layout_id, 'blocks', $layout_blocks);
		
		HeadwaySkinOption::set('blocks-by-type', $blocks_by_type, 'blocks');
		HeadwaySkinOption::set('blocks-by-id', $blocks_by_id, 'blocks');
		HeadwaySkinOption::set('blocks-by-layout', $blocks_by_layout, 'blocks');
		
		//All done.  Spit back ID of newly created block.
		return $block_id;
		
	}
	
	
	public static function update_block($layout_id, $block_id, $args) {
		
		//Get existing blocks layout
		$blocks_by_type = self::schema_blocks_by_type();		
		$blocks_by_id = self::schema_blocks_by_id();
		
		$layout_blocks = self::schema_layout_blocks($layout_id);
		
		//If block doesn't exist, go false.
		if ( !isset($layout_blocks[$block_id]) )
			return false;
		
		//Pull out block settings from block we're gonna update.
		$old_block = $layout_blocks[$block_id];
		$updated_block = array_merge($old_block, $args);
		
		//Merge new block settings with old and update array
		$layout_blocks[$block_id] = $updated_block;
		
		//Since we're not sure if the type is being updated, we'll update it anyway for blocks-by-type and blocks-by-id
		if ( isset($blocks_by_type[$old_block['type']][$block_id]) )
			unset($blocks_by_type[$old_block['type']][$block_id]);
			
		$blocks_by_type[$updated_block['type']][$block_id] = $layout_id;
		
		$blocks_by_id[$block_id]['type'] = $updated_block['type'];
		
		//Push new arrays to DB
		HeadwaySkinLayoutOption::set($layout_id, 'blocks', $layout_blocks);
		
		HeadwaySkinOption::set('blocks-by-type', $blocks_by_type, 'blocks');
		HeadwaySkinOption::set('blocks-by-id', $blocks_by_id, 'blocks');
		
		//Everything OK
		return true;
		
	}


	public static function delete_block($layout_id, $block_id) {
		
		//Fetch options from DB
		$layout_blocks = self::schema_layout_blocks($layout_id);
		
		$blocks_by_type = self::schema_blocks_by_type();		
		$blocks_by_id = self::schema_blocks_by_id();
		$blocks_by_layout = self::schema_blocks_by_layout();
		
		//Find anomolies (going to ignore blocks by type array here)
		if ( !isset($layout_blocks[$block_id]) )
			return false;
			
		//Get block type
		$block_type = $blocks_by_id[$block_id]['type'];	
		
		//Strip block out of arrays
		unset($layout_blocks[$block_id]);
		
		unset($blocks_by_type[$block_type][$block_id]);
		unset($blocks_by_id[$block_id]);
		unset($blocks_by_layout[$layout_id][$block_id]);
		
		if ( count($blocks_by_type[$block_type]) === 0)
			unset($blocks_by_type[$block_type]);
			
		if ( count($blocks_by_layout[$layout_id]) === 0)
			unset($blocks_by_layout[$layout_id]);
		
		//Update database
		HeadwaySkinLayoutOption::set($layout_id, 'blocks', $layout_blocks);

		HeadwaySkinOption::set('blocks-by-type', $blocks_by_type, 'blocks');
		HeadwaySkinOption::set('blocks-by-id', $blocks_by_id, 'blocks');
		HeadwaySkinOption::set('blocks-by-layout', $blocks_by_layout, 'blocks');

		//Need to nuke all design settings and instances
		self::delete_block_design_instances($block_id, $block_type);
			
		//Everything successful
		return true;
		
	}


		public static function delete_block_design_instances($block_id, $block_type) {

			HeadwayElementAPI::register_elements_hook();

			$block_element = HeadwayElementAPI::get_element('block-' . $block_type);

			/* Start by queuing the instance of the block element */
				$instances_to_delete = array(
					'block-' . $block_type => $block_type . '-block-' . $block_id
				);
			
			/* Find all block children element instances and queue them to be deleted */
				foreach ( HeadwayElementAPI::get_block_elements($block_type) as $element_id => $element_info )
					$instances_to_delete[$element_id] = $element_id . '-block-' . $block_id;

			/* Delete the instances now */
				foreach ( $instances_to_delete as $element_id => $instance_id )
					HeadwayElementsData::delete_special_element_properties('blocks', $element_id, 'instance', $instance_id);

		}
	
	
	public static function delete_by_layout($layout_id) {
		
		//This function is only used when the grid is active.
		if ( !current_theme_supports('headway-grid') )
			return false;
		
		//Fetch options from DB
		$layout_blocks = self::schema_layout_blocks($layout_id);
		
		$blocks_by_type = self::schema_blocks_by_type();		
		$blocks_by_id = self::schema_blocks_by_id();
		$blocks_by_layout = self::schema_blocks_by_layout();
		
		foreach ( $layout_blocks as $block_id => $options ) {
			
			//Strip block out of arrays
			unset($layout_blocks[$block_id]);

			unset($blocks_by_type[$options['type']][$block_id]);				
			unset($blocks_by_id[$block_id]);
			unset($blocks_by_layout[$layout_id][$block_id]);
			
			if ( count($blocks_by_type[$options['type']]) === 0)
				unset($blocks_by_type[$options['type']]);
			
			if ( count($blocks_by_layout[$layout_id]) === 0)
				unset($blocks_by_layout[$layout_id]);

			//Delete design instances
			self::delete_block_design_instances($block_id, $options['type']);
			
		}
		
		//Update database
		HeadwaySkinLayoutOption::set($layout_id, 'blocks', $layout_blocks);

		HeadwaySkinOption::set('blocks-by-type', $blocks_by_type, 'blocks');
		HeadwaySkinOption::set('blocks-by-id', $blocks_by_id, 'blocks');
		HeadwaySkinOption::set('blocks-by-layout', $blocks_by_layout, 'blocks');
		
		//Everything successful
		return true;
		
		
	}
	
	
	public static function get_block($block, $use_mirrored = false) {
		
		/* If a block array is supplied, make sure it is legitimate. */
		if ( is_array($block) ) {
			
			if ( !isset($block['id']) && !headway_get('new', $block, false) )
				return null;
				
		/* Fetch the block based off of ID */
		} elseif ( is_numeric($block) ) {
			
			//Get the block from blocks-by-id to get the layout
			$blocks_by_id = self::schema_blocks_by_id();

			//If block doesn't exist, go false
			if ( !isset($blocks_by_id[$block]) )
				return false;

			//Retrieve all blocks from layout
			$layout_blocks = self::get_blocks_by_layout(headway_get('layout', $blocks_by_id[$block]));

			//Make sure that the block still exists once again on the layout.
			if ( !isset($layout_blocks[$block]) )
				return false;

			$block = $layout_blocks[$block];
		
		/* No valid argument provided. */	
		} else {
			
			return null;
			
		}
		
		/* Fetch the mirrored block if $use_mirrored is true */
		if ( $use_mirrored === true && $mirrored_block = self::is_block_mirrored($block) )
			$block = $mirrored_block;
				
		return $block;
		
	}
	
	
	public static function get_blocks_by_layout($layout_id, $include_design_editor_instances = false) {

		/* Retrieve all blocks from layout */
		$layout_blocks = self::schema_layout_blocks($layout_id);
		
		/* Add the layout ID and design editor instances in */
		foreach ( $layout_blocks as $block_id => $block ) {

			$layout_blocks[$block_id]['layout'] = $layout_id;

			/* Pull in Design Editor instances if set to do so */
				if ( $include_design_editor_instances ) {

					$layout_blocks[$block_id]['styling'] = self::get_block_styling($block);

				}
			/* End putting in Design Editor instances */

		}

						
		return $layout_blocks;
				
	}


		public static function get_block_styling($block) {

			do_action('headway_before_get_block_styling');

			$block_element = HeadwayElementAPI::get_element('block-' . $block['type']);

			/* Set up styling array */
			$styling = array();

			/* Get block instance styling */
				$block_instance_properties = HeadwayElementsData::get_special_element_properties(array(
					'element' => 'block-' . $block['type'],
					'se_type' => 'instance', 
					'se_meta' => $block['type'] . '-block-' . $block['id']
				));

				if ( !empty($block_instance_properties) ) {

					$styling[$block['type'] . '-block-' . $block['id']] = array(
						'element' => 'block-' . $block['type'],
						'properties' => $block_instance_properties
					);

				}

			/* Get block children element instances (which could be a LOT) */
			foreach ( HeadwayElementAPI::get_block_elements($block['type']) as $block_element_sub_element ) {

				/* Make sure that the element supports instances */
				if ( !headway_get('supports-instances', $block_element_sub_element) )
					continue;

				$sub_element_instance_id = $block_element_sub_element['id'] . '-block-' . $block['id'];

				$sub_element_instance_properties = HeadwayElementsData::get_special_element_properties(array(
					'element' => $block_element_sub_element['id'], 
					'se_type' => 'instance', 
					'se_meta' => $sub_element_instance_id
				));

				/* Only add sub element instance if there are properties present */
				if ( !empty($sub_element_instance_properties) ) {

					$styling[$sub_element_instance_id] = array(
						'element' => $block_element_sub_element['id'],
						'properties' => $sub_element_instance_properties
					);

				}

				/* Instance states */
					if ( !empty($block_element_sub_element['states']) && is_array($block_element_sub_element['states']) ) {

						foreach ( $block_element_sub_element['states'] as $instance_state_id => $instance_state_info ) {

							$actual_instance_id = $block_element_sub_element['id'] . '-block-' . $block['id'] . '-state-' . $instance_state_id;
							$instance_state_properties = HeadwayElementsData::get_special_element_properties(array(
								'element' => $block_element_sub_element['id'], 
								'se_type' => 'instance', 
								'se_meta' => $actual_instance_id
							));

							/* Only add instance state if there are properties present */
							if ( empty($instance_state_properties) )
								continue;

							$styling[$actual_instance_id] = array(
								'element' => $block_element_sub_element['id'],
								'properties' => $instance_state_properties 
							);

						}

					}
				/* End getting instance states */

			}

			return $styling;

		}


	public static function get_blocks_by_wrapper($layout_id, $wrapper_id) {

		$layout_blocks = self::get_blocks_by_layout($layout_id);
		$layout_wrappers = HeadwayWrappers::get_layout_wrappers($layout_id);
		$wrapper_blocks = array();

		foreach ( $layout_blocks as $block_id => $block ) {

			if ( headway_get('wrapper', $block, HeadwayWrappers::$default_wrapper_id) === $wrapper_id )
				$wrapper_blocks[$block_id] = $block;

			/* If there's only one wrapper and the block does not have a proper ID or is default, move it to that wrapper */
			if ( count($layout_wrappers) === 1 && (headway_get('wrapper', $block) === null || headway_get('wrapper', $block) == 'wrapper-default') )
				$wrapper_blocks[$block_id] = $block;

		}

		return $wrapper_blocks;

	}
	
	
	public static function get_blocks_by_type($type = false) {
				
		//Get all blocks from DB
		$blocks_by_type = self::schema_blocks_by_type();
		
		//If no type, then return it all
		if ( !$type )
			return $blocks_by_type;
			
		return ( isset($blocks_by_type[$type]) ) ? $blocks_by_type[$type] : null;
		
	}
	
	
	public static function get_all_blocks() {
				
		//Get a list of layouts with blocks
		if ( !($block_by_layout = self::schema_blocks_by_layout()) )
			return false;
		
		$blocks = array();
				
		//Go through and get every layout then get the blocks for that layout and add them to the $blocks array
		foreach ( $block_by_layout as $layout => $unused_block_ids ) {
			
			$added_blocks = self::get_blocks_by_layout($layout);
			
			//Loop through the blocks and put in the layout ID
			foreach ( $added_blocks as $block_id => $block )
				$added_blocks[$block_id]['layout'] = $layout;
			
			//Add blocks to existing array
			$blocks = array_merge($blocks, $added_blocks);
			
		}
		
		return $blocks;
		
	}
	
	
	public static function get_block_name($block) {
		
		$block = self::get_block($block);
	
		//Create the default name by using the block type and ID
		$default_name = HeadwayBlocks::block_type_nice($block['type']) . ' #' . $block['id'];
		
		return headway_get('alias', $block['settings'], $default_name);
		
	}
	
	
	public static function get_block_width($block) {
		
		$block = self::get_block($block);
			
		$block_grid_width = headway_get('width', $block['dimensions'], null);
		
		if ( $block_grid_width === null )
			return null;

		/* Fetch the wrapper that way we can get its Grid settings */
			$wrapper = HeadwayWrappers::get_wrapper(headway_get('wrapper', $block, 'wrapper-default'));

		$column_width = headway_get('use-independent-grid', $wrapper) ? headway_get('column-width', $wrapper) : HeadwayWrappers::$global_grid_column_width;
		$gutter_width = headway_get('use-independent-grid', $wrapper) ? headway_get('gutter-width', $wrapper) : HeadwayWrappers::$global_grid_gutter_width;
			
		return ( $block_grid_width * ($column_width + $gutter_width) ) - $gutter_width;
			
	}
	
	
	public static function get_block_height($block) {
		
		$block = self::get_block($block);
			
		$block_grid_height = headway_get('height', $block['dimensions'], null);
		
		if ( $block_grid_height === null )
			return null;
			
		return $block_grid_height;
		
	}
	

	public static function get_block_setting($block, $setting, $default = null) {
		
		$block = self::get_block($block);
			
		//No block, no settings
		if ( !$block )
			return $default;
			
		if ( !isset($block['settings'][$setting]) )
			return $default;
			
		return headway_fix_data_type($block['settings'][$setting]);
		
	}
	
	
	public static function get_available_block_id($block_id_blacklist = array(), $use_block_id_cache = true) {
		
		$id = 1;
		
		while ( self::block_exists($id, $use_block_id_cache) || in_array((string)$id, $block_id_blacklist) ) {
			
			$id++;
			
		}
		
		return $id;
		
	}

	
	public static function is_block_mirrored($block, $return_block_id = false) {
		
		$block = self::get_block($block);
								
		if ( $block && $mirrored_block_id = headway_get('mirror-block', $block['settings']) ) {

			$mirrored_block = self::block_exists($mirrored_block_id) ? self::get_block($mirrored_block_id) : false;

			if ( !$mirrored_block )
				return false;

			/* Insure that the block being mirrored is the same type of block */
				if ( headway_get('type', $mirrored_block) != headway_get('type', $block) )
					return false;

			/* Make sure that the mirrored block isn't mirroring another block */
				$possible_mirror_of_mirror = headway_get('mirror-block', $mirrored_block['settings']);

				if ( $possible_mirror_of_mirror && $mirror_of_mirror_block = self::get_block($possible_mirror_of_mirror) )
					if ( headway_get('type', $mirror_of_mirror_block) == headway_get('type', $mirrored_block) ) 
						return false;				
				
			return $return_block_id ? $mirrored_block['id'] : $mirrored_block;
			
		}
		
		return false;
		
	}

	
	public static function block_exists($id, $use_cache = false) {
		
		$blocks_by_id = self::schema_blocks_by_id($use_cache);
		
		return isset($blocks_by_id[$id]);
		
	}
	
	
}