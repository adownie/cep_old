<?php
include 'functions.php';
include 'elements.php';
include 'content/index.php';

function visual_editor(){
	
	if(headway_can_visually_edit()){
			
		if($_GET['visual-editor'])
		{	
			wp_enqueue_script('jquery');
			
			add_action('wp', 'layout_chooser_slider_form_action');
			add_action('wp_head', 'visual_editor_head');
			add_action('wp_footer', 'visual_editor_scripts');
		
			if($_COOKIE['headway-visual-editor-ie'] || !is_ie()){
				add_action('headway_visual_editor_top', 'construct_top', 1);
				add_action('headway_before_everything', 'pre_visual_editor', 1);
			}
			else {
				add_action('headway_before_everything', 'ie_box', 1);
			}
		
		
		}
		else{
			if(!headway_get_option('hide-visual-editor-link')){
				wp_enqueue_style('headway_visual_editor_mini', get_bloginfo('template_directory').'/library/visual-editor/css/visual-editor-mini.css');
				add_action('headway_before_everything', 'visual_editor_link', 1);
			}
		}
	
		insert_visual_editor_form();
	
	}
}

function visual_editor_scripts(){	
	$elements_js = 'false';
	$leafs_js = 'false';
	$configuration_js = 'false';
	
	 if(!headway_get_option('disable-visual-editor') && !headway_get_option('enable-developer-mode') && !headway_is_skin_active() && (headway_user_level() >= headway_get_option('permissions-visual-design-editor') || current_user_can('manage_options'))) 
	 	$elements_js = 'true';
		
	if(headway_user_level() >= headway_get_option('permissions-leafs') || current_user_can('manage_options'))
		$leafs_js = 'true';
		
	if(headway_user_level() >= headway_get_option('permissions-site-configuration') || current_user_can('manage_options')) 
		$configuration_js = 'true';
				
	 echo '<script type="text/javascript" src="'.get_bloginfo('url').'/?headway-visual-editor-js=true&amp;leafs='.$leafs_js.'&amp;visual-editor='.$elements_js.'&amp;configuration='.$configuration_js.'"></script>';

	
}

function visual_editor_head(){	
	$path_to_theme = headway_relative_path();

	echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/visual-editor/css/visual-editor.css" />'."\n";
	echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/visual-editor/css/colorpicker.css" />'."\n";
	echo '<link type="text/css" rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/resources/uploadify/uploadify.css" />'."\n";
	
	$last_id = headway_get_last_leaf_id();
	
	$relative_upload_path = headway_relative_site_path();
	
	$link = (headway_get_option('leaf-template-page-'.headway_current_page(false, true)) || headway_get_option('leaf-template-system-page-'.headway_current_page(false, true)) || (get_post_meta(headway_current_page(false, true), '_leaf_template', true) && get_post_meta(headway_current_page(false, true), '_leaf_template', true) != 'DELETE') || (get_post_meta(headway_current_page(false, true), '_leaf_system_template', true) && get_post_meta(headway_current_page(false, true), '_leaf_system_template', true) != 'DELETE')) ? 'true' : 'false';
	
	$disable_editor = (!(headway_get_option('disable-visual-editor') || headway_get_option('enable-developer-mode') || headway_is_skin_active()) && (headway_user_level() < headway_get_option('permissions-visual-design-editor') || current_user_can('manage_options'))) ? 'true' : 'false';

	$disable_site_config = (headway_user_level() >= headway_get_option('permissions-site-configuration') || current_user_can('manage_options')) ? 'false' : 'true';
	$disable_leafs = (headway_user_level() >= headway_get_option('permissions-leafs') || current_user_can('manage_options')) ? 'false' : 'true';
	$disable_navigation = (headway_user_level() >= headway_get_option('permissions-navigation') || current_user_can('manage_options')) ? 'false' : 'true';
	
	$upload_path = (substr(get_option('upload_path'), 0, 1) == '/') ? get_option('upload_path') : '/'.get_option('upload_path');
	
	echo '<script type="text/javascript">
			theme_url = "'.get_bloginfo('template_directory').'";
			blog_url = "'.get_bloginfo('wpurl').'";
			wrapper_width = '.headway_get_skin_option('wrapper-width').';
			last_leaf_id = '.$last_id.';
			upload_path = "'.headway_upload_path().'";
			blog_name = "'.get_bloginfo('name').'";
			link = "'.$link.'";
			
			visual_editor = '.$disable_editor.';
			disable_site_config = '.$disable_site_config.';
			disable_leafs = '.$disable_leafs.';
			disable_navigation = '.$disable_navigation.';
		  </script>'."\n";
	
}

function construct_top(){
	loading_overlay();
			
	if(!headway_get_option('watched-intro-16')){
		intro_video();
		
		headway_update_option('watched-intro-16', 'true');
	}
	
	mass_font_change_box();
	export_box();
	live_css_box();
	save_and_link_box();
	linking_options_box();
	visual_editor_sidebar();
}

function pre_visual_editor(){
	header_uploader_box();
	body_background_uploader_box();
	switch_layout_overlay();
}

function visual_editor_link(){
	$sign = (strpos(headway_current_url(), '?')) ? '&amp;' : '?';
	$system_page = (headway_current_page(true)) ? '&amp;visual-editor-system-page='.headway_current_page(false, true) : false;
	
	if(!isset($_GET['skin-preview']))
		echo '<p id="visual-editor-link"><a href="'.headway_current_url().$sign.'visual-editor=true'.$system_page.'">Enter Visual Editor</a></p>';
}


visual_editor();