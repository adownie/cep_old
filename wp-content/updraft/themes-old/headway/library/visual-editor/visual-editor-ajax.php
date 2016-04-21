<?php
class HeadwayVisualEditorAJAX {


	private static function json_encode($data) {

		header('content-type:application/json');

		if ( headway_get('callback') )
			echo headway_get('callback') . '(';

		echo json_encode($data);

		if ( headway_get('callback') )
			echo ')';

	}


	/* Skin methods */
	public static function secure_method_switch_skin() {

		if ( HeadwayOption::set('current-skin', headway_post('skin')) ) {

			do_action('headway_switch_skin');

			HeadwayOption::$current_skin = headway_post('skin');

			self::json_encode(array(
				'live-css' => HeadwaySkinOption::get('live-css'),
				'columns' => HeadwaySkinOption::get('columns', 'general', HeadwayWrappers::$default_columns),
				'column-width' => HeadwaySkinOption::get('column-width', 'general', HeadwayWrappers::$default_column_width),
				'gutter-width' => HeadwaySkinOption::get('gutter-width', 'general', HeadwayWrappers::$default_gutter_width)
			));

		}

	}

	public static function secure_method_delete_skin() {

		$skin_to_delete = headway_post('skin');

		if ( $skin_to_delete == HeadwayOption::get('current-skin') || $skin_to_delete == 'base' ) {
			echo 'error: cannot delete current template';
			return;
		}

		/* Loop through WordPress options and delete the skin options */
			foreach ( wp_load_alloptions() as $option => $option_value ) {
							
				if ( strpos($option, 'headway_|skin=' . $skin_to_delete . '|_') !== 0 )
					continue;

				delete_option($option);
				
			}

		/* Remove the skin from the Headway skins catalog */
			HeadwayOption::delete($skin_to_delete, 'skins');

		echo 'success';

	}

	public static function secure_method_add_blank_skin() {

		$blank_skin_name = headway_post('skinName');

		if ( empty($blank_skin_name) )
			return;

		$original_skin_id = strtolower(str_replace(' ', '-', $blank_skin_name));

		$skin_id = $original_skin_id;
		$skin_name = $blank_skin_name;

		$skin_unique_id_counter = 0;

		/* Check if skin already exists.  If it does, change ID and skin name */
			while ( HeadwayOption::get($skin_id, 'skins') ) {

				$skin_unique_id_counter++;
				$skin_id = $original_skin_id . '-' . $skin_unique_id_counter;
				$skin_name = $blank_skin_name . ' ' . $skin_unique_id_counter;

			}

			$skin['id'] = $skin_id;
			$skin['name'] = $skin_name;

		/* Send skin to DB */
			HeadwayOption::set($skin['id'], $skin, 'skins');

		self::json_encode($skin);

	}


	/* Saving methods */
	public static function secure_method_save_options() {

		//Set up options
		parse_str(headway_post('options'), $options);

		if ( HeadwayVisualEditor::save($options) )
			echo 'success';

	}


	/* Layout Selector */
	public static function method_get_layout_selector_pages() {

		$pages = HeadwayVisualEditorDisplay::list_pages();

		echo trim(str_replace(array("\n", "\t"), '', $pages));

	}


	public static function method_get_layout_selector_templates() {

		$templates = HeadwayVisualEditorDisplay::list_templates();

		echo trim(str_replace(array("\n", "\t"), '', $templates));

	}


	/* Block methods */
	public static function method_get_available_block_id() {

		$block_id_blacklist = headway_post('block_id_blacklist', array());

		echo HeadwayBlocksData::get_available_block_id($block_id_blacklist);

	}


	public static function method_get_available_block_id_batch() {

		$block_id_blacklist = headway_post('block_id_blacklist', array());
		$number_of_ids = headway_post('number_of_ids', 10);

		if ( !is_numeric($number_of_ids) )
			$number_of_ids = 10;

		$block_ids = array();

		for ( $i = 1; $i <= $number_of_ids; $i++ ) {

			$available_block_id = HeadwayBlocksData::get_available_block_id($block_id_blacklist);

			$block_ids[] = $available_block_id;
			$block_id_blacklist[] = $available_block_id;

		}

		self::json_encode($block_ids);

	}


	public static function method_get_layout_blocks_in_json() {

		$layout = headway_post('layout', false);
		$layout_status = HeadwayLayout::get_status($layout);

		if ( $layout_status['customized'] != true )
			return false;

		self::json_encode(array(
			'blocks' => HeadwayBlocksData::get_blocks_by_layout($layout, true),
			'wrappers' => HeadwayWrappers::get_layout_wrappers($layout, true)
		));

	}


