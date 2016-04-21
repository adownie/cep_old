<?php
class HeadwayMaintenance {
	
	
	/**
	 * Over time, there may be issues to be corrected between updates or naming conventions to be changed between updates.
	 * All of that will be processed here.
	 **/
	public static function db_upgrade($db_version) {
		
		/* Pre-3.0.3 */
			if ( version_compare($db_version, '3.0.3', '<') ) {
				
				self::fix_serialization_in_db();
				self::repair_blocks();
				
			}

		/**
		 * Pre-3.2.3
		 * 
		 * Change the old wrapper-horizontal-padding and wrapper-vertical-padding to design editor values
		 **/
			if ( version_compare($db_version, '3.2.3', '<') ) {

				$horizontal_padding = HeadwayOption::get('wrapper-horizontal-padding', 'general', 15);
				$vertical_padding = HeadwayOption::get('wrapper-vertical-padding', 'general', 15);

				HeadwayElementsData::set_property('structure', 'wrapper', 'padding-top', $vertical_padding);
				HeadwayElementsData::set_property('structure', 'wrapper', 'padding-bottom', $vertical_padding);

				HeadwayElementsData::set_property('structure', 'wrapper', 'padding-left', $horizontal_padding);
				HeadwayElementsData::set_property('structure', 'wrapper', 'padding-right', $horizontal_padding);

			}

		/**
		 * Pre-3.4
		 * 
		 * - Change block and wrapper margins to Design Editor values
		 * - Convert Media blocks to Slider or Embed blocks
		 **/
			if ( version_compare($db_version, '3.4', '<') ) {

				/* Change block and wrapper margins to Design Editor values */
					HeadwayElementsData::set_property('structure', 'wrapper', 'margin-top', HeadwayOption::get('wrapper-top-margin', 'general', 30));
					HeadwayElementsData::set_property('structure', 'wrapper', 'margin-bottom', HeadwayOption::get('wrapper-bottom-margin', 'general', 30));

					HeadwayElementsData::set_property('default-elements', 'default-block', 'margin-bottom', HeadwayOption::get('block-bottom-margin', 'general', 10));

				/* Convert Media blocks to Slider or Embed blocks */
					$media_blocks = HeadwayBlocksData::get_blocks_by_type('media');

					if ( is_array($media_blocks) && count($media_blocks) ) {

						foreach ( $media_blocks as $media_block_id => $media_block_layout_id ) {

							$media_block = HeadwayBlocksData::get_block($media_block_id);

							$media_block_mode = headway_get('mode', $media_block['settings'], 'embed');

							switch ( $media_block_mode ) {

								case 'embed':

									HeadwayBlocksData::update_block($media_block['layout'], $media_block['id'], array(
										'type' => 'embed'
									));

								break;

								case 'image-rotator':

									$slider_images = array();

									foreach ( headway_get('images', $media_block['settings'], array()) as $media_block_image ) {

										$slider_images[] = array(
											'image' => $media_block_image, 
											'image-description' => null, 
											'image-hyperlink' => null
										);
										
									}

									HeadwayBlocksData::update_block($media_block['layout'], $media_block['id'], array(
										'type' => 'slider',
										'settings' => array(
											'images' => $slider_images
										)
									));

								break;

							}

						} 

					}

			}


		/**
		 * Pre-3.6
		 * 
		 * - Merge all design settings into the one option
		 **/
			if ( version_compare($db_version, '3.6', '<') ) {

				HeadwayElementsData::upgrade_to_36_data_scheme();

			}


		/** 
		 * 3.6.1
		 *
		 * Do 3.6 design conversion if the Headway 3.6 design options is the same as the default.  This is to fix the bad 3.6 upgrade bug
		 **/
			if ( version_compare($db_version, '3.6.1', '<') ) {

				if ( HeadwayOption::$current_skin == HEADWAY_DEFAULT_SKIN && HeadwaySkinOption::get('properties', 'design', array()) == HeadwayElementsData::get_default_data() ) {

					$combined_design_settings = array();

					//Fetch all options in wp_options and get old Headway design options
					foreach ( wp_load_alloptions() as $option => $option_value ) {
									
						if ( strpos($option, 'headway_option_group_design-editor-group') !== 0 )
							continue;

						$combined_design_settings = array_merge($combined_design_settings, get_option($option));

					}

					if ( !empty($combined_design_settings) ) {

						HeadwaySkinOption::set('properties', $combined_design_settings, 'design');

						HeadwayElementsData::merge_default_design_data(HeadwayElementsData::get_default_data(), 'core-361-upgrade-fix');
					
					}

				}

			}


		/* Add action to flush caches */
		do_action('headway_db_upgrade');
		
		/* Update the version here. */
		$headway_settings = get_option('headway', array('version' => 0));
		$headway_settings['version'] = HEADWAY_VERSION;

		update_option('headway', $headway_settings);
		
		return true;
		
	}
	
	
	/**
	 * This will remove all of the funky serialized strings that were other serialized strings in the database.
	 * 
	 * The main reason for fixing this was to insure compatibility with BackupBuddy migrations.
	 **/
	public static function fix_serialization_in_db() {
		
		//Fetch all options in wp_options and fix the Headway-specific options
		foreach ( wp_load_alloptions() as $option => $option_value ) {
						
			//Make sure the option is one to be removed.  
			//This if statement is incredibly important and must not be tampered with and needs to be triple-checked if changed.
			if ( strpos($option, 'headway_option_') === false && strpos($option, 'headway_layout_options_') === false )
				continue;
							
			//If the option isn't an array for some reason, skip it.	
			if ( !is_serialized($option_value) )
				continue;
				
			$option_value = unserialize($option_value);
							
			$fixed_option_value = array_map(array(__CLASS__, 'fix_serialization_in_db_callback'), $option_value);
			
			update_option($option, $fixed_option_value);
			
		}
		
		return true;
		
	}
	
	
		/**
		 * Used in conjunction with the method above.  This is the callback for the array_map reference.
		 * 
		 * Note: The is a self-referencing/looping function.
		 **/
		public static function fix_serialization_in_db_callback($value) {
		
			//Unserialized the serialized strings when it loops back into this function
			if ( is_serialized($value) )
				return unserialize($value);
		
			//Handle arrays	
			if ( is_array($value) )
				return array_map(array(__CLASS__, 'fix_serialization_in_db_callback'), $value);
		
			return $value;
		
		}
	
	
	/**
	 * For some reason, the 'blocks-by-id', 'blocks-by-type', and 'blocks-by-layout' options become blank.  This will restore them.
	 **/
	public static function repair_blocks() {

		global $wpdb;
				
		/* Build layout options catalog */
			$catalog = array();

			foreach ( wp_load_alloptions() as $option => $option_value ) {
							
				if ( $option == 'headway_layout_options_catalog' || (strpos($option, 'headway_') === 0 && substr($option, -8) == '_preview') ) 
					continue;

				if ( strpos(HeadwayOption::format_wp_option($option), HeadwayOption::format_wp_option('headway_layout_options_')) !== 0 )
					continue;

				$catalog[] = str_replace(HeadwayOption::format_wp_option('headway_layout_options_'), '', $option);
				
			}

		/* Set up blank arrays */
		$blocks_by_id = array();
		$blocks_by_type = array();
		$blocks_by_layout = array();
		
		foreach ( $catalog as $layout ) {

			/* If the layout is numeric, then check if the post even exists and isn't a revision.  If it does not exist or is a revision, delete it! */
			if ( is_numeric($layout) ) {

				$post_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $layout));

				if ( $post_row )
					$post_status = get_post_status($layout);

				/* If the post row is false (doesn't exist) or post status is revision (AKA inherit) then delete the whole layout option group */
				if ( !$post_row || $post_status == 'inherit' ) {
					delete_option(HeadwayOption::format_wp_option('headway_layout_options_' . $layout));
					continue;
				}

			}
			
