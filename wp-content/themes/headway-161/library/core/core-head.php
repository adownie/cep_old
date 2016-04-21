<?php
/**
 * Content to be displayed in the <head> of the site.
 * 
 * @package Headway
 * @subpackage Site Output
 * @author Clay Griffiths
 */


/**
 * Displays the title.  Parses the variables.
 * 
 * @param bool $print Whether or not to echo the title. 
 *
 * @return string|void
 **/
function headway_title( $print = true ){
	
	$tagline = get_option('blogdescription');
	$blogname = get_option('blogname');
	$page = get_the_title();
	$category_description = category_description();
	$category = single_cat_title('', false);
	$tag = single_tag_title('', false);
	
	if ( is_day() ) :
		$archive = get_the_time(get_option('date_format'));
 	elseif ( is_month() ) :
		$archive = get_the_time('F Y');
	elseif ( is_year() ) : 
		$archive = get_the_time('Y');
    endif; 

	$postname = get_the_title();
	$search = get_search_query();
	
	
	if(get_query_var('author_name')) :
		$authordata = get_userdatabylogin(get_query_var('author_name'));
	else :
		$authordata = get_userdata(get_query_var('author'));
	endif;
	$author_name = $authordata->display_name;
	$author_description = $authordata->user_description;
	
	
	if(is_home() && get_option('page_for_posts') != get_option('page_on_front')):
		// If statement to get rid of pipe character for folks with no tagline.
		
		if(headway_get_option('title-posts-page') == '%tagline% | %blogname%' && !$tagline){
			$title = '%blogname%';
		} else {
			$title = headway_get_option('title-posts-page');
		}
		
	elseif(is_front_page() && get_option('page_for_posts') != get_option('page_on_front')):
		// If statement to get rid of pipe character for folks with no tagline.
		
		if(headway_get_option('title-home') == '%tagline% | %blogname%' && !$tagline){
			$title = '%blogname%';
		} else {
			$title = headway_get_option('title-home');
		}
		
	elseif(is_home() || is_front_page()):
		// If statement to get rid of pipe character for folks with no tagline.
	
		if(headway_get_option('title-home') == '%tagline% | %blogname%' && !$tagline){
			$title = '%blogname%';
		} else {
			$title = headway_get_option('title-home');
		}
		
	elseif(is_single()):
		
		global $post;
	
		if(get_post_meta($post->ID, 'title', true) && !headway_get_write_box_value('title')){
			$title = stripslashes(get_post_meta($post->ID, 'title', true));
		}
		elseif(headway_get_write_box_value('title')){
			$title = stripslashes(headway_get_write_box_value('title'));
		}
		else
		{	
			$title = headway_get_option('title-single');
			$title = str_replace('%postname%', $postname, $title);
		}
		
		
	elseif(is_page()):
		global $post;
	
		if(get_post_meta($post->ID, 'title', true) && !headway_get_write_box_value('title')){
			$title = stripslashes(get_post_meta($post->ID, 'title', true));
		}
		elseif(headway_get_write_box_value('title')){
			$title = stripslashes(headway_get_write_box_value('title'));
		}
		else
		{	
			$title = headway_get_option('title-page');
			$title = str_replace('%page%', $page, $title);
		}
		
		
	elseif(is_category()):
		$title = headway_get_option('title-category');
		$title = str_replace('%category_description%', $category_description, $title);
		$title = str_replace('%category%', $category, $title);
		
	elseif(is_404()):
		$title = headway_get_option('title-404');
		
	elseif(is_date()):
		$title = headway_get_option('title-archives');
		$title = str_replace('%archive%', $archive, $title);
		
	elseif(is_tag()):
		$title = headway_get_option('title-tag');
		$title = str_replace('%tag%', $tag, $title);
		
	elseif(is_search()):
		$title = headway_get_option('title-search');
		$title = str_replace('%search%', $search, $title);
		
	elseif(is_author()):
		$title = headway_get_option('title-author-archives');
		$title = str_replace('%author_name%', $author_name, $title);
		$title = str_replace('%author_description%', $author_description, $title);
	endif;
	
	
	
	$title = str_replace('%tagline%', $tagline, $title);
	$title = str_replace('%blogname%', $blogname, $title);
	
	
	if(!$print):
		return $title;
	else: 
		echo $title;
	endif;

}


