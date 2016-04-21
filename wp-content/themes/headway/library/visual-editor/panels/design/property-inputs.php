<?php
class HeadwayPropertyInputs {
	
	
	public static function display($element, $special_element_type = false, $special_element_meta = false, $data, $data_without_defaults) {
						
		if ( !is_array($element) || empty($element['properties']) )
			return null;

		$default_box_args = array(
			'group' => false,
			'element' => $element,
			'special_element_type' => $special_element_type,
			'special_element_meta' => $special_element_meta,
			'selective_properties' => false,
			'property_values' => $data,
			'property_values_excluding_defaults' => $data_without_defaults
		);
				
		/*  Format $element['properties'] into an easier array to work with and then make it alphabetical */
			$property_groups = array();

			foreach ( $element['properties'] as $key => $value ) {

				if ( is_numeric($key) ) {
					$property_groups[$value] = false;
				} else {
					$property_groups[$key] = $value;
				}

			}

		/* Include nudging and margin for all elements except for Body */
			if ( !(!empty($element['disallow-nudging']) && headway_fix_data_type($element['disallow-nudging']) === true) && !in_array('nudging', $element['properties']) ) {

				$property_groups['nudging'] = false;
				$property_groups['margins'] = false;

			}

		/* Change 'rounded-corners' to 'corners' if it exists */
			if ( isset($property_groups['rounded-corners']) ) {

				$property_groups['corners'] = $property_groups['rounded-corners'];
				unset($property_groups['rounded-corners']);

			}

		/* Sort property groups */
			ksort($property_groups);
			
		/* Display the property groups registered to the element.  */			
			$property_group_row_i = 0;

			foreach ( $property_groups as $group => $selective_properties ) {

				/* Possibly open property group row */
					if ( $property_group_row_i % 3 === 0 ) {
						echo '<div class="property-group-row">';
						$property_group_row_open = true;
					}

					$property_group_row_i++;

				/* Display the box */
					self::box(array_merge($default_box_args, array(
						'group' => $group,
						'selective_properties' => $selective_properties
					)));

				/* Close property group row if necessary */
					if ( $property_group_row_i % 3 === 0 || ($property_group_row_open && key(array_slice($property_groups, -1, 1, true)) == $group ) ) {
						echo '</div><!-- .property-group-row -->';
						unset($property_group_row_open);
					}
							
			} 	
		
	}
	
	
	public static function box($args) {
		
		$defaults = array(
			'group' => null,
			'element' => null,
			'special_element_type' => false,
			'special_element_meta' => false,
			'selective_properties' => false,
			'property_values' => false,
			'property_values_excluding_defaults' => false,
			'unsaved_values' => false
		);
		
		$args = array_merge($defaults, $args);
		$args['group_nice'] = ucwords(str_replace('-', ' ', $args['group']));

		//If the group doesn't exist, don't attempt to display it
		if ( !($properties = HeadwayElementProperties::get_properties_by_group($args['group_nice'])) )
			return false;
			
		$args['selector'] = isset($args['element']['selector']) ? $args['element']['selector'] : null;

		/* Custom behaviors for special element types */
			switch ( $args['special_element_type'] ) {
				
				case 'instance':

					$instances = headway_get('instances', $args['element']);
					$instance = $instances[$args['special_element_meta']];
				
					$args['selector'] = $instance['selector'];

				break;
				
				case 'state':

					$states = headway_get('states', $args['element']);
					$state = $states[$args['special_element_meta']];
				
					$args['selector'] = $state['selector'];

				break;


				case 'layout':

					if ( isset($args['element']['selector']) && isset($args['special_element_meta']) ) {

						$args['selector'] = 'body.layout-using-' . $args['special_element_meta'] . ' ' . $args['element']['selector'];

						if ( $args['element']['selector'] == 'body' )
							$args['selector'] = str_replace(' body', '', $args['selector']);

					}

				break;
				
			} 

		/* Set customized box class flag */
			$customized_box_class = '';
			$property_box_title = '';

			foreach ( $args['property_values_excluding_defaults'] as $property_id => $property_value ) {

				if ( !isset($properties[$property_id]) )
					continue;

				$customized_box_class = ' design-editor-box-customized';
				$property_box_title = ' title="' . __('You have customized a property in this property group.', 'headway') . '"';

				break;

			}

		/* Create the box */
			echo '<div class="design-editor-box design-editor-box-' . $args['group'] . $customized_box_class . '">';
				echo '<span class="design-editor-box-title"' . $property_box_title . '><span>' . $args['group_nice'] . '</span></span>';
					
				echo '<ul class="design-editor-box-content">';
				
					foreach ( $properties as $property_id => $property_options ) {
						
						//If the $selective_properties variable is set, then make sure we're only showing those properties.
						if ( is_array($args['selective_properties']) )
							if ( !in_array($property_id, $args['selective_properties']) )
								continue;

						if ( !headway_get('display', $property_options, true) )
							continue;

						if ( $property_options['type'] != 'box-model' ) {

							self::build_property_input($property_id, $property_options, $args);

							continue;

						}

						/* Handle box model inputs differently from the rest of the property inputs */							
							echo '<div class="box-model-inputs-container">';

								if ( headway_get('name', $property_options) )
									echo '<strong class="box-model-inputs-heading">' . $property_options['name'] . '</strong>';

								echo '<div class="box-model-inputs box-model-inputs-position-' . headway_get('position', $property_options, 'sides') . '">';

									foreach ( $property_options['box-model-inputs'] as $box_modal_input_id ) {

										/* Do not show wrapper-left and wrapper-right if it's a block or wrapper */										
											if ( ($args['element']['inherit-location'] == 'default-block' || $args['element']['id'] == 'wrapper') && in_array($box_modal_input_id, array('margin-left', 'margin-right')) )
												continue;

										$box_modal_input_options['lockable'] = true;
										self::build_property_input($box_modal_input_id, $properties[$box_modal_input_id], $args);

									}

									echo '<span class="design-editor-lock-sides" data-locked="false"></span>';

								echo '</div><!-- .box-model-inputs -->';

							echo '</div><!-- .box-model-inputs-container -->';
						/* End box model input handling */

					}
					
				echo '</ul><!-- .design-editor-box-content -->';
			
			echo '</div><!-- .design-editor-box -->';
		/* End box creation */
		
	}


