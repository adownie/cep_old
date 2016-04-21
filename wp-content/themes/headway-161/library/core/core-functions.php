<?php
/**
 * Miscellaneous functions for Headway.
 *
 * @package Headway
 * @subpackage Core Functions
 * @author Clay Griffiths
 **/

if(function_exists('add_theme_support')){
	add_theme_support('post-thumbnails');
	add_theme_support('nav-menus');
}


/**
 * Simple function to return the feed URL.
 *
 * @return string If there's a Headway custom feed URL, then return it.  Otherwise return the WordPress rss2_url option.
 **/
function headway_rss(){
	if(headway_get_option('feed-url')) return headway_get_option('feed-url');
	return get_bloginfo('rss2_url');
}


/**
 * Starts the GZIP output buffer.
 *
 * @return void
 **/
function headway_gzip(){
	if(headway_get_option('gzip') == 1 && !headway_is_caching() && !class_exists('All_in_One_SEO_Pack')) if ( extension_loaded('zlib') ) ob_start('ob_gzhandler');
}


/**
 * Detects if the browser is Internet Explorer.  Will also check if a specific version of MSIE.
 * 
 * @param int $version
 *
 * @return bool
 **/
function is_ie($version = false){
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') && !$version) return true;
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0') && $version == 6) return true;
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0') && $version == 7) return true;
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0') && $version == 8) return true;

	
	return false;
}


/**
 * Parses PHP using eval.
 *
 * @param string $content PHP to be parsed.
 * 
 * @return mixed PHP that has been parsed.
 **/
function headway_parse_php($content){
	ob_start();
	eval("?>$content<?php ");
	$parsed = ob_get_contents();
	ob_end_clean();
	return $parsed;
}


/**
 * Builds the current URL.
 *
 * @return string
 **/
function headway_current_url(){
	$url = 'http';
	if ($_SERVER["HTTPS"] == "on") $url .= "s";
	$url .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80") {
		$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	return $url;
}


/**
 * Retrieves the Headway directory.
 * 
 * @param bool $print
 * @param bool $absolute
 *
 * @return void|string If $print, then echo, otherwise return the path.
 **/
function headway_directory($print = true, $absolute = false){
	if($print):
		echo ($absolute) ? HEADWAYROOT : get_bloginfo('template_directory');
	else:
		return ($absolute) ? HEADWAYROOT : get_bloginfo('template_directory');
	endif;
}


/**
 * Returns the current page.  Will also test if system page.
 *
 * @uses headway_get_write_box_value()
 * @uses headway_get_option()
 * 
 * @global int $pageID
 * @global object $post
 * 
 * @param bool $system_page_test If true, then test if a system page.
 * @param bool $get_real_page If true, ignore the leaf template and return the real page that is being viewed.
 * 
 * @return bool|string If $system_page_test, return a boolean value, otherwise return a string.
 **/
function headway_current_page($system_page_test = false, $get_real_page = false, $disregard_get_parameter = false){
	
	if(!isset($_GET['visual-editor-system-page']) || $disregard_get_parameter){
		
		is_home()    		? $system_page = 'index'	  : NULL;
		
		if(get_option('show_on_front') == 'posts' && is_front_page())
			$system_page = 'index';
		elseif(is_front_page())
			$system_page = get_option('page_on_front');
		
		
		is_single()    		? $system_page = 'single'	  : NULL;
		is_date()   		? $system_page = 'archives'  : NULL;
		is_tag()   			? $system_page = 'tag' 	  : NULL;
		is_category()  		? $system_page = 'category'  : NULL;
		is_author()    		? $system_page = 'author' 	  : NULL;
		is_search()    		? $system_page = 'search' 	  : NULL;
		is_404()    		? $system_page = 'four04'    : NULL;
	
		is_attachment()    	? $system_page = 'single'    : NULL;

	
		global $pageID;
		global $post;
	
	
		if($get_real_page){
			$current_page = $post->ID;
			$current_page = ($current_page && !$system_page) ? $current_page : $system_page;
		} else {
			$current_page = (headway_get_write_box_value('leaf_template', false, $post->ID) && headway_get_write_box_value('leaf_template', false, $post->ID) != 'DELETE') ? headway_get_write_box_value('leaf_template', false, $post->ID) : $post->ID;
			$current_page = (headway_get_write_box_value('leaf_system_template', false, $post->ID) && headway_get_write_box_value('leaf_system_template', false, $post->ID) != 'DELETE') ? headway_get_write_box_value('leaf_system_template', false, $post->ID) : $current_page;
			$current_page = ($current_page && !$system_page) ? $current_page : $system_page;
			$current_page = ($system_page && headway_get_option('leaf-template-system-page-'.$system_page) && headway_get_option('leaf-template-system-page-'.$system_page) != 'DELETE') ? headway_get_option('leaf-template-system-page-'.$system_page) : $current_page;
		}
	
	
		if($system_page && $system_page_test){
			return true;
		}
		elseif(!$system_page && $system_page_test){
			return false;
		} else {
			return $current_page;
		}
		
	} else {
		
		return $_GET['visual-editor-system-page'];
		
	}
}


