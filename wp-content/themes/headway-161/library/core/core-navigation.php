<?php 
function headway_navigation($echo = false){
	
	if(headway_breadcrumbs(true, false)) $breadcrumb_class = ' breadcrumb-active';

	$navigation_position = headway_get_skin_option('navigation-position');
	
	$nav_query = array('echo' => false, 'sort_column' => 'menu_order', 'container' => false, 'menu_class' => 'navigation'.$breadcrumb_class.' navigation-'.$navigation_position, 'fallback_cb' => 'headway_legacy_menu');
	if(!headway_get_option('show-navigation-subpages') || !headway_get_skin_option('show-navigation-subpages')) $nav_query['depth'] = 1;
	if(headway_get_option('nav-menu')) $nav_query['menu'] = headway_get_option('nav-menu');
	
	if(function_exists('wp_nav_menu'))
		$return .= wp_nav_menu($nav_query);
	else
		$return .= headway_legacy_menu();
	
	
	if($echo){ 
		echo $return;
	} else {
		return $return;
	}
	
}


function headway_home_link($menu){
	if(get_option('show_on_front') == 'posts'){
		if(headway_get_option('nofollow-home')) $nofollow['home'] = ' rel="nofollow" ';
		if(is_home() || is_front_page()) $current['home'] = ' current_page_item';
		$home_text = (headway_get_option('home-link-text')) ? headway_get_option('home-link-text') : 'Home';
		if(!headway_get_option('hide-home-link')) $home_link .= '<li class="page-item-1'.$current['home'].'"><a href="'.get_option('home').'"'.$nofollow['home'].'>'.$home_text.'</a></li>';
	}
	
	$menu = $home_link.$menu;
	
	return $menu;
}
add_filter('wp_nav_menu_items', 'headway_home_link');


function headway_legacy_menu(){
	if(headway_breadcrumbs(true, false)) $breadcrumb_class = ' breadcrumb-active';
	$navigation_position = headway_get_skin_option('navigation-position');
	
	$nav_query = array('echo' => false, 'title_li' => false);
	if(!headway_get_option('show-navigation-subpages') || !headway_get_skin_option('show-navigation-subpages')) $nav_query['depth'] = 1;
	
	$items = apply_filters('wp_nav_menu_items', wp_list_pages($nav_query));
	
	return '<ul class="navigation'.$breadcrumb_class.' navigation-'.$navigation_position.'">'."\n".$items."\n</ul>";
}


function headway_exclude_pages($content){
	$excluded_pages = headway_get_option('excluded_pages');		
	return $excluded_pages;
}
if(headway_get_option('excluded_pages')) add_filter('wp_list_pages_excludes', 'headway_exclude_pages');