	public static function method_load_block_content() {

		/* Check for grid safe mode */
			if ( HeadwayOption::get('grid-safe-mode', false, false) ) {

				echo '<div class="alert alert-red block-safe-mode"><p>Grid Safe mode enabled.  Block content not outputted.</p></div>';

				return;

			}

		/* Go */
		$layout = headway_post('layout');
		$block_origin = headway_post('block_origin');
		$block_default = headway_post('block_default', false);

		$unsaved_block_settings = headway_post('unsaved_block_settings', false);

		/* If the block origin is a string or ID, then get the object from DB. */
		if ( is_numeric($block_origin) || is_string($block_origin) )
			$block = HeadwayBlocksData::get_block($block_origin);

		/* Otherwise use the object */
		else
			$block = $block_origin;

		/* If the block doesn't exist, then use the default as the origin.  If the default doesn't exist... We're screwed. */
		if ( !$block && $block_default )
			$block = $block_default;

		/* If the block settings is an array, merge that into the origin.  But first, make sure the settings exists for the origin. */
		if ( !isset($block['settings']) )
			$block['settings'] = array();

		if ( is_array($unsaved_block_settings) && count($unsaved_block_settings) && isset($unsaved_block_settings['settings']) ) {

			$block = headway_array_merge_recursive_simple($block, $unsaved_block_settings);

		}

		/* If the block is set to mirror, then get that block. */
		if ( $mirrored_block = HeadwayBlocksData::is_block_mirrored($block) ) {

			$original_block = $block;

			$block = $mirrored_block;
			$block['original'] = $original_block;

		}

		/* Add a flag into the block so we can check if this is coming from the visual editor. */
		$block['ve-live-content-query'] = true;

		/* Show the content */
		do_action('headway_block_content_' . $block['type'], $block);

		/* Output dynamic JS and CSS */
			if ( headway_post('mode') != 'grid' ) {

				$block_types = HeadwayBlocks::get_block_types();

				/* Dynamic CSS */
					if ( method_exists($block_types[$block['type']]['class'], 'dynamic_css') ) {

						echo '<style type="text/css">';
							echo call_user_func(array($block_types[$block['type']]['class'], 'dynamic_css'), $block['id'], $block);
						echo '</style><!-- AJAX Block Content Dynamic CSS -->';

					}

				/* Run enqueue action and print right away */
					if ( method_exists($block_types[$block['type']]['class'], 'enqueue_action') ) {

						/* Remove all other enqueued scripts to reduce conflicts */
							global $wp_scripts;
							$wp_scripts = null;
							remove_all_actions('wp_print_scripts');

						/* Remove all other enqueued styles to reduce conflicts */
							global $wp_styles;
							$wp_styles = null;
							remove_all_actions('wp_print_styles');

						echo call_user_func(array($block_types[$block['type']]['class'], 'enqueue_action'), $block['id'], $block);
						wp_print_scripts();
						wp_print_footer_scripts(); /* This isn't really needed, but it's here for juju power */

					}

				/* Output dynamic JS */
					if ( method_exists($block_types[$block['type']]['class'], 'dynamic_js') ) {

						echo '<script type="text/javascript">';
							echo call_user_func(array($block_types[$block['type']]['class'], 'dynamic_js'), $block['id'], $block);
						echo '</script><!-- AJAX Block Content Dynamic JS -->';

					}

			}
		/* End outputting dynamic JS and CSS */

	}


	public static function method_load_block_options() {

		$layout = headway_post('layout');
		$block_id = headway_post('block_id');
		$unsaved_options = headway_post('unsaved_block_options', array());

		$block = HeadwayBlocksData::get_block($block_id);

		//If block is new, set the bare basics up
		if ( !$block ) {

			$block = array(
				'type' => headway_post('block_type'),
				'new' => true,
				'id' => $block_id,
				'layout' => $layout
			);

		}

		/* Merge unsaved options in */
		if ( is_array($unsaved_options) )
			$block['settings'] = is_array(headway_get('settings', $block)) ? array_merge($block['settings'], $unsaved_options) : $unsaved_options;

		do_action('headway_block_options_' . $block['type'], $block, $layout);

	}


	/* Wrapper Methods */
	public static function method_load_wrapper_options() {

		$layout_id = headway_post('layout');
		$wrapper_id = headway_post('wrapper_id');
		$unsaved_options = headway_post('unsaved_wrapper_options', array());

		$wrapper = HeadwayWrappers::get_wrapper($wrapper_id, $layout_id);

		/* Merge unsaved options in */
			if ( is_array($unsaved_options) )
				$wrapper = array_merge($wrapper, $unsaved_options);

		do_action('headway_wrapper_options', $wrapper, $layout_id);

	}


	/* Box methods */
	public static function method_load_box_ajax_content() {

		$layout = headway_post('layout');
		$box_id = headway_post('box_id');

		do_action('headway_visual_editor_ajax_box_content_' . $box_id);

	}