/**
 * Displays an admin link or admin login.
 * 
 * @uses headway_get_option()
 *
 * @return void
 **/
function headway_login(){
	if(headway_get_option('show-admin-link')){
		if ( is_user_logged_in() ) {
		    echo '<a href="'.get_bloginfo('wpurl').'/wp-admin" class="footer-right" id="footer-admin-link">Administration Panel</a>';
		} else {
		    echo '<a href="'.get_bloginfo('wpurl').'/wp-admin" class="footer-right" id="footer-admin-link">Administrator Login</a>';
		}
	}
}


/**
 * Shows an edit link.
 * 
 * @global int $user_level
 *
 * @return void
 **/
function headway_edit(){
	global $user_level;
	get_currentuserinfo();
	
	if(is_page() && !is_front_page()) edit_post_link('Edit This Page', '<span class="edit-link footer-right" id="footer-edit-link">', '</span>');
	if(is_single()) edit_post_link('Edit This Post', '<span class="edit-link footer-right" id="footer-edit-link">', '</span>');
}


/**
 * Echos the Powered By Headway link.
 * 
 * @uses headway_get_option()
 *
 * @param string $text The name of the program to be displayed.  Defaults to Headway (obviously).
 * 
 * @return void
 **/
function headway_link($text = 'Headway'){
	if(strstr(html_entity_decode(headway_get_option('affiliate-link')), 'http://www.headwaythemes.com/affiliates/idevaffiliate.php')){
		$location = headway_get_option('affiliate-link');
	} elseif(is_int(headway_get_option('affiliate-link'))){
		$location = 'http://headwaythemes.com/affiliates/idevaffiliate.php?id='.headway_get_option('affiliate-link');
	}
	else
	{
		$location = 'http://www.headwaythemes.com/';	
	}
	$return = apply_filters('headway_link', '<p class="footer-left" id="footer-headway-link">Powered By <a href="'.$location.'" title="Headway Premium WordPress Theme">'.$text.'</a></p>');
	
	echo $return;
}


/**
 * Echos a simple copyright paragraph.
 *
 * @return void
 **/
function headway_copyright(){
	$copyright = (headway_get_option('custom-copyright')) ? stripslashes(headway_get_option('custom-copyright')) : 'Copyright &copy; '.date('Y').' '.get_bloginfo('name');
	
	$return = apply_filters('headway_copyright', '<p class="copyright" id="footer-copyright">'.$copyright.'</p>');
	
	echo $return;
}


/**
 * Echos a simple go to top link.
 *
 * @return void
 **/
function headway_go_to_top(){
	$return = apply_filters('headway_go_to_top', '<a href="#top" class="footer-right" id="footer-go-to-top-link">Go To Top</a>');
	
	echo $return;
}


/**
 * Checks a value to see if it's equal to on.  If so, return checked.
 *
 * @param string $value The value to be checked.
 * 
 * @see headway_checkbox_value_custom()
 * 
 * @return string|void
 **/
function headway_checkbox_value($value){
	return ($value == 'on') ? ' checked' : NULL;
}


