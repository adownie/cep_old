<?php
function headway_show_navigation(){	
	if(headway_get_skin_option('show-navigation')){
		if(headway_get_skin_option('header-style') == 'fluid') $position = 'outside';
	
		if($position == 'outside') $navigation  = '<div id="navigation-container">'."\n";
								   $navigation .= '<div id="navigation" class="clearfix">'."\n";
								   $navigation .= headway_navigation();
			 					   $navigation .= "\n".'</div>'."\n";
		if($position == 'outside') $navigation .= '</div>'."\n";
	
		echo $navigation; 
		do_action('headway_after_navigation');
	}
}
function headway_show_header(){
		if(headway_get_skin_option('header-style') == 'fixed'):
			$header_open = '<div id="header">'."\n";
			$header_close = '</div><!-- #header -->'."\n";
			$wrapper_inside = '<div id="wrapper">'."\n";
			$position = 'inside';
		elseif(headway_get_skin_option('header-style') == 'fluid'):
			$header_open = '<div id="header-container">'."\n".'<div id="header">'."\n";
			$header_close = '</div><!-- #header -->'."\n".'</div><!-- #header-container -->'."\n";
			$wrapper_outside = "\n".'<div id="wrapper">'."\n";
			$position = 'outside';
		endif;
	
		echo $header_open;
		
		
		//If header image exists, is uploaded, and resizing disabled.
		if(headway_check_header_image() && strpos(strtolower(headway_get_option('header-image')), 'http') === false && headway_get_option('enable-header-resizing')){
			$header_image = headway_thumbnail(headway_upload_path().'header-uploads/'.headway_get_option('header-image'), str_replace('px', '', headway_get_skin_option('wrapper-width')), false, 0);
			$header_link_content = '<img src="'.$header_image.'" alt="'.get_bloginfo('name').'" />'."\n"; 
			
		//If exists, is uploaded, and resizing ENABLED.
		}elseif(headway_check_header_image() && !headway_get_option('enable-header-resizing') && strpos(strtolower(headway_get_option('header-image')), 'http') === false){
			$header_link_content = '<img src="'.get_bloginfo('wpurl').'/wp-content/uploads/headway/header-uploads/'.headway_get_option('header-image').'" alt="'.get_bloginfo('name').'" />'."\n";

		//If direct link to image.
		}elseif(headway_check_header_image() && strpos(strtolower(headway_get_option('header-image')), 'http') !== false){
			$header_link_content = '<img src="'.headway_get_option('header-image').'" alt="'.get_bloginfo('name').'" />'."\n";
			
		//Else no image.
		}else{
			$header_link_content = get_bloginfo('name');
		}
		
			
			$header_link_class = (headway_get_option('header-image') && headway_get_option('header-image') != 'DELETE' && !headway_get_skin_option('disable-header-image')) ? 'header-link-image' : 'header-link-text';
			$header_link_class_inside = (headway_get_option('header-image') && headway_get_option('header-image') != 'DELETE' && !headway_get_skin_option('disable-header-image')) ? 'header-link-image-inside' : 'header-link-text-inside';
			
			do_action('headway_before_header_link');
			
			if(headway_get_option('nofollow-home')) $nofollow['home'] = ' nofollow';
	
			echo '<div id="top" class="'.$header_link_class.' header-link-top clearfix"><a href="'.get_option('home').'" title="'.get_bloginfo('name').'" rel="home'.$nofollow['home'].'" class="'.$header_link_class_inside.'">'.$header_link_content.'</a>';
			do_action('headway_after_header_link');
			echo '</div>'."\n";
			
	
	
			echo (headway_get_skin_option('show-tagline')) ? '<h1 id="tagline">'.get_bloginfo('description').'</h1>'."\n" : "\n";
	
			do_action('headway_after_tagline');
	
	
		echo $header_close;
		
		do_action('headway_after_header');
}
function headway_show_breadcrumbs(){
	if(headway_get_skin_option('header-style') == 'fluid') $position = 'outside';
	
	$breadcrumbs = '';
	
	if(headway_breadcrumbs(true)):
		if($position == 'outside') $breadcrumbs  = '<div id="breadcrumbs-container">'."\n";
								   $breadcrumbs .= apply_filters( 'headway_breadcrumbs_beginning', '' );
		 						   $breadcrumbs .= (function_exists('yoast_breadcrumb')) ? yoast_breadcrumb(false, false, false) : headway_breadcrumbs();
								   $breadcrumbs .= apply_filters( 'headway_breadcrumbs_end', '' );
		if($position == 'outside') $breadcrumbs .= '</div><!-- #breadcrumbs-container -->'."\n";
	endif;
	
	echo $breadcrumbs;
	
	do_action('headway_after_breadcrumbs');
}


