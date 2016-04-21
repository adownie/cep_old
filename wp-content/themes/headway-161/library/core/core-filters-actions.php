<?php
function headway_above_title($count = 1, $single = false, $small_excerpts = false) {
	if(!$small_excerpts && !is_page()){
		do_action('headway_above_post_title', $count, $single);
	} elseif(is_page()){
		do_action('headway_above_page_title');
	}

	headway_post_meta('title', 'above', false, false, false, $small_excerpts);
}
function headway_below_title($count = 1, $single = false, $small_excerpts = false) {	
	headway_post_meta('title', 'below', false, false, false, $small_excerpts);
	
	if(!$small_excerpts && !is_page()){
		do_action('headway_below_post_title', $count, $single);
	} elseif(is_page()){
		do_action('headway_below_page_title');
	}
}
function headway_below_content($count = 1, $single = false, $small_excerpts = false) {
	headway_post_meta('content', 'below', false, false, false, $small_excerpts);
	
    if(!$small_excerpts && !is_page()){
		do_action('headway_below_post_content', $count, $single);
	} elseif(is_page()){
		do_action('headway_below_page_content');
	}
}






function easy_hook_before_everything(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-before-everything')));
}
add_action('headway_before_everything', 'easy_hook_before_everything');

function easy_hook_after_everything(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-after-everything')));
}
add_action('headway_after_everything', 'easy_hook_after_everything');

function easy_hook_before_header_link(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-before-header-link')));
}
add_action('headway_before_header_link', 'easy_hook_before_header_link');

function easy_hook_after_header_link(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-after-header-link')));
}
add_action('headway_after_header_link', 'easy_hook_after_header_link');

function easy_hook_after_tagline(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-after-tagline')));
}
add_action('headway_after_tagline', 'easy_hook_after_tagline');

function easy_hook_after_navigation(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-after-navigation')));
}
add_action('headway_after_navigation', 'easy_hook_after_navigation');

function easy_hook_navigation_beginning(){
	return headway_parse_php(stripslashes(headway_get_option('easy-hooks-navigation-beginning')));
}
add_filter('headway_navigation_beginning', 'easy_hook_navigation_beginning');

function easy_hook_navigation_end(){
	return headway_parse_php(stripslashes(headway_get_option('easy-hooks-navigation-end')));
}
add_filter('headway_navigation_end', 'easy_hook_navigation_end');

function easy_hook_breadcrumbs_beginning(){
	return headway_parse_php(stripslashes(headway_get_option('easy-hooks-breadcrumbs-beginning')));
}
add_filter('headway_breadcrumbs_beginning', 'easy_hook_breadcrumbs_beginning');

function easy_hook_breadcrumbs_end(){
	return headway_parse_php(stripslashes(headway_get_option('easy-hooks-breadcrumbs-end')));
}
add_filter('headway_breadcrumbs_end', 'easy_hook_breadcrumbs_end');

function easy_hook_leaf_top(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-leaf-top')));
}
add_action('headway_leaf_top', 'easy_hook_leaf_top');

function easy_hook_leaf_content_top(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-leaf-content-top')));
}
add_action('headway_leaf_content_top', 'easy_hook_leaf_content_top');

function easy_hook_leaf_content_bottom(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-leaf-content-bottom')));
}
add_action('headway_leaf_content_bottom', 'easy_hook_leaf_content_bottom');

function easy_hook_leaf_bottom(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-leaf-bottom')));
}
add_action('headway_leaf_bottom', 'easy_hook_leaf_bottom');

function easy_hook_above_post(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-above-post')));
}
add_action('headway_above_post', 'easy_hook_above_post');

function easy_hook_above_post_title(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-above-post-title')));
}
add_action('headway_above_post_title', 'easy_hook_above_post_title');

function easy_hook_below_post_title(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-below-post-title')));
}
add_action('headway_below_post_title', 'easy_hook_below_post_title');

function easy_hook_below_post_content(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-below-post-content')));
}
add_action('headway_below_post_content', 'easy_hook_below_post_content');

function easy_hook_below_post(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-below-post')));
}
add_action('headway_below_post', 'easy_hook_below_post');

function easy_hook_above_page(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-above-page')));
}
add_action('headway_above_page', 'easy_hook_above_page');

function easy_hook_below_page_title(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-below-page-title')));
}
add_action('headway_below_page_title', 'easy_hook_below_page_title');

function easy_hook_below_page(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-below-page')));
}
add_action('headway_below_page', 'easy_hook_below_page');

function easy_hook_sidebar_top(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-sidebar-top')));
}
add_action('headway_sidebar_top', 'easy_hook_sidebar_top');

function easy_hook_sidebar_bottom(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-sidebar-bottom')));
}
add_action('headway_sidebar_bottom', 'easy_hook_sidebar_bottom');

function easy_hook_footer_opening(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-footer-opening')));
}
add_action('headway_footer_opening', 'easy_hook_footer_opening');

function easy_hook_footer_close(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-footer-close')));
}
add_action('headway_footer_close', 'easy_hook_footer_close');

function easy_hook_before_copyright(){
	echo headway_parse_php(stripslashes(headway_get_option('easy-hooks-before-copyright')));
}
add_action('headway_before_copyright', 'easy_hook_before_copyright');