/**
 * If the value of the checkbox is different than on, then use this function instead of headway_checkbox_value()
 * 
 * @param string $variable The desired value.
 * @param string $value Value to be checked.
 * 
 * @see headway_checkbox_value()
 *
 * @return string|void
 **/
function headway_checkbox_value_custom($variable, $value){
	return ($variable == $value) ? ' checked' : NULL;
}


/**
 * Checks two variables and if they're the same, return selected.
 * 
 * @param string $variable The desired value.
 * @param string $value Value to be checked.
 * 
 * @see headway_checkbox_value_custom()
 * @see headway_radio_value()
 *
 * @return string|void
 **/
function headway_option_value($variable, $value){
	return ($variable == $value) ? ' selected' : NULL;
}


/**
 * Checks two variables and if they're the same, return checked.
 * 
 * @param string $variable The desired value.
 * @param string $value Value to be checked.
 * 
 * @see headway_checkbox_value()
 * @see headway_option_value()
 *
 * @return string|void
 **/
function headway_radio_value($variable, $value){
	return ($variable == $value) ? ' checked' : NULL;
}


/**
 * Creates the upload folders that Headway uses.
 *
 * @return void
 **/
function headway_make_uploads_folders(){
	if (!is_dir(ABSPATH.'/wp-content/uploads')){
		if(@mkdir(ABSPATH.'/wp-content/uploads') && @chmod(ABSPATH.'/wp-content/uploads', 0777)) return true;
	}
	if (!is_dir(ABSPATH.'/wp-content/uploads/headway')){
		if(@mkdir(ABSPATH.'/wp-content/uploads/headway') && @chmod(ABSPATH.'/wp-content/uploads/headway', 0777)) return true;
	}
	if (!is_dir(ABSPATH.'/wp-content/uploads/headway/header-uploads')){
		if(@mkdir(ABSPATH.'/wp-content/uploads/headway/header-uploads') && @chmod(ABSPATH.'/wp-content/uploads/headway/header-uploads', 0777)) return true;
	}
	if (!is_dir(ABSPATH.'/wp-content/uploads/headway/background-uploads')){
		if(@mkdir(ABSPATH.'/wp-content/uploads/headway/background-uploads') && @chmod(ABSPATH.'/wp-content/uploads/headway/background-uploads', 0777)) return true;
	}
	if (!is_dir(ABSPATH.'/wp-content/uploads/headway/gallery')){
		if(@mkdir(ABSPATH.'/wp-content/uploads/headway/gallery') && @chmod(ABSPATH.'/wp-content/uploads/headway/gallery', 0777)) return true;
	}
}


/**
 * Generates the Headway upload path.
 *
 * @return string The upload path.
 **/
function headway_upload_path(){
	return '/wp-content/uploads/headway/';
}


/**
 * Returns the gallery upload path.
 * 
 * @uses headway_upload_path()
 *
 * @return string The gallery path.
 **/
function headway_gallery_dir($relative = true){
	if($relative){
		return headway_upload_path().'gallery/';
	} else {
		return str_replace('//', '/', str_replace(strstr(realpath(__FILE__), 'wp-content'), '', realpath(__FILE__)).'/wp-content/uploads/headway/').'gallery/';
	}
}


/**
 * Returns the relative path for Headway's theme directory.  This is everything after the .com (or whatever ending) of the site.
 *
 * @return string
 **/
function headway_relative_path(){
	 $site_url = 'http';
	 if ($_SERVER["HTTPS"] == "on") $page_url .= 's';
	 $site_url .= "://";
	
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $site_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	 } else {
	  $site_url .= $_SERVER["SERVER_NAME"];
	 }
	
	$theme_path = get_bloginfo('template_directory');
	
	$relative_path = str_replace($site_url, '', $theme_path);
		
	$path_to_theme = (strpos($relative_path, '/') == 0) ? substr($relative_path, 1) : $relative_path;
	
	return $path_to_theme;
}


/**
 * Similar to headway_relative_path(), but instead returns the relative path to only the website.  This will most likely be a slash.
 * 
 * @see headway_relative_path()
 *
 * @return string
 **/