	/* Layout methods */
	public static function method_get_layout_name() {

		$layout = headway_post('layout');

		echo HeadwayLayout::get_name($layout);

	}


	public static function secure_method_revert_layout() {

		$layout = headway_post('layout_to_revert');

		//Delete wrappers, blocks, design settings
		HeadwayLayout::delete_layout($layout);

		do_action('headway_visual_editor_reset_layout');

		echo 'success';

	}


	/* Design editor methods */
	public static function method_get_element_inputs() {

		$element = headway_post('element');
		$special_element_type = headway_post('specialElementType', false);
		$special_element_meta = headway_post('specialElementMeta', false);
		$group = $element['group'];

		$unsaved_values = headway_post('unsavedValues', false);

		/* Make sure that the library is loaded */
		Headway::load('visual-editor/panels/design/property-inputs');

		/* Get values */
			if ( !$special_element_type && !$special_element_meta ) {

				$property_values = HeadwayElementsData::get_element_properties($element['id']);
				$property_values_excluding_defaults = HeadwayElementsData::get_element_properties($element['id'], true);

			} else {

				$property_values_args = array(
					'element' => $element['id'],
					'se_type' => $special_element_type,
					'se_meta' => $special_element_meta
				);

				$property_values = HeadwayElementsData::get_special_element_properties($property_values_args);
				$property_values_excluding_defaults = HeadwayElementsData::get_special_element_properties(array_merge($property_values_args, array('exclude_default_data' => true)));

			}

		/* Merge in the unsaved values */
			$property_values = is_array($unsaved_values) ? array_merge($property_values, $unsaved_values) : $property_values;
			$property_values_excluding_defaults = is_array($unsaved_values) ? array_merge($property_values_excluding_defaults, $unsaved_values) : $property_values_excluding_defaults;

		/* Display the appropriate inputs and values depending on the element */
		HeadwayPropertyInputs::display($element, $special_element_type, $special_element_meta, $property_values, $property_values_excluding_defaults);

	}


	public static function method_get_design_editor_elements() {

		$current_layout = headway_post('layout');
		$all_elements = HeadwayElementAPI::get_all_elements();
		$groups = HeadwayElementAPI::get_groups();

		$customized_element_data = HeadwayElementsData::get_all_elements();

		$elements = array('groups' => $groups);

		/* Assemble the arrays */
		foreach ( $all_elements as $element_id => $element_settings ) {

			$inherit_location = HeadwayElementAPI::get_element(HeadwayElementAPI::get_inherit_location($element_id));

			$elements[$element_id] = array(
				'selector' => $element_settings['selector'],
				'id' => $element_settings['id'],
				'parent' => headway_get('parent', $element_settings),
				'name' => $element_settings['name'],
				'description' => headway_get('description', $element_settings),
				'properties' => $element_settings['properties'],
				'group' => $element_settings['group'],
				'states' => headway_get('states', $element_settings, array()),
				'instances' => headway_get('instances', $element_settings, array()),
				'disallow-nudging' => headway_get('disallow-nudging', $element_settings, false),
				'inherit-location' => headway_get('id', $inherit_location),
				'inspectable' => headway_get('inspectable', $element_settings),
				'customized' => isset($customized_element_data[$element_settings['id']]) ? true : false
			);

			/* Loop through main element instances and add customized flag if necessary */
				foreach ( $elements[$element_id]['instances'] as $element_instance_id => $element_instance_settings ) {

					if ( isset($customized_element_data[$element_settings['id']]['special-element-instance'][$element_instance_id]) )
						$elements[$element_id]['instances'][$element_instance_id]['customized'] = true;

				}

		}

		/* Spit it all out */
		self::json_encode($elements);

	}


	public static function method_get_design_editor_element_data() {

		self::json_encode(HeadwayElementsData::get_all_elements(true));

	}


	/* Template methods */
	public static function secure_method_add_template() {

		//Send the template ID back to JavaScript so it can be added to the list
		self::json_encode(HeadwayLayout::add_template(headway_post('template_name')));

	}


	public static function secure_method_delete_template() {

		//Retreive templates
		$templates = HeadwaySkinOption::get('list', 'templates', array());

		//Unset the deleted ID
		$id = headway_post('template_to_delete');

		//Delete template if it exists and send array back to DB
		if ( isset($templates[$id]) ) {

			unset($templates[$id]);

			//Delete blocks, wrappers, DE settings for current skin
			HeadwayLayout::delete_layout('template-' . $id);

			//Delete template from templates list
			HeadwaySkinOption::set('list', $templates, 'templates');

			do_action('headway_visual_editor_delete_template');

			echo 'success';

		} else {

			echo 'failure';

		}

	}


