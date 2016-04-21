<?php
function headway_create_element_inputs($display, $array){
	foreach($array as $group => $elements){
		foreach($elements as $element){
			$nice_id = headway_selector_to_form_name($element[0]);
			
			switch($display){
				case 'colors':				
					$return .= '<table id="colors-'.$nice_id.'" class="colors-inputs" style="display: none;">';
					
					$color_input_count = 1;

					foreach($element[2] as $color){
						$english_color = ucwords(str_replace('-', ' ', $color));
						$property = $color;
						
						$color_input_count++;
						$class = ($color_input_count%2) ? NULL : ' class="alt"';
						
						$return .= '<tr'.$class.'>
										<th scope="row"><label for="color-'.$nice_id.'-'.$property.'">'.$english_color.'</th>

										<td>
											#<input type="text" class="headway-visual-editor-color-input color-text '.$property.'" size="6" maxlength="6" value="'.headway_get_element_property('color', $nice_id, $property).'" id="color-'.$nice_id.'-'.$property.'" name="color['.$nice_id.']['.$property.']" />';

						if(strpos($color, 'border') !== false) 
							$return .=	'&nbsp;<input type="text" class="headway-visual-editor-border-input border-width '.$property.'" size="2" maxlength="2" value="'.headway_get_element_property('sizing', $nice_id, $property.'-width').'" id="width-'.$nice_id.'-'.$property.'" name="width['.$nice_id.']['.$property.'-width]" />px';

						$return .= '</td>
								</tr>';
					}

					$return .= '</table>';
				break;
					
				case 'fonts':
					if($element[3] || $element[4]){
						$return .= '<table id="fonts-'.$nice_id.'" class="fonts-inputs" style="display: none;">';
						
						if($element[3]){
							
							global $headway_custom_fonts;

							if($headway_custom_fonts){
								$custom_fonts = '<optgroup label="Custom Fonts">'."\n";
								foreach($headway_custom_fonts as $label => $stack){
									$stack = addslashes(str_replace('"', '\'', $stack));
									$custom_fonts .= '<option value="'.$stack.'"'.headway_option_value($stack, headway_get_element_property('font', $nice_id, 'font-family')).'>'.$label.'</option>'."\n"; 
								}
								$custom_fonts .= "\n".'</optgroup>';
								
								$custom_fonts_separator = '<option value=""></option>';
							}
					
					
							for($i = 6; $i <= 52; $i++){
								$font_size_options[$nice_id] .= '<option value="'.$i.'"'.headway_option_value($i, headway_get_element_property('font', $nice_id, 'font-size')).'>'.$i.'px</option>';
								$line_height_options[$nice_id] .= '<option value="'.$i.'"'.headway_option_value($i, headway_get_element_property('font', $nice_id, 'line-height')).'>'.$i.'px</option>';		
								
								if($i >= 20) $i++;						
							}							
					
							$return .= '<tr class="alt">
								<th scope="row"><label for="fonts-'.$nice_id.'-font-family">Font/Typeface</th>
								<td>
									<select id="font-'.$nice_id.'-font-family" name="fonts['.$nice_id.'][font-family]" class="font-select font-family headway-visual-editor-font-input">
										<optgroup label="Serif Fonts">
											<option value="georgia, serif"'.headway_option_value('georgia, serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Georgia</option>
											<option value="times, serif"'.headway_option_value('times, serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Times</option>
											<option value="times new roman, serif"'.headway_option_value('times new roman, serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Times New Roman</option>
											<option value=""></option>
										</optgroup>
										<optgroup label="Sans-Serif Fonts">
											<option value="arial, sans-serif"'.headway_option_value('arial, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Arial</option>
											<option value="\'arial black\', sans-serif"'.headway_option_value('\'arial black\', sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Arial Black</option>
											<option value="\'arial narrow\', sans-serif"'.headway_option_value('\'arial narrow\', sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Arial Narrow</option>
											<option value="courier, monospace"'.headway_option_value('courier, monospace', headway_get_element_property('font', $nice_id, 'font-family')).'>Courier</option>
											<option value="courier new, monospace"'.headway_option_value('courier new, monospace', headway_get_element_property('font', $nice_id, 'font-family')).'>Courier New</option>
											<option value="gill sans, sans-serif"'.headway_option_value('gill sans, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Gill Sans</option>
											<option value="helvetica, sans-serif"'.headway_option_value('helvetica, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Helvetica</option>
											<option value="lucida grande, sans-serif"'.headway_option_value('lucida grande, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Lucida Grande</option>
											<option value="tahoma, sans-serif"'.headway_option_value('tahoma, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Tahoma</option>
											<option value="trebuchet ms, sans-serif"'.headway_option_value('trebuchet ms, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Trebuchet MS</option>
											<option value="verdana, sans-serif"'.headway_option_value('verdana, sans-serif', headway_get_element_property('font', $nice_id, 'font-family')).'>Verdana</option>
											'.$custom_fonts_separator.'
										</optgroup>
										'.$custom_fonts.'
									</select>
								</td>
							</tr>
							
							<tr>
								<th scope="row"><label for="fonts-'.$nice_id.'-font-size">Font Size</th>
								<td>
									<select id="font-'.$nice_id.'-font-size" name="fonts['.$nice_id.'][font-size]" class="font-select font-size headway-visual-editor-font-input">
											'.$font_size_options[$nice_id].'
									</select>
								</td>
							</tr>
							
							
							<tr class="alt">
								<th scope="row"><label for="fonts-'.$nice_id.'-line-height">Line Height</th>
								<td>
									<select id="font-'.$nice_id.'-line-height" name="fonts['.$nice_id.'][line-height]" class="font-select line-height headway-visual-editor-font-input">
											'.$line_height_options[$nice_id].'
									</select>
								</td>
							</tr>';
							
							if($element[4]){
								
								
								$return .= '<tr class="additional-font-properties">
									<th scope="row"><label for="fonts-'.$nice_id.'-font-weight">Font Weight</th>
									<td>
										<input id="font-'.$nice_id.'-font-weight-hidden" type="hidden" value="normal" class="headway-visual-editor-font-input" name="fonts['.$nice_id.'][font-weight]" />
										<input id="font-'.$nice_id.'-font-weight" type="checkbox" value="bold" name="fonts['.$nice_id.'][font-weight]" class="headway-visual-editor-font-input font-check font-weight"'.headway_checkbox_value_custom('bold', headway_get_element_property('font', $nice_id, 'font-weight')).' />
										<label for="font-'.$nice_id.'-font-weight" class="font-check-label">Bold Text</option>
									</td>
								</tr>


								<tr class="additional-font-properties alt">
									<th scope="row"><label for="fonts-'.$nice_id.'-text-transform">Text Transform</th>
									<td>
										<select id="font-'.$nice_id.'-text-transform" name="fonts['.$nice_id.'][text-transform]" class="font-select text-transform headway-visual-editor-font-input">
												<option value="none"'.headway_option_value('none', headway_get_element_property('font', $nice_id, 'text-transform')).'>None</option>
												<option value="uppercase"'.headway_option_value('uppercase', headway_get_element_property('font', $nice_id, 'text-transform')).'>Uppercase</option>
												<option value="lowercase"'.headway_option_value('lowercase', headway_get_element_property('font', $nice_id, 'text-transform')).'>Lowercase</option>
										</select>
									</td>
								</tr>


								<tr class="additional-font-properties">
									<th scope="row"><label for="fonts-'.$nice_id.'-font-variant">Font Variant</th>
									<td>
										<input id="font-'.$nice_id.'-font-variant-hidden" type="hidden" class="headway-visual-editor-font-input" value="normal" name="fonts['.$nice_id.'][font-variant]" />
										<input id="font-'.$nice_id.'-font-variant" type="checkbox" value="small-caps" name="fonts['.$nice_id.'][font-variant]" class="headway-visual-editor-font-input font-check font-variant"'.headway_checkbox_value_custom('small-caps', headway_get_element_property('font', $nice_id, 'font-variant')).' />
										<label for="font-'.$nice_id.'-font-variant" class="font-check-label">Small-caps</option>
									</td>
								</tr>


								<tr class="additional-font-properties alt">
									<th scope="row"><label for="fonts-'.$nice_id.'-letter-spacing">Letter Spacing</th>
									<td>
										<select id="font-'.$nice_id.'-letter-spacing" name="fonts['.$nice_id.'][letter-spacing]" class="font-select letter-spacing headway-visual-editor-font-input">
												<option value="0px"'.headway_option_value('0px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>None</option>
												<option value="1px"'.headway_option_value('1px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>1px</option>
												<option value="2px"'.headway_option_value('2px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>2px</option>
												<option value="3px"'.headway_option_value('3px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>3px</option>
												<option value="4px"'.headway_option_value('4px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>4px</option>
												<option value="-1px"'.headway_option_value('-1px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>-1px</option>
												<option value="-2px"'.headway_option_value('-2px', headway_get_element_property('font', $nice_id, 'letter-spacing')).'>-2px</option>
										</select>
									</td>
								</tr>';
							}
							
							
						}
						
						$return .= '</table>';
					}
					
				break;
			}
			
		}
	}
	
	return $return;
}