function headway_relative_site_path(){
	$site_url = 'http';
	 if ($_SERVER["HTTPS"] == "on") $page_url .= 's';
	 $site_url .= "://";
	
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $site_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	 } else {
	  $site_url .= $_SERVER["SERVER_NAME"];
	 }
	
	$relative_site_path = substr(str_replace($site_url, '', get_bloginfo('template_directory')), 1);
	
	$themes = strpos($relative_site_path, '/wp-content/');
	$relative_site_path = substr($relative_site_path, 0, $themes);
	
	return $relative_site_path;
}


/**
 * Fetches the WordPress user's level.
 *
 * @return int
 **/
function headway_user_level(){
	global $user_level;
	get_currentuserinfo();
	return $user_level;
}


/**
 * Allows version numbers to be compared.  Turns version numbers into integers.  The first number is multiplied by 1000, the second is multiplied by 100, and the last is added to the previous sum. 
 *
 * @param mixed Version number to be changed to integer.
 * 
 * @return int
 **/
function headway_versionify($version){
	if($version){
		$version = explode('.', $version);
		$versionified_version = $version[0]*1000 + $version[1]*100 + $version[2];
	
		return $versionified_version;
	} else {
		return false;
	}
}


/**
 * Converts an array into a JSON string.
 * 
 * @param array $array Array to be converted.
 *
 * @return string JSON string.
 **/
function headway_json_encode($array){
	if(function_exists('json_encode')){
		return json_encode($array);
	} else {
		require_once HEADWAYLIBRARY.'/resources/json.php';
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		return $json->encode($array);
	}
}


/**
 * Converts a JSON string back to an array.
 * 
 * @param string $string JSON to be converted.
 *
 * @return array
 **/
function headway_json_decode($string){
	if(function_exists('json_decode')){
		return json_decode($string, true);
	} else {
		require_once HEADWAYLIBRARY.'/resources/json.php';
		$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		return $json->decode($string);
	}
}


/**
 * Merges arrays.
 *
 * @param array
 * 
 * @return array
 **/
function headway_json_array_fix($arrays){
	if($arrays):
		$fixArray = array();
		foreach($arrays as $array){
			if(!array_key_exists($array['name'], $fixArray)):     //Adds Support For Multi-selects, etc.
				$fixArray[$array['name']] = $array['value'];
			elseif($array['name'] == 'categories'):
				$fixArray[$array['name']] .= ' | '.$array['value'];
			endif;
			
		}
		return $fixArray;
	endif;
}


/**
 * Checks if the user can access the visual editor.
 * 
 * @uses headway_user_level()
 * @uses headway_get_option()
 *
 * @return bool
 **/
function headway_can_visually_edit(){
	
	if(current_user_can('manage_options')){
		return true;
		
	}elseif(
		   (headway_user_level() >= headway_get_option('permissions-site-configuration')) || 
		   (headway_user_level() >= headway_get_option('permissions-visual-design-editor')) || 
	   	   (headway_user_level() >= headway_get_option('permissions-leafs')) ||
		   (headway_user_level() >= headway_get_option('permissions-navigation'))
	){
			
		return true;
			
	} else {
		return false;
	}
}


/**
 * Checks if the visual editor is open.
 *
 * @uses headway_can_visually_edit
 * 
 * @return bool
 **/
function headway_visual_editor_open(){
	if($_GET['visual-editor'] && headway_can_visually_edit()){
		return true;
	} else {
		return false;
	}
}

/**
 * Checks if header image exists and will be loaded.
 *
 * @return bool
 **/
 function headway_check_header_image(){
	if(!headway_get_skin_option('disable-header-image') && headway_get_option('header-image') && headway_get_option('header-image') != 'DELETE'){
		return true;
	} else {
		return false;
	}
}


/**
 * Generates the URL for the image resizer.
 * 
 * @param string $url URL to original image.
 * @param int $w Width to resize to.
 * @param int $h Height to resize to.
 * @param int $zc Determines whether or not to zoom/crop the image.
 *
 * @return string The URL to the image.
 **/