	public static function secure_method_assign_template() {

		$layout = headway_post('layout');
		$template = str_replace('template-', '', headway_post('template'));

		//Add the template flag
		HeadwaySkinLayoutOption::set($layout, 'template', $template);

		//Add template flag to global template assignments for easier skin import/export
			$template_assignments = HeadwaySkinOption::get('assignments', 'templates', array());
			$template_assignments[$layout] = $template;

			HeadwaySkinOption::set('assignments', $template_assignments, 'templates');

		do_action('headway_visual_editor_assign_template');

		echo HeadwayLayout::get_name('template-' . $template);

	}


	public static function secure_method_remove_template_from_layout() {

		$layout = headway_post('layout');

		//Remove the template flag
		if ( !HeadwaySkinLayoutOption::set($layout, 'template', false) ) {
			echo 'failure';

			return;
		}

		if ( HeadwaySkinLayoutOption::get($layout, 'customized', false) === true ) {
			echo 'customized';

			return;
		}

		//Remove template flag from global template assignments for easier skin import/export
			$template_assignments = HeadwaySkinOption::get('assignments', 'templates', array());
			unset($template_assignments[$layout]);

			HeadwaySkinOption::set('assignments', $template_assignments, 'templates');

		do_action('headway_visual_editor_unassign_template');

		echo 'success';

	}


	/* Micellaneous methods */
	public static function method_clear_cache() {

		if ( HeadwayCompiler::flush_cache(true) && HeadwayBlocks::clear_block_actions_cache() )
			echo 'success';
		else
			echo 'failure';

	}


	public static function method_ran_tour() {

		$mode = headway_post('mode');

		HeadwayOption::set('ran-tour-' . $mode, true);

	}


	public static function method_fonts_list() {

		return do_action('headway_fonts_ajax_list_fonts_' . headway_post('provider'));

	}


	public static function secure_method_redactor_upload_image() {

		/* Insure that file is image */
			if ( strpos($_FILES['file']['type'], 'image') !== 0 )
				return false;

		/* Use wp_handle_upload() */
			/* Add this in to make wp_handle_upload pass validation */
			$_POST['action'] = 'headway_visual_editor';

			$upload = wp_handle_upload($_FILES['file'], array(
				'action' => 'headway_visual_editor'
			));

			if ( isset($upload['error']) ) {
				return false;
			}

		/* Send URL back to VE */
		self::json_encode(array(
			'filelink' => $upload['url']
		));	

	}


	/* Data Portability */
		/* General Data Portability */
			public static function method_import_image() {

				Headway::load('data/data-portability');

				/* Set up variables */
					$image_id = headway_post('imageID');
					$image_contents = headway_post('imageContents');

				/* Sideload image */
					self::json_encode(HeadwayDataPortability::decode_image_to_uploads($image_contents['base64_contents']));

			}


				public static function replace_imported_images_variables($import_array) {

					/* Check for imported images */
						if ( empty($import_array['imported-images']) || !is_array($import_array['imported-images']) )
							return $import_array;

					/* Replace image variables in the import file */
						foreach ( $import_array['imported-images'] as $imported_image_id => $imported_image ) {

							if ( headway_get('url', $imported_image) ) {

								$import_array = self::replace_imported_images_variables_recurse($imported_image_id, $imported_image['url'], $import_array);

							/* Change erred image variable to point to a 404 image */
							} else {

								$import_array = self::replace_imported_images_variables_recurse($imported_image_id, 'IMAGE_NOT_UPLOADED', $import_array);

							}

						}

					return $import_array;

				}

				public static function replace_imported_images_variables_recurse($variable, $replace, $array) {

					if ( !is_array($array) )
						return str_replace($variable, $replace, $array);

					$processed_array = array();

					foreach ( $array as $key => $value )
						$processed_array[$key] = self::replace_imported_images_variables_recurse($variable, $replace, $value);

					return $processed_array;

				}


		/* Skin Portability */
			public static function method_export_skin() {

				Headway::load('data/data-portability');

				parse_str(headway_get('skin-info'), $skin_info);

				return HeadwayDataPortability::export_skin($skin_info['skin-export-info']);

			}


			public static function method_install_skin() {

				Headway::load('data/data-portability');

				$skin_data = json_decode(stripslashes(headway_post('skin')), true);

				if ( !is_array($skin_data) ) {
					return self::json_encode(array(
						'error' => 'Could not install template.'
					));
				}

				$skin = self::replace_imported_images_variables($skin_data);

				return self::json_encode(HeadwayDataPortability::install_skin($skin));

			}


		/* Layout Portability */
			public static function method_export_layout() {

				Headway::load('data/data-portability');

				$layout = headway_get('layout', false);

				return HeadwayDataPortability::export_layout($layout);

			}


		/* Block Settings Portability */
			public static function method_export_block_settings() {

				Headway::load('data/data-portability');

				return HeadwayDataPortability::export_block_settings(headway_get('block-id'));

			}


}