<?php
class HeadwayDataPortability {


	public static function export_skin(array $info) {

		do_action('headway_before_export_skin');

		$skin = array(
			'name' => $info['name'],
			'author' => $info['author'],
			'image-url' => $info['image-url'],
			'version' => $info['version'],
			'element-data' => HeadwayElementsData::get_all_elements(),
			'live-css' => HeadwaySkinOption::get('live-css'),
			'layouts' => array(),
			'templates' => HeadwaySkinOption::get_group('templates'),
			'wrapper-defaults' => array(
				'columns' => HeadwaySkinOption::get('columns', false, HeadwayWrappers::$default_columns),
				'column-width' => HeadwaySkinOption::get('column-width', false, HeadwayWrappers::$default_column_width),
				'gutter-width' => HeadwaySkinOption::get('gutter-width', false, HeadwayWrappers::$default_gutter_width)
			)
		);

		/* Get layout blocks and wrappers */
			foreach ( HeadwayBlocksData::schema_blocks_by_layout() as $layout_id => $layout_block_ids ) {

				if ( empty($layout_block_ids) )
					continue;

				$skin['layouts'][$layout_id] = array(
					'blocks' => array(),
					'wrappers' => HeadwayWrappers::get_layout_wrappers($layout_id)
				);

				foreach ( array_keys($layout_block_ids) as $layout_block_id ) {
					$skin['layouts'][$layout_id]['blocks'][$layout_block_id] = HeadwayBlocksData::get_block($layout_block_id);
				}

			}

		/* Spit the file out */
		return self::to_json('Headway Template - ' . $info['name'] . ' ' . $info['version'], 'skin', $skin);

	}


	public static function install_skin(array $skin) {

		$skins = HeadwayOption::get_group('skins');

		/* Remove image definitions */
			if ( isset($skin['image-definitions']) )
				unset($skin['image-definitions']);

		/* Skin ID */
			$original_skin_id = strtolower(str_replace(' ', '-', $skin['name']));

			$skin_id = $original_skin_id;
			$skin_name = $skin['name'];

			$skin_unique_id_counter = 0;

		/* Check if skin already exists.  If it does, change ID and skin name */
			while ( HeadwayOption::get($skin_id, 'skins') || get_option('headway_|skin=' . $skin_id . '|_option_group_blocks') ) {

				$skin_unique_id_counter++;
				$skin_id = $original_skin_id . '-' . $skin_unique_id_counter;

				$skin_name = $skin['name'] . ' ' . $skin_unique_id_counter;

			}

			$skin['id'] = $skin_id;
			$skin['name'] = $skin_name;

		/* Send skin to DB */
			HeadwayOption::set($skin['id'], $skin, 'skins');

		/* Change current skin ID to the newly added skin so we can populate data */
			HeadwayOption::$current_skin = $skin['id'];
			HeadwayLayoutOption::$current_skin = $skin['id'];

		/* Set up skin options that way when it's activated it looks right */
			HeadwaySkinOption::set('properties', $skin['element-data'], 'design');
			HeadwaySkinOption::set('live-css', stripslashes($skin['live-css']));

			/* Install templates */
			if ( $skin_templates = headway_get('templates', $skin) )
				HeadwaySkinOption::set_group('templates', $skin_templates);

				/* Assign templates */
					if ( !empty($skin['templates']['assignments']) ) {

						foreach ( $skin['templates']['assignments'] as $layout_id => $template_id )
							HeadwaySkinLayoutOption::set($layout_id, 'template', $template_id);

					}

			/* Install layouts (blocks, wrappers, and flags */
			foreach ( $skin['layouts'] as $layout_id => $layout_data ) {

				/* Set statuses */
					HeadwaySkinLayoutOption::set($layout_id, 'customized', true);

				/* Install Wrappers */
					foreach ( $layout_data['wrappers'] as $wrapper_id => $wrapper_data ) {
						HeadwayWrappers::add_wrapper($layout_id, $wrapper_data, true);
					}

				/* Install Blocks */
					foreach ( $layout_data['blocks'] as $block_id => $block_data ) {
						HeadwayBlocksData::add_block($layout_id, $block_data);
					}

			}

		/* Set merge flag that way the next time they save it won't screw up the styling */
			HeadwaySkinOption::set('merged-default-design-data-core', true, 'general');

		/* Set wrapper defaults */
			if ( !empty($skin['wrapper-defaults']) && is_array($skin['wrapper-defaults']) ) {

				HeadwaySkinOption::set('columns', headway_get('columns', $skin['wrapper-defaults'], HeadwayWrappers::$default_columns));
				HeadwaySkinOption::set('column-width', headway_get('column-width', $skin['wrapper-defaults'], HeadwayWrappers::$default_column_width));
				HeadwaySkinOption::set('gutter-width', headway_get('gutter-width', $skin['wrapper-defaults'], HeadwayWrappers::$default_gutter_width));

			}

		/* Change $current_skin back just to be safe */
			HeadwayOption::$current_skin = HeadwayOption::get('current-skin', 'general', HEADWAY_DEFAULT_SKIN);
			HeadwayLayoutOption::$current_skin = HeadwayOption::get('current-skin', 'general', HEADWAY_DEFAULT_SKIN);

		return $skin;

	}


	public static function export_block_settings($block_id) {

		/* Set up variables */
			$block = HeadwayBlocksData::get_block($block_id);

		/* Check if block exists */
			if ( !$block )
				die('Error: Could not export block settings.');

		/* Spit the file out */
			return self::to_json('Block Settings - ' . HeadwayBlocksData::get_block_name($block), 'block-settings', array(
				'id' => $block_id,
				'type' => $block['type'],
				'settings' => $block['settings'],
				'styling' => HeadwayBlocksData::get_block_styling($block)
			));

	}


