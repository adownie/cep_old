
/* ------------------------- */
/* -----Element Styling----- */
/* ------------------------- */
<?php
$query = headway_get_element_styles();
$elements = headway_elements_merged();

foreach($query as $value){
	$styling[$value['element']][$value['property']] = $value['value'];
}

foreach($styling as $selector => $properties){	
	$i++;
	
	$selector = ($elements[headway_form_name_to_selector($selector)][5]) ? $elements[headway_form_name_to_selector($selector)][5] : $elements[headway_form_name_to_selector($selector)][0];
	
	if(!$selector) continue;
	
	echo $selector.' {';
	
	foreach($properties as $property => $value){
		$tab = (count($properties) != 1) ? "\n\t" : ' ';
				
		if($property == 'background') $property = 'background-color';
		
		if($property == 'border') $property = 'border-color';
		if($property == 'top-border') $property = 'border-top-color';
		if($property == 'right-border') $property = 'border-right-color';
		if($property == 'bottom-border') $property = 'border-bottom-color';
		if($property == 'left-border') $property = 'border-left-color';
		
		if($property == 'border-width') $property = 'border-width';
		if($property == 'top-border-width') $property = 'border-top-width';
		if($property == 'right-border-width') $property = 'border-right-width';
		if($property == 'bottom-border-width') $property = 'border-bottom-width';
		if($property == 'left-border-width') $property = 'border-left-width';

		
		if($selector == 'ul.navigation li a, ul.navigation li ul' && $property == 'border-right-width') $property = 'border-width';
		if($selector == 'ul.navigation li a, ul.navigation li ul' && $property == 'border-right-color') $property = 'border-color';
		
		
		if($property == 'line-height' || $property == 'font-size') $value = $value.'px';		
		if(strpos($property, '-width')) $value = $value.'px';
		

		if(strlen($value) == 6 && $value != 'normal' && $property != 'line-height') $value = '#'.$value;
		
		echo (!$no_echo[$value]) ? $tab.$property.':'.$value.'; ' : NULL;
	}
	echo '}';
	
	if($i != count($styling)) echo "\n\n";
}