function headway_page_top(){
	$custom = ' custom';
	if(headway_get_option('site-style')) $skin = ' skin-'.strtolower(str_replace(' ', '-', headway_get_option('site-style')));
	
	echo '<body class="'.headway_body_class().$custom.' header-'.headway_get_skin_option('header-style').' footer-'.headway_get_skin_option('footer-style').$skin.'">'."\n\n";

	do_action('headway_before_everything');

	
	echo (headway_get_skin_option('header-style') == 'fixed') ? "\n\n".'<div id="wrapper">'."\n\n" : NULL;
	
	$header_order = headway_get_skin_option('header-order', true, true);
	
	$header_check = array();
	
	if(count($header_order) > 0 && $header_order != 'unserialized'){
		foreach($header_order as $header_item){
			
			if($header_item == 'header' && !in_array('header', $header_check)){
				if(!headway_get_write_box_value('hide_header')) headway_show_header();
				array_push($header_check, 'header');
			}
			
			if($header_item == 'navigation' && !in_array('navigation', $header_check)){
				if(!headway_get_write_box_value('hide_navigation')) headway_show_navigation();
				array_push($header_check, 'navigation');
			} 
			
			if($header_item == 'breadcrumbs' && !in_array('breadcrumbs', $header_check)){
				headway_show_breadcrumbs();
				array_push($header_check, 'breadcrumbs');
			} 
			
		}
	} else {
		if(!headway_get_write_box_value('hide_header')) headway_show_header();
		if(!headway_get_write_box_value('hide_navigation')) headway_show_navigation();
		headway_show_breadcrumbs();
	}
	
	if(!in_array('navigation', $header_check) && headway_get_skin_option('show-navigation')) headway_show_navigation();
	if(!in_array('breadcrumbs', $header_check) && headway_get_skin_option('show-breadcrumbs') && !is_front_page()) headway_show_breadcrumbs();
		
		
	
	
	echo (headway_get_skin_option('header-style') == 'fluid') ? "\n".'<div id="wrapper">'."\n" : NULL;
	
	do_action('headway_page_start');
}



function headway_breadcrumbs($test = false, $echo = false, $force_display = false){	
	global $breadcrumbs_enabled;
	
	if((!is_front_page() && headway_get_skin_option('show-breadcrumbs') == 'on') || $force_display){
		if(get_post_meta(get_the_id(), '_hide_breadcrumbs', true) != '1'){ //If statement was being mean to me so I had to nest it :-(
			$breadcrumbs_enabled = true;			
			if($test) return $breadcrumbs_enabled;  //Allows this function to be called upon to test if breadcrumbs are enabled
		} else {
			$breadcrumbs_enabled = false;
			if($test) return $breadcrumbs_enabled;
		}
	} else {
		$breadcrumbs_enabled = false;
		if($test) return $breadcrumbs_enabled;
	}
	
	if($breadcrumbs_enabled){
				
	
		$return = '<div id="breadcrumbs"><p>You Are Here: &nbsp; <a href="'.get_bloginfo('wpurl').'">Home</a>';
			if(get_option('page_for_posts') != get_option('page_on_front') && get_option('show_on_front') == 'page'):
				if(is_home()) $return .= ' &raquo; '.get_the_title(get_option('page_for_posts'));
				$blog = ' &raquo; <a href="'.get_page_link(get_option('page_for_posts')).'">'.get_the_title(get_option('page_for_posts')).'</a>';
			endif;
			if(is_page()){
				global $post;
				$current_page = array($post);
				$parent = $post;
				while ( $parent->post_parent ){
					$parent = get_post( $parent->post_parent );
					array_unshift( $current_page, $parent );
				}
				foreach ( $current_page as $page){
					if($page->ID != get_the_id()):
						$link_open[$page->ID] = '<a href="' . get_page_link( $page->ID ) . '">';
						$link_close[$page->ID] = '</a>';
					endif;
					$return .= ' &raquo; '.$link_open[$page->ID].$page->post_title.$link_close[$page->ID].$separator;
				}
						
				
			}		 
			elseif(is_category()){$return .= $blog.' &raquo; '.single_cat_title('', false);}
			elseif(is_single()){$return .= $blog.' &raquo; '.get_the_category_list(', ').' &raquo; '.get_the_title();}
			elseif(is_search()){$return .= $blog.' &raquo; Search Results For: '.get_search_query();}
			elseif(is_author()){
				if(get_query_var('author_name')) :
					$authordata = get_userdatabylogin(get_query_var('author_name'));
				else :
					$authordata = get_userdata(get_query_var('author'));
				endif;
				$return .= $blog.' &raquo; Author Archives: '.$authordata->display_name;
			}
			elseif(is_404()){$return .= ' &raquo; 404 Error!';}
			elseif(is_tag()){$return .= $blog.' &raquo; Tag Archives: '.single_tag_title('', false);}
			elseif(is_date()){$return .= $blog.' &raquo; Archives: '.get_the_time('F Y'); }
		$return .= '</p></div>';
		
		
		if($echo) echo $return;
		if(!$echo) return $return;
		
	
	}
	
}


function headway_footer(){
	
	if(headway_get_skin_option('footer-style') == 'fluid') echo '</div><!-- #wrapper -->'."\n".'<div id="footer-container">'."\n";
	
	echo '<div id="footer">';
	
	do_action('headway_footer_opening');
	
	if(!headway_get_option('hide-headway-attribution')) headway_link();
		
	if(headway_get_option('show-go-to-top-link')) headway_go_to_top();
	if(headway_get_option('show-edit-link')) headway_edit();
 	if(headway_get_option('show-admin-link')) headway_login();

	do_action('headway_before_copyright');

	if(headway_get_option('show-copyright')) headway_copyright();
		
	if(HEADWAYDEBUG === true){
		echo '<p class="copyright">'.get_num_queries().' queries.<br />';
		echo timer_stop(0).' seconds.</p>';
	}
	
	do_action('headway_footer_close');
	
		
	echo '</div><!-- #footer -->';
	if(headway_get_skin_option('footer-style') == 'fluid') echo "\n".'</div><!-- #footer-container -->';
	
	
	if(headway_get_skin_option('footer-style') == 'fixed') echo '</div><!-- #wrapper -->';
}


function headway_html_open(){
	headway_gzip();
	echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">

HTML;
}


function headway_html_close(){
	wp_footer();

	do_action('headway_after_everything');
	
	echo '</body>';
		
	echo "\n".'</html>';
}