/**
 * Builds the meta for the <head>. 
 **/
function headway_meta(){
	global $post;
	
	if((is_home() && headway_get_option('home-keywords')) || (is_front_page() && headway_get_option('home-keywords'))){
		$meta = "\n".'<meta name="keywords" content="'.headway_get_option('home-keywords').'" />';
	} else {
		
		
		if(headway_get_write_box_value('keywords')):
			$keywords = explode(',', headway_get_write_box_value('keywords'));
		else:
			$keywords = array();
		endif;
		
		
		if(get_post_meta($post->ID, 'thesis_keywords', true)){
			global $post;
			array_push($keywords, explode(',', get_post_meta($post->ID, 'thesis_keywords', true)));
		}
		
		if(get_post_meta($post->ID, 'keywords', true)){
			global $post;
			array_push($keywords, explode(',', get_post_meta($post->ID, 'keywords', true)));
		}
		
		
		if(headway_get_option('categories-meta') == 1):
			$categories = (!is_page()) ? get_the_category($post->ID) : NULL;
			
			if($categories){
				foreach($categories as $category) { 
				    array_push($keywords, $category->cat_name);
				} 
			}
			
		endif;
		
		if(headway_get_option('tags-meta') == 1):
			if(get_the_tags($post->ID)):
				$tags = get_the_tags($post->ID);
			
				foreach($tags as $tag) { 
				    array_push($keywords, $tag->name);
				} 
			endif;
		endif;
		
		$keywords = implode(', ', $keywords);
		$meta = (!is_home() && !is_front_page() && $keywords) ? "\n".'<meta name="keywords" content="'.$keywords.'" />' : NULL;
	}
	
	
	if(is_home() && headway_get_option('home-description') || is_front_page() && headway_get_option('home-description')):
		$meta .= "\n".'<meta name="description" content="'.stripslashes(headway_get_option('home-description')).'" />';
	elseif(headway_get_write_box_value('description') != ''):
		$meta .= "\n".'<meta name="description" content="'.stripslashes(headway_get_write_box_value('description')).'" />';
	elseif(get_post_meta($post->ID, 'thesis_description', true)):
		$meta .= "\n".'<meta name="description" content="'.stripslashes(get_post_meta($post->ID, 'thesis_description', true)).'" />';
	elseif(get_post_meta($post->ID, 'description', true)):
		$meta .= "\n".'<meta name="description" content="'.stripslashes(get_post_meta($post->ID, 'description', true)).'" />';
	endif;
	
	
	if(headway_get_option('canonical') == 1 && (is_page() || is_single()) && !function_exists('get_the_post_thumbnail')):
		$meta .= "\n".'<meta name="canonical" content="'.get_permalink().'" />';
	endif;
	
	
	if(is_category() && headway_get_option('noindex-category-archives')) $meta .= "\n".'<meta name="robots" content="noindex" />';
	if(is_date() && headway_get_option('noindex-archives')) $meta .= "\n".'<meta name="robots" content="noindex" />';
	if(is_tag() && headway_get_option('noindex-tag-archives')) $meta .= "\n".'<meta name="robots" content="noindex" />';
	if(is_author() && headway_get_option('noindex-author-archives')) $meta .= "\n".'<meta name="robots" content="noindex" />';
	if(headway_get_write_box_value('noindex') && is_single()) $meta .= "\n".'<meta name="robots" content="noindex" />';
	
	
	echo "\n".$meta."\n";
}


