<?php
require 'admin-write.php';
require 'admin-form-functions.php';



add_action('admin_menu', 'headway_add_menus');

function headway_add_menus() {
	$permissions_headway_config = (headway_get_option('permissions-headway-configuration')) ? headway_get_option('permissions-headway-configuration') : 9;
	$permissions_advanced_leafs = (headway_get_option('permissions-advanced-leafs')) ? headway_get_option('permissions-advanced-leafs') : 9;
	$permissions_easy_hooks = (headway_get_option('permissions-easy-hooks')) ? headway_get_option('permissions-easy-hooks') : 9;
	$permissions_visual_design_editor = (headway_get_option('permissions-visual-design-editor')) ? headway_get_option('permissions-visual-design-editor') : 9;

	
	$headway_menu = add_menu_page('Headway Configuration', 'Headway', $permissions_headway_config, 'headway', 'headway_configuration', HEADWAYURL.'/library/admin/icons/headway_16.png'); 
	add_action( "admin_print_scripts-$headway_menu", 'headway_configuration_head' );

	$configuration_page = add_submenu_page('headway', 'Configuration', 'Configuration', $permissions_headway_config, 'headway', 'headway_configuration');
	add_action( "admin_print_scripts-$configuration_page", 'headway_configuration_head' );

	$advanced_leafs_page = add_submenu_page('headway', 'Advanced Leafs', 'Advanced Leafs', $permissions_advanced_leafs, 'headway-advanced-leafs', 'headway_advanced_leafs');
	add_action( "admin_print_scripts-$advanced_leafs_page", 'headway_advanced_leafs_head' );

	$hooks_page = add_submenu_page('headway', 'Easy Hooks', 'Easy Hooks', $permissions_easy_hooks, 'headway-easy-hooks', 'headway_easy_hooks');
	add_action( "admin_print_scripts-$hooks_page", 'headway_easy_hooks_head' );
	
	$visual_editor_page = add_submenu_page('headway', 'Visual Editor', 'Visual Editor', $permissions_visual_design_editor, 'headway-visual-editor', 'headway_visual_editor_forward' );
	add_action( "admin_print_scripts-$visual_editor_page", 'headway_configuration_head' );
	
}

function headway_configuration_head(){	
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/admin/css/admin.css" type="text/css" media="all" />'."\n";
	
	wp_enqueue_script('headway_jquery_ui', get_bloginfo('template_directory').'/library/admin/js/jquery.ui.js', array('jquery'));
	wp_enqueue_script('headway_admin', get_bloginfo('template_directory').'/library/admin/js/admin.js', array('jquery'));
}


function headway_advanced_leafs_head(){	
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/admin/css/admin.css" type="text/css" media="all" />'."\n";
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/admin/css/admin-advanced-leafs.css" type="text/css" media="all" />'."\n";

	
	wp_enqueue_script('headway_jquery_ui', get_bloginfo('template_directory').'/library/admin/js/jquery.ui.js', array('jquery'));
	wp_enqueue_script('headway_admin', get_bloginfo('template_directory').'/library/admin/js/admin.js', array('jquery'));
}


function headway_admin_css(){
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/admin/css/admin-all.css" type="text/css" media="all" />'."\n";
}
add_action('admin_head', 'headway_admin_css');

function headway_easy_hooks_head(){
	echo '<link rel="stylesheet" href="'.get_bloginfo('template_directory').'/library/admin/css/admin.css" type="text/css" media="all" />'."\n";
	
	wp_enqueue_script('headway_admin', get_bloginfo('template_directory').'/library/admin/js/easy-hooks.js', array('jquery'));
}


function headway_admin_header(){
	echo '<div id="wrapper" class="wrap">';
	echo '<div id="headway-admin-top">
			<a href="http://www.headwaythemes.com/documentation">Headway Documentation</a>
			<a href="http://www.headwaythemes.com/members/support">Headway Support Forums</a>
			<a href="http://www.headwaythemes.com/documentation/faqs">Headway FAQs</a>
		 </div><div class="icon32" id="icon-headway"><br />'."\n".'</div>';
}

function headway_admin_footer(){
	echo '</div> <!-- #wrapper -->';
}




function headway_configuration(){
	headway_admin_header();
		include 'admin-configuration.php';	
	headway_admin_footer();
}

function headway_advanced_leafs(){
	headway_admin_header();
		include 'admin-advanced-leafs.php';	
	headway_admin_footer();
}

function headway_easy_hooks(){
	headway_admin_header();
		include 'admin-easy-hooks.php';
	headway_admin_footer();
}

function headway_visual_editor_forward(){
	headway_admin_header();
		echo '<h2>Headway Visual Editor</h2>';
		echo 'You are now being redirected, if you are not directed within 3 seconds, click <a href="'.get_bloginfo('wpurl').'/?visual-editor=true"><strong>here</strong></a>.';
		echo '<meta http-equiv="refresh" content="0;URL='.get_bloginfo('wpurl').'/?visual-editor=true">';
	headway_admin_footer();
}

function headway_update_notice(){
	$latest_version = wp_remote_get('http://headwaythemes.com/latest_version.txt', array('timeout' => 2));
				
	if(is_array($latest_version)){
		if(headway_versionify($latest_version['body']) > headway_versionify(HEADWAYVERSION)){
			
			echo '<div id="update-nag">Headway '.$latest_version['body'].' is available, you\'re running '.HEADWAYVERSION.'!  Head over to the Headway site to <a href="http://headwaythemes.com/members" target="_blank">update now</a>!</div>';
		}
	}
}
add_action('admin_notices', 'headway_update_notice');