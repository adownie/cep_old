<?php
if(isset($_GET['leaf']) && isset($_GET['id'])){
	if(isset($_GET['get-width'])){
		do_action('headway_custom_leaf_'.$_GET['leaf'].'_options', $_GET['id'], true);
	} else {
		do_action('headway_custom_leaf_'.$_GET['leaf'].'_options', $_GET['id'], false);
	}
}

elseif($_GET['nav-item']){
	include 'navigation-items.php';
		
	navigation_item_options($_GET['nav-item'], urldecode($_GET['nav-item-name']));
}
elseif($_GET['callback']){
	if($_GET['request'] != 'leaf-sizes'){
		$font_query = headway_get_element_styles(false, 'font');
		$colors_query = headway_get_element_styles(false, 'color');
		$sizing_query = headway_get_element_styles(false, 'sizing');


		foreach($colors_query as $value){
			$colors[$value['element']][$value['property']] = $value['value'];
		}
		foreach($font_query as $value){
			$fonts[$value['element']][$value['property']] = $value['value'];
		}
		foreach($sizing_query as $value){
			$sizing[$value['element']][$value['property']] = $value['value'];
		}

		$element_styling = array(
				'colors' => $colors,
				'font' => $fonts,
				'sizing' => $sizing
		);

		echo $_GET['callback'] . '(' . headway_json_encode($element_styling) . ')';
	} else {
		$leaf = headway_get_leaf($_GET['id']);
		
		if(!$leaf['config']) $leaf['config'] = array('new-leaf' => true);
		
		echo $_GET['callback'] . '(' . headway_json_encode($leaf['config']) . ')';
	}
}
elseif($_GET['proxy']){
	$url = rawurldecode($_GET['proxy']);

	if(function_exists('curl_init')){
		$ch = curl_init();
		
		$username = headway_get_option('headway-username');
		$password = headway_get_option('headway-password');

		curl_setopt($ch, CURLOPT_URL, $url);
		if($_GET['use_auth']) curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		
		$curl_exec = curl_exec($ch);		

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200){
			$content = $curl_exec;
		} else {
			$content = '<p>Please enter a valid username and password in the <a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=headway#headway-registration">Headway configuration page</a>.</p>';
		}
		
		curl_close ($ch);
	} else {
		$content = '<p>Your web server does not support cURL (libcurl).  Please contact your web host.</p>';
	}
	
	echo $content;
}