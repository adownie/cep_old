<?php
    /* 
    Plugin Name: Font Controller
    Plugin URI: http://bjetdesign.com/blog/?p=63
    Description: Places a small font size controller in the footer of your blog 
    Author: BJET Design
    Version: 3.0.0 
    Author URI: http://www.bjetdesign.com/
    */

    function fontController_sortDependencys(){
    	$font_controller_path = WP_PLUGIN_URL.'/font-controller/js/';
        wp_register_script('fontController', $font_controller_path.'jquery.fontsize.js');
        wp_register_script('fontControllerPlugin', $font_controller_path.'main.js');
        wp_enqueue_script('jquery');
        wp_enqueue_script('fontController');
        wp_enqueue_script('fontControllerPlugin');
    }

    function fontController_injectToFooter(){
        if (get_option('fontcontroller_footer') == 'yes'){
		$font_controller_path = WP_PLUGIN_URL.'/font-controller/img/';
		echo '<div align="center" class="fontmanager">';
		echo '<a class="fontsizemanager_add" title="Increase font size"><img src="'.$font_controller_path.'smooth/zoomin16.png" alt="+" /></a>';
		echo '<a class="fontsizemanager_reset" title="Reset font size"><img src="'.$font_controller_path.'smooth/refresh16.png" alt="(reset)" /></a>';
		echo '<a class="fontsizemanager_minus" title="Decrease font size"><img src="'.$font_controller_path.'smooth/zoomout16.png" alt="-" /></a>';
		echo '</div>';
        }
    }

    function fontController_injectToSidebar(){
        if (get_option('fontcontroller_sidebar') == 'yes'){
		$font_controller_path = WP_PLUGIN_URL.'/font-controller/img/';
		echo '<div align="center" class="fontmanager">';
		echo '<a class="fontsizemanager_add" title="Increase font size"><img src="'.$font_controller_path.'smooth/zoomin.png" alt="+" /></a>';
		echo '<a class="fontsizemanager_reset" title="Reset font size"><img src="'.$font_controller_path.'smooth/refresh.png" alt="(reset)" /></a>';
		echo '<a class="fontsizemanager_minus" title="Decrease font size"><img src="'.$font_controller_path.'smooth/zoomout.png" alt="-" /></a>';
		echo '</div>';
        }
    }

    function fontController_place($style = 'smooth'){
		$font_controller_path = WP_PLUGIN_URL.'/font-controller/img/';
		echo '<div align="center" class="fontmanager">';
		echo '<a class="fontsizemanager_add" title="Increase font size"><img src="'.$font_controller_path.$style.'/zoomin.png" alt="+" /></a>';
		echo '<a class="fontsizemanager_reset" title="Reset font size"><img src="'.$font_controller_path.$style.'/refresh.png" alt="(reset)" /></a>';
		echo '<a class="fontsizemanager_minus" title="Decrease font size"><img src="'.$font_controller_path.$style.'/zoomout.png" alt="-" /></a>';
		echo '</div>';
    }
	
	function fontController_filterData($content){
		$font_controller_path = WP_PLUGIN_URL.'/font-controller/img/';
		$style = 'smooth';
		$element = '<div class="fontmanager"><a class="fontsizemanager_add" title="Increase font size"><img src="'.$font_controller_path.$style.'/zoomin.png" alt="+" /></a><a class="fontsizemanager_reset" title="Reset font size"><img src="'.$font_controller_path.$style.'/refresh.png" alt="(reset)" /></a><a class="fontsizemanager_minus" title="Decrease font size"><img src="'.$font_controller_path.$style.'/zoomout.png" alt="-" /></a></div>';
		$element2 = '<div class="fontmanager"><a class="fontsizemanager_add" title="Increase font size"><img src="'.$font_controller_path.$style.'/zoomin16.png" alt="+" /></a><a class="fontsizemanager_reset" title="Reset font size"><img src="'.$font_controller_path.$style.'/refresh16.png" alt="(reset)" /></a><a class="fontsizemanager_minus" title="Decrease font size"><img src="'.$font_controller_path.$style.'/zoomout16.png" alt="-" /></a></div>';

		$content = str_replace('[fontcontroller]',$element,$content);
		$content = str_replace('[fontcontroller=small]',$element2,$content);
		return $content;
	}

    function fontcontroller_widget($args) {
        extract($args);
        echo $before_widget;
        echo $before_title.'Font Controller'.$after_title;
        echo '<p>';
        fontController_place();
        echo '</p>';
        echo $after_widget;
    }

    add_action('init', 'fontController_sortDependencys');
    add_action('get_sidebar', 'fontController_injectToSidebar');
    add_action('wp_footer', 'fontController_injectToFooter');
	
    add_filter('the_content', 'fontController_filterData');
    add_filter('get_sidebar', 'fontController_filterData');
    add_filter('get_footer', 'fontController_filterData');
    add_filter('get_header', 'fontController_filterData');

    register_sidebar_widget('Font Controller','fontcontroller_widget');


    add_action('admin_menu', 'fontcontroller_plugin_menu');
    add_action('admin_init', 'fontcontroller_admin_init');

    function fontcontroller_admin_init(){
        register_setting( 'fontcontroller_ops', 'fontcontroller_footer' );
        register_setting( 'fontcontroller_ops', 'fontcontroller_sidebar' );
        register_setting( 'fontcontroller_ops', 'fontcontroller_style' );
    }

    function fontcontroller_plugin_menu() {
        add_options_page('Font-Controller', 'Font-Controller', 'manage_options', 'fontcontroller_settings','fontcontroller_settings');
    }

    function fontcontroller_settings(){
        include('settings.php');
    }
?>