/**
 * Enqueues the Headway JS for leafs.
 * 
 * @uses wp_enqueue_script()
 **/
function headway_insert_scripts(){
	global $headway_custom_leaf_js;
	
	$pageID = headway_current_page(false, false, true);
		
	$leafs = headway_get_all_leafs();

	headway_build_default_leafs($pageID);

	if(count($leafs) > 0){												    	
		foreach($leafs as $leaf){ 													// Start foreach loop for every leaf/box.
			$leaf = array_map('maybe_unserialize', $leaf);

			if($leaf['config']['type'] == 'featured' && $leaf['options']['rotate-posts']) $featured_check = true;
			if($leaf['config']['type'] == 'rotator' && count($leaf['options']['images']) > 1) $rotator_check = true;
			if($leaf['config']['type'] == 'gallery') $gallery_check = true;
									
			if(isset($headway_custom_leaf_js[$leaf['config']['type']]))
				$headway_custom_leaf_js_active = true;
		}
	}

	$load_scripts = array();

	if($rotator_check || $featured_check)
		array_push($load_scripts, 'jquery.cycle.js');
	
	if($gallery_check)
		array_push($load_scripts, 'jquery.galleriffic.js');
	
	$path_to_theme = headway_relative_path();
		
	if(count($load_scripts) > 0){
		if(in_array('jquery.cycle.js', $load_scripts)) wp_enqueue_script('jquery_cycle', get_bloginfo('template_directory').'/media/js/jquery.cycle.js', array('jquery'));
		if(in_array('jquery.galleriffic.js', $load_scripts)) wp_enqueue_script('jquery_galleriffic', get_bloginfo('template_directory').'/media/js/jquery.galleriffic.js', array('jquery'));
				
		if(headway_cache_exists('scripts.js') && !headway_visual_editor_open() && !$cleared_cache)
			wp_enqueue_script('headway_js_settings', get_bloginfo('template_directory').'/media/cache/scripts.js?'.headway_get_option('css-last-updated'), array('jquery'));
		else
			wp_enqueue_script('headway_js_settings', get_bloginfo('url').'/?headway-js', array('jquery'));
	}
		
	if($headway_custom_leaf_js_active){
		if(headway_cache_exists('scripts.js') && !headway_visual_editor_open() && !$cleared_cache)
			wp_enqueue_script('headway_js_settings', get_bloginfo('template_directory').'/media/cache/scripts.js?'.headway_get_option('css-last-updated'));
		else
			wp_enqueue_script('headway_js_settings', get_bloginfo('url').'/?headway-js');
	}
	
	if(count($load_scripts) > 0 || $headway_custom_leaf_js_active){
		$cleared_cache = headway_get_option('cleared-cache');

		if($cleared_cache){
			headway_delete_option('cleared-cache');
		} elseif(!headway_cache_exists('scripts.js')){		
			headway_generate_cache();
		}
	}
	
	$libraries = headway_get_option('js-libraries');
	
	if(is_array($libraries)){
		$manual_js = array('unitpngfix');
		
		$wp_libraries = array_diff($libraries, $manual_js);
		
		array_shift($wp_libraries);
		array_shift($libraries);
		
		foreach($wp_libraries as $library){
			wp_enqueue_script($library);
		}
		
		if(in_array('unitpngfix', $libraries)){			
			echo '
				<!--[if lt IE 7]>
						<script type="text/javascript">
							theme_path = \''.get_bloginfo('template_directory').'\';
						</script>
						
				        <script type="text/javascript" src="'.get_bloginfo('template_directory').'/media/js/libraries/unitpngfix/unitpngfix.js"></script>
				<![endif]-->

			';
		}
	}
	
	
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	
}


/**
 * Adds all of the links for the Headway stylesheets.
 **/