			$layout_options = get_option(HeadwayOption::format_wp_option('headway_layout_options_' . $layout));		
						
			//If there are no blocks, then skip the layout
			if ( !isset($layout_options['general']['blocks']) || !is_array($layout_options['general']['blocks']) )
				continue;

			/* If the layout ID is template then change the underscore to a hyphen */
			if ( strpos($layout, 'template_') === 0 )
				$layout = str_replace('template_', 'template-', $layout);
								
			$layout_blocks = $layout_options['general']['blocks'];
										
			//If the layout is a template, then skip these two conditionals
			if ( strpos($layout, 'template') !== 0 ) {
								
				//If the layout doesn't have any blocks, then remove the customized flag if it exists.			
				if ( !isset($layout_blocks) || !is_array($layout_blocks) || count($layout_blocks) === 0 ) {

					HeadwaySkinLayoutOption::delete($layout, 'customized');

					continue;

				}

				//If the layout isn't customized and doesn't have a template assigned, 
				//then nuke those blocks from the layout options and do not include them in the main block options
				if ( 
					(!isset($layout_options['general']['customized']) || $layout_options['general']['customized'] !== 'true')
					&& (!isset($layout_options['general']['template']) || $layout_options['general']['template'] === 'false')
				) {

					HeadwaySkinLayoutOption::delete($layout, 'blocks');

					continue;

				}
				
			}
			
			foreach ( $layout_blocks as $block_id => $block ) {
								
				/* Blocks by ID */
				$blocks_by_id[$block['id']] = array(
					'layout' => $layout,
					'type' => $block['type']
				);
				
				/* Blocks by type */
				if ( !isset($blocks_by_type[$block['type']]) )
					$blocks_by_type[$block['type']] = array();
				
				$blocks_by_type[$block['type']][$block['id']] = $layout;
				
				/* Blocks by layout */
				if ( !isset($blocks_by_layout[$layout]) )
					$blocks_by_layout[$layout] = array();
					
				$blocks_by_layout[$layout][$block['id']] = true;
				
			}
						
		}
		
		HeadwaySkinOption::set('blocks-by-type', $blocks_by_type, 'blocks');
		HeadwaySkinOption::set('blocks-by-id', $blocks_by_id, 'blocks');
		HeadwaySkinOption::set('blocks-by-layout', $blocks_by_layout, 'blocks');

		return true;		
				
	}	

	
}