	public static function export_layout($layout_id) {

		/* Set up variables */
			if ( !$layout_name = HeadwayLayout::get_name($layout_id) )
				die('Error: Invalid layout.');

			$layout = array(
				'name' => $layout_name,
				'blocks' => HeadwayBlocksData::get_blocks_by_layout($layout_id)
			);

		/* Convert all mirrored blocks into original blocks by pulling their mirror target's settings */
			/* Loop through each block in the template and check if it's mirrored.  If it is, replace it with the block that it's mirroring */
			foreach ( $layout['blocks'] as $layout_block_index => $layout_block ) {

				if ( !$mirrored_block = HeadwayBlocksData::is_block_mirrored($layout_block) )
					continue;

				$layout['blocks'][$layout_block_index] = $mirrored_block;

			}

		/* Spit the file out */
		return self::to_json('Headway Layout - ' . $layout_name, 'layout', $layout);

	}


	/**
	 * Convert array to JSON file and force download.
	 *
	 * Images will be converted to base64 via HeadwayDataPortability::encode_images()
	 **/
	public static function to_json($filename, $data_type = null, $array) {

		if ( !$array['data-type'] = $data_type )
			die('Missing data type for HeadwayDataPortability::to_json()');

		$array['image-definitions'] = self::encode_images($array);

		header('Content-Disposition: attachment; filename="' . $filename . '.json"');
		header('Content-Type: application/json');
		header('Pragma: no-cache');

		echo json_encode($array);

	}


		/**
		 * Convert all images to base64.
		 *
		 * This method is recursive.
		 **/
		public static function encode_images(&$array, $images = null) {

			if ( !$images )
				$images = array();

			foreach ( $array as $key => $value ) {

				if ( is_array($value) ) {

					$images = array_merge($images, self::encode_images($array[$key], $images));
					continue;

				} else if ( !is_serialized($value) && is_string($value) ) {

					$image_matches = array();

					/* PREG_SET_ORDER makes the $image_matches array make more sense */
					preg_match_all('/([a-z\-_0-9\/\:\.]*\.(jpg|jpeg|png|gif))/i', $value, $image_matches, PREG_SET_ORDER);

					/* Go through each image in the string and download it then base64 encode it and replace the URL with variable */
					foreach ( $image_matches as $image_match ) {

						if ( !count($image_match) )
							continue;

						$image_path = $image_match[0];
						$image_url = $image_match[0];

						/* If the image is missing any type of forward slash then it's not relative or absolute and just a filename so do not do anything with it */
						if ( strpos($image_path, '/') === false ) {
							continue;
						}

						/* If the image is missing HTTP then it's probably a relative path and we can try to load it from this site */
						if ( strpos($image_path, 'http') !== 0 ) {
							$image_url = 'http://' . str_replace('//', '/', $_SERVER['SERVER_NAME'] . '/' . $image_path);
						}

						$image_request = wp_remote_get($image_url, array(
							'timeout' => 10
						));

						if ( $image_request && $image_contents = wp_remote_retrieve_body($image_request) ) {

							$image = array(
								'base64_contents' => base64_encode($image_contents),
								'mime_type' => $image_request['headers']['content-type']
							);

							/* Add base64 encoded image to image definitions. */
								/* Make sure that the image isn't already in the definitions.  If it is, $possible_duplicate will be the key/ID to the image */
								if ( !$possible_duplicate = array_search($image, $images) )
									$images['%%IMAGE_REPLACEMENT_' . (count($images) + 1) . '%%'] = $image;

							/* Replace the URL with variable that way it can be replaced with uploaded image on import.  If $possible_duplicate isn't null/false, then use it! */
								$variable = $possible_duplicate ? $possible_duplicate : '%%IMAGE_REPLACEMENT_' . (count($images)) . '%%';
								$array[$key] = str_replace($image_path, $variable, $array[$key]);

						}

					}

				}

			}

			return $images;

		}


	/**
	 * Convert base64 encoded image into a file and move it to proper WP uploads directory.
	 **/
	public static function decode_image_to_uploads($base64_string) {

		/* Make sure user has permissions to edit in the Visual Editor */
			if ( !HeadwayCapabilities::can_user_visually_edit() )
				return;

		/* Create a temporary file and decode the base64 encoded image into it */
			$temporary_file = wp_tempnam();
			file_put_contents($temporary_file, base64_decode($base64_string));

		/* Use wp_check_filetype_and_ext() to figure out the real mimetype of the image.  Provide a bogus extension and then we'll use the 'proper_filename' later. */
			$filename = 'headway-imported-image.jpg';
			$file_information = wp_check_filetype_and_ext($temporary_file, $filename);

		/* Construct $file array which is similar to a PHP $_FILES array.  This array must be a variable since wp_handle_sideload() requires a variable reference argument. */
			if ( headway_get('proper_filename', $file_information) )
				$filename = $file_information['proper_filename'];

			$file = array(
				'name' => $filename,
				'tmp_name' => $temporary_file
			);

		/* Let WordPress move the image and spit out the file path, URL, etc.  Set test_form to false that way it doesn't verify $_POST['action'] */
			$upload = wp_handle_sideload($file, array('test_form' => false));

			/* If there's an error, be sure to unlink/delete the temporary file in case wp_handle_sideload() doesn't. */
			if ( isset($upload['error']) )
				@unlink($temporary_file);

			return $upload;

	}


}