function headway_stylesheets(){	
	$cleared_cache = headway_get_option('cleared-cache');
						
	if($cleared_cache){
		headway_delete_option('cleared-cache');
	} elseif(!headway_cache_exists('headway.css') || !headway_cache_exists('leafs.css')){		
		headway_generate_cache();
	}
	
	$pageID = headway_current_page(false, false, true);
	$path_to_theme = headway_relative_path();
	$custom_modified = filemtime( get_stylesheet_directory() . '/custom.css'); 
	$css_media = (!headway_get_option('print-css')) ? null : ' media="screen, projection"';
	$last_updated = headway_get_option('css-last-updated');
	$last_updated_cache = (headway_is_caching()) ? null : $last_updated;
	
	echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('stylesheet_url').'" />'."\n";
	
	if(headway_cache_exists('headway.css') && !headway_visual_editor_open() && !$cleared_cache)
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/cache/headway.css?'.$last_updated_cache.'"'.$css_media.' />'."\n";
	else
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('url').'/?headway-css='.$last_updated_cache.'"'.$css_media.' />'."\n";
		
		
	if(headway_cache_exists('leafs.css') && !headway_visual_editor_open() && !$cleared_cache)	
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/cache/leafs.css?'.$last_updated_cache.'"'.$css_media.' />'."\n";
	else
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('url').'/?headway-leafs-css=&amp;'.$last_updated_cache.'"'.$css_media.' />'."\n";
		

	do_action('headway_skins_stylesheets');
	
	echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('template_directory').'/custom.css?'.$custom_modified.'" />'."\n";
	
	if(headway_get_option('additional-stylesheet')) echo '<link rel="stylesheet" type="text/css" href="'.headway_get_option('additional-stylesheet').'"'.$css_media.' />'."\n";
	
	if(headway_get_option('print-css')) echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/css/print.css" media="print" />'."\n";
			
		echo '
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/css/ie.css" />
	<![endif]-->
	
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/css/ie6.css" />
		
		<script type="text/javascript" src="'.get_bloginfo('template_directory').'/media/js/suckerfish.js"></script>
	<![endif]-->
	
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/media/css/ie7.css" />
	<![endif]-->';
	
}


/**
 * Adds the link to the favicon to the <head>.
 **/
function headway_favicon(){
	if(headway_get_option('favicon'))
		echo "\n".'<link rel="shortcut icon" type="image/ico" href="'.headway_get_option('favicon').'" />'."\n";
}


/**
 * Forward the user is the page is set to forward.
 **/
function headway_forward(){
	if(headway_get_write_box_value('headway_category_forward') && !is_admin() && !headway_get_write_box_value('navigation_url')) header('Location: '.get_category_link(headway_get_write_box_value('headway_category_forward')), true, 301);
	if(headway_get_write_box_value('navigation_url') && !is_admin()) header('Location: '.headway_get_write_box_value('navigation_url'), true, 301);
}


/**
 * Run the headway_head action.  Looks less sloppy for this to be put into the header.php file.
 **/
function headway_head(){
	do_action('headway_head');
}
add_action('wp_head', 'headway_head', 1);


/**
 * Callback function to be used for displaying the header scripts.
 * 
 * @uses headway_parse_php()
 **/
function headway_header_scripts(){
	echo headway_parse_php(stripslashes(html_entity_decode(headway_get_option('header-scripts'))));
}


/**
 * Callback function to be used for displaying the footer scripts.
 * 
 * @uses headway_parse_php()
 **/
function headway_footer_scripts(){
	echo headway_parse_php(stripslashes(html_entity_decode(headway_get_option('footer-scripts'))));
}


add_action('wp_head', 'headway_favicon');
add_action('wp', 'headway_forward');

if(!is_admin()){
	add_action('headway_head', 'headway_stylesheets');
	if(!class_exists('All_in_One_SEO_Pack')) add_action('headway_head', 'headway_meta');
	add_action('headway_head', 'headway_header_scripts');
	add_action('wp_footer', 'headway_footer_scripts');
	add_action('wp_print_scripts', 'headway_insert_scripts');
}