function headway_thumbnail($url, $w = false, $h = false, $zc = 1){
	if($w && $h){
		return get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.urlencode($url).'&amp;q=90&amp;w='.$w.'&amp;h='.$h.'&amp;zc='.$zc;
	}
	elseif($w && !$h){
		return get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.urlencode($url).'&amp;q=90&amp;w='.$w.'&amp;zc='.$zc;
	}
	elseif(!$w && $h){
		return get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.urlencode($url).'&amp;q=90&amp;h='.$h.'&amp;zc='.$zc;
	}
}


/**
 * Check if W3 Total Cache or if WP Super Cache are running.
 *
 * @return bool
 **/
function headway_is_caching(){
	if(class_exists('W3_Plugin_TotalCache')){
		return true;
	} elseif(function_exists('wp_cache_manager')){
		return true;
	} else {
		return false;
	}
}


/**
 * Removes anything that's not a letter or number.  To be used as a callback function.
 *
 * @param mixed Piece of array to be filtered.
 * 
 * @return mixed
 **/
 function headway_filter_array_piece($piece){
	return preg_replace("/[^a-zA-Z0-9]/", '', $piece);
}


function headway_nav_menu_check(){
	if(function_exists('wp_get_nav_menus') && count(wp_get_nav_menus()) > 0)
		return true;
	else
		return false;
}


function headway_cache_exists($what = 'headway.css'){
	if(is_writable(HEADWAYCACHE.'/'.$what) && filesize(HEADWAYCACHE.'/'.$what) > 0)
		return true;
	else
		return false;
}

function headway_generate_cache($clear = false){
		
	if(is_writable(HEADWAYCACHE) || is_writable(HEADWAYCACHE.'/headway.css')){
		
		if($clear == false){
			$headway_css = headway_generate('headway-css');
			$leafs_css = headway_generate('leafs-css');
			$scripts_js = headway_generate('scripts');
			
			$headway_css_handle = @fopen(HEADWAYCACHE.'/headway.css', 'w');
			$leafs_css_handle = @fopen(HEADWAYCACHE.'/leafs.css', 'w');
			$scripts_handle = @fopen(HEADWAYCACHE.'/scripts.js', 'w');

			@fwrite($headway_css_handle, $headway_css);
			@fwrite($leafs_css_handle, $leafs_css);
			@fwrite($scripts_handle, $scripts_js);

			@fclose($headway_css_handle);
			@fclose($leafs_css_handle);
			@fclose($scripts_handle);
			
		} else {
			@unlink(HEADWAYCACHE.'/headway.css');
			@unlink(HEADWAYCACHE.'/leafs.css');
			@unlink(HEADWAYCACHE.'/scripts.js');
			
			$headway_css_handle = @fopen(HEADWAYCACHE.'/headway.css', 'w');
			$leafs_css_handle = @fopen(HEADWAYCACHE.'/leafs.css', 'w');
			$scripts_handle = @fopen(HEADWAYCACHE.'/scripts.js', 'w');

			@fclose($headway_css_handle);
			@fclose($leafs_css_handle);
			@fclose($scripts_handle);
		}
		
	}
	
	//If WP Super Cache is installed, then clear the cache after the visual editor is saved.
	if(function_exists('prune_super_cache')){
		global $cache_path;
		prune_super_cache( $cache_path . 'supercache/', true );
		prune_super_cache( $cache_path, true );
	}

	if(class_exists('w3_plugin_totalcache')){
		global $w3_plugin_totalcache;
	
		if(function_exists(array('w3_plugin_totalcache', 'flush_memcached'))) $w3_plugin_totalcache->flush_memcached();
	    if(function_exists(array('w3_plugin_totalcache', 'flush_opcode'))) $w3_plugin_totalcache->flush_opcode();
	    if(function_exists(array('w3_plugin_totalcache', 'flush_file'))) $w3_plugin_totalcache->flush_file();
	}
	
	headway_update_option('css-last-updated', mktime());
}


/**
 * Alias for headway_generate_cache for easier understanding.
 * 
 * @@uses headway_generate_cache()
 **/
function headway_clear_cache(){
	headway_generate_cache(true);
}