		public static function build_property_input($property_id, $property_options, $element_args) {

			//Make sure the input type for the property really exists
			if ( !is_callable(array(__CLASS__, 'input_' . str_replace('-', '_', $property_options['type']))) )
				return false;
			
			/* Get the value of the property */
				$original_property_value = headway_fix_data_type(headway_get($property_id, $element_args['property_values']));

				if ( ($original_property_value || $original_property_value === 0) && strtolower($original_property_value) !== 'delete' ) {
					
					$property_options['value'] = $element_args['property_values'][$property_id];
					$property_options['customized'] = true;
					
				//If the value isn't set try to get the inherit location value, if not, revert clear back to the default property type value
				} else {
																	
					$property_default = isset($property_options['default']) ? $property_options['default'] : null;
					$property_options['value'] = HeadwayElementsData::get_inherited_property($element_args['element']['id'], $property_id, $property_default);
					$property_options['customized'] = false;
																		
				}	

			/* Set up elements and attributes */
				$uncustomize_button = $element_args['special_element_type'] != 'default' ? '<span class="uncustomize-property tooltip" title="Delete this customization."></span>' : null;
				$customize_button = $element_args['special_element_type'] != 'default' ? '<div class="customize-property"><span class="tooltip" title="Click to change the value for this property.  If left uncustomized, the property will automatically inherit to the default set for this element type in the defaults tab or the parent element if editing a state, instance, or layout-specific element.">Customize</span></div>' : null;

				$hidden_input_attributes_array = array(
					'type' => 'hidden',
					'class' => 'property-hidden-input',
					'value' => $property_options['value'],
					'element' => $element_args['element']['id'],
					'property' => $property_id,
					'special_element_type' => $element_args['special_element_type'],
					'special_element_meta' => $element_args['special_element_meta'],
					'element_selector' => esc_attr(stripslashes($element_args['selector'])),
					'callback' => esc_attr('(function(params){' . $property_options['js-callback'] . '})')
				);
									

				/* Turn attributes array into a string for HTML */
					$hidden_input_attributes = '';

					foreach ( $hidden_input_attributes_array as $attribute => $attribute_value )
						$hidden_input_attributes .= $attribute . '="' . $attribute_value . '" ';

					$hidden_input_attributes = trim($hidden_input_attributes);
							
			/* Set up attributes */
				$property_title = '';
				$property_classes = array(
					'design-editor-property-' . $property_id
				);;

				if ( $property_options['customized'] ) {

					$property_classes[] = 'customized-property-by-user';
					$property_title = ' title="' . __('You have customized this property.', 'headway') . '"';

				} else if ( $element_args['special_element_type'] !== 'default' ) {

					$property_classes[] = 'uncustomized-property';

				}

			/* add a locked class if it's a lockable element only */
				if ( headway_get('lockable', $property_options) )
					$property_classes[] = 'lockable-property';

			echo '<li data-property-id="' . $property_id . '" class="' . implode(' ', array_filter($property_classes)) . '"' . $property_title . '>';
			
				echo '<strong><span class="property-label">' . $property_options['name'] . '</span>' . (!headway_get('lockable', $property_options) ? $uncustomize_button : null) . '</strong>';
				echo '<div class="property-' . $property_options['type'] . ' property">';
												
					echo (headway_get('lockable', $property_options)) ? $uncustomize_button : null; /* Uncustomize button needs to be in different location for box model input s*/

					call_user_func(array(__CLASS__, 'input_' . str_replace('-', '_', $property_options['type'])), $property_options, $property_id);
					
					echo '<input ' . $hidden_input_attributes . ' />';
					
				echo '</div>';
				
				echo $customize_button; 
				
			echo '</li>';
			

		}
	
	
	public static function input_integer($options, $id) {
		
		$unit = headway_get('unit', $options) ? '<span class="unit">' . headway_get('unit', $options) . '</span>' : null;

		echo '<input type="text" value="' . $options['value'] . '" />' . $unit;	
						
	}
	
	
	public static function input_color($options, $id) {
				
		echo '
		<div class="colorpicker-box-container">
			<div class="colorpicker-box-transparency"></div>
			<div class="colorpicker-box" style="background-color:' . headway_format_color($options['value']) . ';"></div>
		</div><!-- .colorpicker-box-container -->
		';
		
	}
	
	
	public static function input_select($options, $id) {
		
		echo '<div class="select-container"><select>';
						
			//If 'options' is a function, then call it and replace $options['options']
			if ( is_string($options['options']) && strpos($options['options'], '()') !== false ) {
				
				$sanitized_function = str_replace('()', '', $options['options']);
				
				//If is a method rather than function, the method must be declared as static otherwise it'll return false on PHP 5.2
				if ( !is_callable($sanitized_function) ) 
					continue;
				
				$options['options'] = call_user_func($sanitized_function);
				
			}
			
			if ( is_array($options['options']) ) {
				
				foreach ( $options['options'] as $value => $content ) {
					
					//If it's an optgroup, handle it.
					if ( is_array($content) ) {
						
						echo '<optgroup label="' . $value . '">';
						
						foreach ( $content as $value => $text ) {
				
							//If the current option is the value in the DB, then mark it as selected
							$selected_option = ( $value == $options['value'] ) ? ' selected="selected"' : null;

							echo '<option value="' . $value . '"' . $selected_option . '>' . $text . '</option>';
							
						} 
						
						echo '</optgroup>';
						
					//Otherwise it's just a normal option
					} else {
						
						//If the current option is the value in the DB, then mark it as selected
						$selected_option = ( $value == $options['value'] ) ? ' selected="selected"' : null;

						echo '<option value="' . $value . '"' . $selected_option . '>' . $content . '</option>';
						
					}
					
				}
				
			}	
				
			
		echo '</select></div><!-- .select-container -->';
		
	}
		
	
		public static function font_size_options() {

			$font_sizes = array();

			for($i = 6; $i <= 100; $i++){
				$font_sizes[$i] = $i . 'px';
				
				if($i >= 20) $i++;						
			}			
			
			return $font_sizes;
			
		}
		
		
		public static function line_height_options() {
			
			$line_heights = array();
			
			for($i = 5; $i <= 30; $i++){
				$percent = $i*10;

				$line_heights[$percent] = $percent . '%';
			}
			
			return $line_heights;
			
		}
	
	
	public static function input_image($options, $id) {
		
		$src_visibility = ( is_string($options['value']) && strlen($options['value']) > 0 && $options['value'] != 'none' ) ? '' : ' style="display:none;"';

		$filename_parts = explode('/', $options['value']);
		$filename = end($filename_parts);
		
		echo '
			<span class="button">Choose</span>
			
			<div class="image-input-controls-container"' . $src_visibility . '>
				<span class="src">' . $filename . '</span>
				<span class="delete-image">Delete</span>
			</div>
		';
				
	}
	
	
	public static function input_checkbox($options, $id) {
		
	}
	
	
	public static function input_font_family_select($options, $id) {

		/* Output input */
			$font_fragments = explode('|', $options['value']);

			/* Web Font */
			if ( count($font_fragments) >= 2 ) {

				$font_stack = $font_fragments[1];
				$font_name = $font_fragments[1];

				$webfont_class = ' font-name-webfont';

			/* Traditional Font */
			} else {

				$font_stack = HeadwayFonts::get_stack($options['value']);
				$font_name = ucwords($options['value']);

				$webfont_class = null;

			}

			echo '<span class="font-name' . $webfont_class . '" style="font-family: ' . $font_stack . ';" data-webfont-value="' .  $options['value'] . '">' . $font_name . '</span>';

			echo '<span class="open-font-browser pencil-icon"></span>';

		/* Font Browser */
			echo '<div class="font-browser">';
					
					echo '<ul class="tabs">';
						do_action('headway_fonts_browser_tabs');
					echo '</ul>';

					do_action('headway_fonts_browser_content');

			echo '</div><!-- .font-browser -->';
				
	}
}