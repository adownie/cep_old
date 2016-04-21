<?php
function array_change_key($original, $new, &$array){
    if (isset($array[$original]))
    {
        $array[$new] = $array[$original];
        unset($array[$original]);
    }
    return $array;
}

function clean_font($arg){
	if($arg == 'georgia'){
		return 'georgia, serif';

	} elseif($arg == 'times'){
		return 'times, serif';

	} elseif($arg == 'times-new-roman'){
		return 'times new roman, serif';

	} elseif($arg == 'helvetica'){
		return 'helvetica, sans-serif';

	} elseif($arg == 'arial'){
		return 'arial, sans-serif';

	} elseif($arg == 'arial-black'){
		return '\'arial black\', sans-serif';

	} elseif($arg == 'verdana'){
		return 'verdana, sans-serif';

	} elseif($arg == 'tahoma'){
		return 'tahoma, sans-serif';

	} elseif($arg == 'courier'){
		return 'courier, monospace';

	} elseif($arg == 'courier-new'){
		return 'courier new, monospace';

	} elseif($arg == 'lucida-grande'){
		return 'lucida grande, sans-serif';

	} elseif($arg == 'gill-sans'){
		return 'gill sans, sans-serif';
	} 
}

function do_line_height($size){
	if(strlen($size) == 1){
		$size = $size.'0';
	}
	return round($size*1.75);
}


function fix_size($size){
	if(strlen($size) == 1){
		$size = $size.'0';
	}
	return round($size*1.15);
}

function fix_size_height($size){
	if(strlen($size) == 1){
		$size = $size.'0';
	}
	return round($size*1.5);
}

