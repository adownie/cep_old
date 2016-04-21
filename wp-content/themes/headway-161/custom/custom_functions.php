<?php
/*
Store all of your custom functions, actions, and so on in this file.

For more on hooks go here: http://headwaythemes.com/documentation/customizing-your-headway-site/using-hooks/

**Here are examples of an action and filter.**

function an_example_action_function(){
	echo 'This will echo something.';
}
add_action('some_action', 'an_example_action_function');


function an_example_filter_function($content){
	return $content;
}
add_filter('some_filter', 'an_example_filter_function');


///////////////////////////////

function add_custom_stuff(){
    //Add a custom element to be styled with the visual editor.
	headway_add_custom_element(array('selector' => 'div#footer a:hover', 'name' => 'Footer &mdash; Hyperlinks (Hover)', 'color_options' => array('color'), 'fonts' => true));
	
	//Add two custom font families to be used by the visual editor.
	headway_add_custom_font('Futura', 'Futura, "Century Gothic", AppleGothic, sans-serif');
	headway_add_custom_font('Geneva', 'Lucida Sans, "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif');
}
add_action('init', 'add_custom_stuff');

*/