function headway_upgrade(){	
	if(!headway_get_option('upgrade-15', true, true) && get_option('headway_installed')){
				
		global $wpdb;
	
		include 'core-upgrade-functions.php';

		$leafs_table = $wpdb->prefix.'headway_leafs';
		$wpdb->query("TRUNCATE TABLE `$leafs_table`");
	
		global $widgets_transfer;
		if(!$widgets_transfer) $widgets_transfer = get_option('headway_sidebars_widgets');

		$meta_rows = $wpdb->get_results("SELECT * FROM $wpdb->postmeta", ARRAY_A);
		
		if($meta_rows){
			foreach($meta_rows as $meta_row){

				if($meta_row['meta_key'] == '_leafs'){	

					if(is_array(maybe_unserialize($meta_row['meta_value'])) && !$transfer_leafs[$meta_row['post_id']]){	
						foreach(unserialize($meta_row['meta_value']) as $leaf){
							$leaf_id = $leaf;
					
							$leaf_position = array_search($leaf, unserialize($meta_row['meta_value']));				
							$leaf_config = get_post_meta($meta_row['post_id'], '_'.$leaf, true);
							$leaf_options = get_post_meta($meta_row['post_id'], '_'.$leaf.'_options', true);

							$leaf_type = $leaf_config[0];
							$leaf_title = $leaf_config[1];
							$leaf_width = $leaf_config[2];
							$leaf_height = $leaf_config[3];
							$leaf_align_right = $leaf_config[4];
							$leaf_fluid_height = $leaf_config[5];

							$leaf_position = false;

							$leaf_options = headway_json_array_fix(headway_json_decode($leaf_options, true));

							foreach($leaf_options as $key => $value) $leaf_options[$key] = ($value == 'on') ? true : $value;
					
							$leaf_config = array(
								'type' => $leaf_type,
								'title' => $leaf_title,
								'show-title' => $leaf_options['show-title'],
								'title-link' => $leaf_options['leaf-title-link'],
								'width' => $leaf_width,
								'height' => $leaf_height,
								'fluid-height' => $leaf_fluid_height,
								'align-right' => $leaf_align_right,
								'custom-classes' => $leaf_options['custom-css-class']
							);

							$leaf_options_new = headway_upgrade_leaf($leaf_config, $leaf_type, $leaf_options, $leaf, false, $meta_row['post_id']);

							$new_leaf_id = headway_add_leaf($meta_row['post_id'], $leaf_position, $leaf_config, $leaf_options_new);
					
							if($leaf_type == 'sidebar'){
								global $widgets_transfer;
								if($widgets_transfer['sidebar-'.$leaf_id]){
									$widgets_transfer['sidebar-'.$new_leaf_id] = $widgets_transfer['sidebar-'.$leaf_id];
									unset($widgets_transfer['sidebar-'.$leaf_id]);
								}
							}

							$transfer_leafs[$meta_row['post_id']] = true;

						}
					}
				}


			}
		}


		$system_pages = array('index', 'four04', 'archives', 'author', 'search', 'category', 'single', 'tag');


		foreach($system_pages as $system_page){
			$system_page_options = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name LIKE 'system-page-$system_page-leafs%'", ARRAY_A);
			
			if($system_page_options){
				foreach($system_page_options as $option_row){

					$leafs = unserialize($option_row['option_value']);

					foreach($wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name LIKE 'system-page-$system_page-item%'", ARRAY_A) as $leaf){
						if(strpos($leaf['option_name'], 'text')) continue;
						if(strpos($leaf['option_name'], 'options')) continue;

						$leaf_id = str_replace('system-page-'.$system_page.'-', '', $leaf['option_name']);

						$leaf_position = array_search($leaf_id, $leafs);				
						$leaf_config = unserialize($leaf['option_value']);
						$leaf_options = $wpdb->get_row("SELECT * FROM $wpdb->options WHERE option_name LIKE 'system-page-$system_page-$leaf_id%options'", ARRAY_A);
						$leaf_options = headway_json_array_fix(headway_json_decode($leaf_options['option_value'], true));

						$leaf_type = $leaf_config[0];
						$leaf_title = $leaf_config[1];
						$leaf_width = $leaf_config[2];
						$leaf_height = $leaf_config[3];
						$leaf_align_right = $leaf_config[4];
						$leaf_fluid_height = $leaf_config[5];

						$leaf_config = array(
							'type' => $leaf_type,
							'title' => $leaf_title,
							'show-title' => $leaf_options['show-title'],
							'title-link' => $leaf_options['leaf-title-link'],
							'width' => $leaf_width,
							'height' => $leaf_height,
							'fluid-height' => $leaf_fluid_height,
							'align-right' => $leaf_align_right,
							'custom-classes' => $leaf_options['custom-css-class']
						);

						$leaf_options_new = headway_upgrade_leaf($leaf_config, $leaf_type, $leaf_options, $leaf_id, true, $system_page);
				
						global $wpdb;
				
						$new_leaf_id = headway_add_leaf($system_page, $leaf_position, $leaf_config, $leaf_options_new);
				
						if($leaf_type == 'sidebar'){
							global $widgets_transfer;
							if($widgets_transfer['sidebar-'.$leaf_id]){
								$widgets_transfer['sidebar-'.$new_leaf_id] = $widgets_transfer['sidebar-'.$leaf_id];
								unset($widgets_transfer['sidebar-'.$leaf_id]);
							}
						}
								

					}


				}
			}
		}
	
	
		if($widgets_transfer) update_option('sidebars_widgets', $widgets_transfer);
		
	

		$header_position = (get_option('header-position') == 'outside') ? 'fluid' : 'fixed';

		$show_tagline = (get_option('show_tagline')) ? get_option('show_tagline') : 'DELETE';
		$show_breadcrumbs = (get_option('show_breadcrumbs')) ? get_option('show_breadcrumbs') : 'DELETE';
	
		$header_order = (get_option('navigation-position') == 'above') ? array('navigation', 'header') : array('header', 'navigation');

		headway_update_option('gzip', get_option('gzip'));
		headway_update_option('site-style', get_option('site-style'));
		headway_update_option('show-tagline', $show_tagline);
		headway_update_option('show-breadcrumbs', $show_breadcrumbs);
		headway_update_option('header-image-margin', get_option('header-image-margin'));
		headway_update_option('header-style', $header_position);
		headway_update_option('header-order', $header_order);
		headway_update_option('wrapper-width', str_replace('px', '', get_option('wrapper-width')));
		headway_update_option('wrapper-margin', get_option('wrapper-margin').'px auto');
		headway_update_option('hide-home-link', get_option('hide-home-link'));
		headway_update_option('home-link-text', get_option('home-link-text'));
		headway_update_option('post-date-format', get_option('post-date-format'));
		headway_update_option('post-comment-format-0', get_option('post-comment-format-0'));
		headway_update_option('post-comment-format-1', get_option('post-comment-format-1'));
		headway_update_option('post-comment-format', get_option('post-comment-format'));
		headway_update_option('post-respond-format', get_option('post-respond-format'));
		headway_update_option('post-above-title-left', get_option('post-above-title-left'));
		headway_update_option('post-above-title-right', get_option('post-above-title-right'));
		headway_update_option('post-below-title-left', get_option('post-below-title-left'));
		headway_update_option('post-below-title-right', get_option('post-below-title-right'));
		headway_update_option('post-below-content-left', get_option('post-below-content-left'));
		headway_update_option('post-below-content-right', get_option('post-below-content-right'));
		headway_update_option('featured-posts', get_option('featured-posts'));
		headway_update_option('show-avatars', get_option('show-avatars'));
		headway_update_option('avatar-size', str_replace('px', '', get_option('avatar-size')));
		headway_update_option('show-admin-link', get_option('show-admin-link'));
		headway_update_option('title-home', get_option('title-home'));
		headway_update_option('title-page', get_option('title-page'));
		headway_update_option('title-posts-page', get_option('title-posts-page'));
		headway_update_option('title-single', get_option('title-single'));
		headway_update_option('title-404', get_option('title-404'));
		headway_update_option('title-category', get_option('title-category'));
		headway_update_option('title-tag', get_option('title-tag'));
		headway_update_option('title-search', get_option('title-search'));
		headway_update_option('title-archives', get_option('title-archives'));
		headway_update_option('title-author-archives', get_option('title-author-archives'));
		headway_update_option('categories-meta', get_option('categories-meta'));
		headway_update_option('tags-meta', get_option('tags-meta'));
		headway_update_option('canonical', get_option('canonical'));
		headway_update_option('nofollow-comment-author', get_option('nofollow-comment-author'));
		headway_update_option('nofollow-home', get_option('nofollow-home'));
		headway_update_option('tweet-format', get_option('tweet-format'));
		headway_update_option('twitter-username', get_option('twitter-username'));
		headway_update_option('twitter-password', get_option('twitter-password'));
		headway_update_option('header-image', get_option('header-image'));
		headway_update_option('small-excerpts', get_option('small-excerpts'));
		headway_update_option('default-avatar', get_option('default-avatar'));
		headway_update_option('feed-url', get_option('feed-url'));
		headway_update_option('header-scripts', get_option('header-scripts'));
		headway_update_option('footer-scripts', get_option('footer-scripts'));
		headway_update_option('favicon', get_option('favicon'));
		headway_update_option('affiliate-link', get_option('affiliate_link'));
		headway_update_option('post-to-twitter', get_option('post-to-twitter'));


		headway_update_element_style('body', 'color', 'background', get_option('color-background'));
		headway_update_element_style('wrapper', 'color', 'border-all', get_option('color-wrapper-border'));
		headway_update_element_style('header', 'color', 'background', get_option('color-header-background'));
		headway_update_element_style('header', 'color', 'border-bottom', get_option('color-header-bottom-border'));
		headway_update_element_style('header-container', 'color', 'background', get_option('color-header-background'));
		headway_update_element_style('header-container', 'color', 'border-bottom', get_option('color-header-bottom-border'));
		headway_update_element_style('header-link-text-inside', 'color', 'color', get_option('color-header-link'));
		headway_update_element_style('header-link-text-inside', 'color', 'border-bottom', get_option('color-header-link-underline'));
		headway_update_element_style('h1tagline', 'color', 'color', get_option('color-header-tagline'));
		headway_update_element_style('navigation', 'color', 'background', get_option('color-navigation-background'));
		headway_update_element_style('navigation', 'color', 'border-bottom', get_option('color-navigation-bottom-border'));
		headway_update_element_style('navigation-container', 'color', 'background', get_option('color-navigation-background'));
		headway_update_element_style('navigation-container', 'color', 'border-bottom', get_option('color-navigation-bottom-border'));
		headway_update_element_style('ulnavigation_li_a', 'color', 'background', get_option('color-navigation-background'));
		headway_update_element_style('ulnavigation_li_a', 'color', 'color', get_option('color-navigation-link-color'));
		headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'color', 'color', get_option('color-navigation-link-color-active'));
		headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'color', 'background', get_option('color-navigation-link-background-active'));
		headway_update_element_style('ulnavigation_li_a', 'color', 'border-right', get_option('color-navigation-link-border'));
		headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'color', 'border-right', get_option('color-navigation-link-border'));
		headway_update_element_style('breadcrumbs', 'color', 'background', get_option('color-breadcrumbs-background'));
		headway_update_element_style('breadcrumbs-container', 'color', 'background', get_option('color-breadcrumbs-background'));
		headway_update_element_style('breadcrumbs', 'color', 'bottom-border', get_option('color-breadcrumbs-bottom-border'));
		headway_update_element_style('breadcrumbs-container', 'color', 'bottom-border', get_option('color-breadcrumbs-bottom-border'));
		headway_update_element_style('breadcrumbs', 'color', 'color', get_option('color-breadcrumbs-color'));
		headway_update_element_style('breadcrumbs-container', 'color', 'color', get_option('color-breadcrumbs-color'));
		headway_update_element_style('breadcrumbs_a', 'color', 'color', get_option('color-breadcrumbs-hyperlink-color'));
		headway_update_element_style('entry-content_h2', 'color', 'color', get_option('color-post-content-h2'));
		headway_update_element_style('entry-content_h3', 'color', 'color', get_option('color-post-content-h3'));
		headway_update_element_style('entry-content_h4', 'color', 'color', get_option('color-post-content-h4'));
		headway_update_element_style('h2entry-title_h1-period-entry-title', 'color', 'color', get_option('color-post-title'));
		headway_update_element_style('entry-title_h3', 'color', 'color', get_option('color-post-title'));
		headway_update_element_style('entry-title_a', 'color', 'color', get_option('color-post-title'));
		headway_update_element_style('entry-content', 'color', 'color', get_option('color-post-content'));
		headway_update_element_style('entry-content_a', 'color', 'color', get_option('color-post-hyperlink'));
		headway_update_element_style('entry-meta', 'color', 'color', get_option('color-post-meta'));
		headway_update_element_style('entry-meta_a', 'color', 'color', get_option('color-post-meta-hyperlink'));
		headway_update_element_style('post', 'color', 'border-bottom', get_option('color-post-bottom-border'));
		headway_update_element_style('leaf-top', 'color', 'color', get_option('color-leaf-title'));
		headway_update_element_style('leaf-top_a', 'color', 'color', get_option('color-leaf-title-hyperlink'));
		headway_update_element_style('leaf-top', 'color', 'border-bottom', get_option('color-leaf-title-underline'));
		headway_update_element_style('leaf-content', 'color', 'color', get_option('color-leaf-content'));
		headway_update_element_style('sidebar_spanwidget-title', 'color', 'color', get_option('color-widget-title'));
		headway_update_element_style('sidebar_a', 'color', 'color', get_option('color-sidebar-hyperlinks'));
		headway_update_element_style('footer', 'color', 'color', get_option('color-footer-text'));
		headway_update_element_style('footer_a', 'color', 'color', get_option('color-footer-hyperlinks'));
		headway_update_element_style('footer', 'color', 'background', get_option('color-footer-bg'));
		headway_update_element_style('footer', 'color', 'border-top', get_option('color-footer-top-border'));
	
	
	
		headway_update_element_style('header', 'font', 'font-family', clean_font(get_option('fonts-header')));
		headway_update_element_style('header', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-header-size'))));
		headway_update_element_style('header', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-header-size'))));
			headway_update_element_style('header-container', 'font', 'font-family', clean_font(get_option('fonts-header')));
			headway_update_element_style('header-container', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-header-size'))));
			headway_update_element_style('header-container', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-header-size'))));
		
			headway_update_element_style('header-link-text-inside', 'font', 'font-family', clean_font(get_option('fonts-header')));
			headway_update_element_style('header-link-text-inside', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-header-size'))));
			headway_update_element_style('header-link-text-inside', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-header-size'))));


		headway_update_element_style('h1tagline', 'font', 'font-family', clean_font(get_option('fonts-header-tagline')));
		headway_update_element_style('h1tagline', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-header-tagline-size'))));
		headway_update_element_style('h1tagline', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-header-tagline-size'))));
	
		headway_update_element_style('navigation', 'font', 'font-family', clean_font(get_option('fonts-navigation')));
		headway_update_element_style('navigation', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-navigation-size'))));
		headway_update_element_style('navigation', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-navigation-size'))));
			headway_update_element_style('ulnavigation_li_a', 'font', 'font-family', clean_font(get_option('fonts-navigation')));
			headway_update_element_style('ulnavigation_li_a', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-navigation-size'))));
			headway_update_element_style('ulnavigation_li_a', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-navigation-size'))));
		
			headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'font', 'font-family', clean_font(get_option('fonts-navigation')));
			headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-navigation-size'))));
			headway_update_element_style('ulnavigation_li-period-current_page_item_a', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-navigation-size'))));
	
		headway_update_element_style('breadcrumbs', 'font', 'font-family', clean_font(get_option('fonts-breadcrumbs')));
		headway_update_element_style('breadcrumbs', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-breadcrumbs-size'))));
		headway_update_element_style('breadcrumbs', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-breadcrumbs-size'))));
	
		headway_update_element_style('sidebar_liwidget', 'font', 'font-family', clean_font(get_option('fonts-sidebar')));
		headway_update_element_style('sidebar_liwidget', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-sidebar-size'))));
		headway_update_element_style('sidebar_liwidget', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-sidebar-size'))));
	
		headway_update_element_style('sidebar_spanwidget-title', 'font', 'font-family', clean_font(get_option('fonts-sidebar-widget-heading')));
		headway_update_element_style('sidebar_spanwidget-title', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-sidebar-widget-heading-size'))));
		headway_update_element_style('sidebar_spanwidget-title', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-sidebar-widget-heading-size'))));
	
		headway_update_element_style('leaf-top', 'font', 'font-family', clean_font(get_option('fonts-leaf-headings')));
		headway_update_element_style('leaf-top', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-leaf-headings-size'))));
		headway_update_element_style('leaf-top', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-leaf-headings-size'))));
	

		headway_update_element_style('leaf-content', 'font', 'font-family', clean_font(get_option('fonts-content')));
		headway_update_element_style('leaf-content', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-content-size'))));
		headway_update_element_style('leaf-content', 'font', 'line-height', do_line_height(fix_size(str_replace('.', '', get_option('fonts-content-size')))));
	
		headway_update_element_style('entry-content', 'font', 'font-family', clean_font(get_option('fonts-content')));
		headway_update_element_style('entry-content', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-content-size'))));
		headway_update_element_style('entry-content', 'font', 'line-height', do_line_height(fix_size(str_replace('.', '', get_option('fonts-content-size')))));
	
		headway_update_element_style('entry-meta', 'font', 'font-family', clean_font(get_option('fonts-content')));
	
		headway_update_element_style('amore-link', 'font', 'font-family', clean_font(get_option('fonts-content')));
		headway_update_element_style('amore-link', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-content-size'))));
		headway_update_element_style('amore-link', 'font', 'line-height', do_line_height(fix_size(str_replace('.', '', get_option('fonts-content-size')))));
	
		headway_update_element_style('divcomment-body', 'font', 'font-family', clean_font(get_option('fonts-content')));
		headway_update_element_style('divcomment-body', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-content-size'))));
		headway_update_element_style('divcomment-body', 'font', 'line-height', do_line_height(fix_size(str_replace('.', '', get_option('fonts-content-size')))));
	
		headway_update_element_style('footer', 'font', 'font-family', clean_font(get_option('fonts-content')));
	
	
		headway_update_element_style('h2entry-title_h1-period-entry-title', 'font', 'font-family', clean_font(get_option('fonts-titles')));
		headway_update_element_style('h2entry-title_h1-period-entry-title', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-titles-size')))*1.2);
		headway_update_element_style('h2entry-title_h1-period-entry-title', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-titles-size')))*1.2);
			headway_update_element_style('page-title', 'font', 'font-family', clean_font(get_option('fonts-titles')));
			headway_update_element_style('page-title', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-titles-size')))*1.2);
			headway_update_element_style('page-title', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-titles-size')))*1.2);
		
			headway_update_element_style('h3entry-title', 'font', 'font-family', clean_font(get_option('fonts-titles')));
	
		headway_update_element_style('entry-content_h2', 'font', 'font-family', clean_font(get_option('fonts-post-h2')));
		headway_update_element_style('entry-content_h2', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-post-h2-size'))));
		headway_update_element_style('entry-content_h2', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-post-h2-size'))));
	
		headway_update_element_style('entry-content_h3', 'font', 'font-family', clean_font(get_option('fonts-post-h3')));
		headway_update_element_style('entry-content_h3', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-post-h3-size'))));
		headway_update_element_style('entry-content_h3', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-post-h3-size'))));
	
		headway_update_element_style('entry-content_h4', 'font', 'font-family', clean_font(get_option('fonts-post-h4')));
		headway_update_element_style('entry-content_h4', 'font', 'font-size', fix_size(str_replace('.', '', get_option('fonts-post-h4-size'))));
		headway_update_element_style('entry-content_h4', 'font', 'line-height', fix_size_height(str_replace('.', '', get_option('fonts-post-h4-size'))));
			
		
		headway_update_option('upgrade-15', 'true');
	}


	if(!headway_get_option('upgrade-155', true, true)){
		include HEADWAYLIBRARY.'/misc/old-elements-array.php';
	
		global $wpdb;
		$elements_table = $wpdb->prefix.'headway_elements';
	
		foreach($old_elements_array as $old_selector => $new_selector){
			$new_selector = headway_selector_to_form_name($new_selector);
		
			$wpdb->query("UPDATE $elements_table SET element = '$new_selector' WHERE element = '$old_selector';");
		}
	
		$wpdb->query("UPDATE $elements_table SET property = 'border-width' WHERE property = 'border-all-width';");
		$wpdb->query("UPDATE $elements_table SET property = 'border' WHERE property = 'border-all';");
	
		$wpdb->query("UPDATE $elements_table SET property = 'top-border' WHERE property = 'border-top';");
		$wpdb->query("UPDATE $elements_table SET property = 'right-border' WHERE property = 'border-right';");
		$wpdb->query("UPDATE $elements_table SET property = 'bottom-border' WHERE property = 'border-bottom';");
		$wpdb->query("UPDATE $elements_table SET property = 'left-border' WHERE property = 'border-left';");

		$wpdb->query("UPDATE $elements_table SET property = 'top-border-width' WHERE property = 'border-top-width';");
		$wpdb->query("UPDATE $elements_table SET property = 'right-border-width' WHERE property = 'border-right-width';");
		$wpdb->query("UPDATE $elements_table SET property = 'bottom-border-width' WHERE property = 'border-bottom-width';");
		$wpdb->query("UPDATE $elements_table SET property = 'left-border-width' WHERE property = 'border-left-width';");
			
	
		headway_update_option('upgrade-155', 'true');
	}

	if(!headway_get_option('upgrade-16', true, true)){
		
		global $wpdb;
		
		$headway_leafs_table = $wpdb->prefix.'headway_leafs';
		$elements_table = $wpdb->prefix.'headway_elements';

		$leafs = $wpdb->get_results("SELECT * FROM $headway_leafs_table", ARRAY_A);	
	
		foreach($leafs as $leaf){
			$config = maybe_unserialize($leaf['config']);

			$config['title'] = base64_encode($config['title']);

			headway_update_leaf($leaf['id'], false, $config);
		}
			
		$wpdb->query("UPDATE $elements_table SET element = 'div-period-headway-leaf' WHERE element = 'div-period-box';");
		
		
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'color', 'border-top', '999999');
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'color', 'border-bottom', '999999');
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'color', 'color', '666666');
		
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'sizing', 'border-top-width', '1');
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'sizing', 'border-bottom-width', '1');
		
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'font', 'font-family', 'verdana, sans-serif');
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'font', 'font-size', '12');
		headway_update_element_style(headway_selector_to_form_name('div.entry-content blockquote'), 'font', 'line-height', '20');

		
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback'), 'color', 'color', '444444');		
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback'), 'font', 'font-family', 'verdana, sans-serif');
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback'), 'font', 'font-size', '16');
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback'), 'font', 'line-height', '16');

		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback-url'), 'color', 'color', '777777');		
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback-url'), 'font', 'font-family', 'verdana, sans-serif');
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback-url'), 'font', 'font-size', '10');
		headway_update_element_style(headway_selector_to_form_name('div#trackback-box span#trackback-url'), 'font', 'line-height', '12');
		
		headway_update_option('enable-developer-mode', headway_get_option('disable-visual-editor'));
		headway_delete_option('disable-visual-editor');
		
		headway_update_option('sub-nav-width', '250');
		
		headway_update_option('print-css', 'on');
		
		headway_update_option('seo-slugs', 'on');
		headway_update_option('seo-slug-bad-words', base64_decode('YQ0KYW4NCmFsc28NCmFuZA0KYW5vdGhlcg0KYXJlDQpmZWF0dXJlZA0KaW4NCmlzDQppdA0KbmV3DQpvdXINCnBhZ2UNCnRoZQ0KdGhpcw0KdG8NCnRvcA0KdXMNCndlDQp3aGF0DQp3aXRoDQp5b3U='));
		
		if(headway_get_option('disable-header-resizing')){
			headway_delete_option('enable-header-resizing');
		} else {
			headway_update_option('enable-header-resizing', 'true');
		}
		
		// Create the first sizing property.  Without this, the visual editor won't load due to JSON screw up. 
		if(!headway_get_element_styles(false, 'sizing')){
			global $wpdb;
			$headway_elements_table = $wpdb->prefix.'headway_elements';
			$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('wrapper', 'sizing', 'border-all-width', '3');");  
		}

		// Create navigation position option.
		if(!headway_get_option('navigation-position')){
			headway_update_option('navigation-position', 'left');
		}

		if(!headway_get_option('post-thumbnail-width')){
			headway_update_option('post-thumbnail-width', '200');
		}

		if(!headway_get_option('post-thumbnail-height')){
			headway_update_option('post-thumbnail-height', '200');
		}

		if(!headway_get_option('read-more-text')){
			headway_update_option('read-more-text', 'Read the full article &raquo;');
		}


		// Add permissions for visual editor and user roles.
		if(!headway_get_option('permissions-visual-design-editor')) headway_update_option('permissions-visual-design-editor', 9);
		if(!headway_get_option('permissions-site-configuration')) headway_update_option('permissions-site-configuration', 9);
		if(!headway_get_option('permissions-leafs')) headway_update_option('permissions-leafs', 9);
		if(!headway_get_option('permissions-navigation')) headway_update_option('permissions-navigation', 9);
		if(!headway_get_option('permissions-headway-configuration')) headway_update_option('permissions-headway-configuration', 9);
		if(!headway_get_option('permissions-advanced-leafs')) headway_update_option('permissions-advanced-leafs', 9);
		if(!headway_get_option('permissions-easy-hooks')) headway_update_option('permissions-easy-hooks', 9);
		
		
		headway_update_option('upgrade-16', 'true');
	}
	
	if(!headway_get_option('upgrade-161', true, true)){
		global $wpdb;
		$headway_options_table = $wpdb->prefix.'headway_options';
		
		$wpdb->query("ALTER TABLE `$headway_options_table` CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		
		// Create uploads folder and other Headway uploads folders if they don't exist.
		headway_make_uploads_folders();
		
		headway_clear_cache();
		
		headway_update_option('upgrade-161', 'true');
	}
	
	return true;
}

add_action('init', 'headway_upgrade', 6);