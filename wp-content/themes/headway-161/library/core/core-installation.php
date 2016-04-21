<?php
/**
 * Sets up the Headway tables and fills data.
 * 
 * @package Headway
 * @subpackage Installation and Upgrading
 * @author Clay Griffiths
 * 
 * @todo DE-SUCK
 **/


/**
 * Creates the tables and starts the elements table off with some data.
 * 
 * @global object $wpdb
 **/
function headway_build_tables(){
	global $wpdb;
		
	$headway_elements_table = $wpdb->prefix.'headway_elements';
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	$headway_options_table = $wpdb->prefix.'headway_options';
	$headway_misc_table = $wpdb->prefix.'headway_misc';

		$create_elements_table = "CREATE TABLE `$headway_elements_table` (
			  `id` int(11) NOT NULL auto_increment,
			  `element` varchar(100) NOT NULL,
			  `property_type` varchar(10) NOT NULL,
			  `property` varchar(100) NOT NULL,
			  `value` varchar(100) NOT NULL,
			  PRIMARY KEY  (`id`)
			) COLLATE utf8_general_ci ;";
			
		$create_leafs_table = "CREATE TABLE `$headway_leafs_table` (
			  `id` int(11) NOT NULL auto_increment,
			  `system_page` tinyint(1) NOT NULL,
			  `page` varchar(255) NOT NULL,
			  `position` int(11) NOT NULL,
			  `config` text NOT NULL,
			  `options` text NOT NULL,
			  PRIMARY KEY  (`id`)
			) COLLATE utf8_general_ci ;";
		
		$create_misc_table = "CREATE TABLE `$headway_misc_table` (
			  `id` int(11) NOT NULL auto_increment,
			  `type` varchar(50) NOT NULL,
			  `parent_id` int(11) NOT NULL,
			  `content` text NOT NULL,
			  `timestamp` varchar(255) NOT NULL,
			  PRIMARY KEY  (`id`)
			) COLLATE utf8_general_ci ;";
			
		$create_options_table = "CREATE TABLE `$headway_options_table` (
			  `id` int(11) NOT NULL auto_increment,
			  `option` varchar(255) NOT NULL,
			  `value` text NOT NULL,
			  PRIMARY KEY  (`id`)
			) COLLATE utf8_general_ci ;";
				
		$wpdb->query($create_elements_table);
		$wpdb->query($create_leafs_table);
		$wpdb->query($create_misc_table);
		$wpdb->query($create_options_table);

		
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('wrapper', 'sizing', 'border-all-width', '3');");		
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'line-height', '38');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'font-size', '34');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_liwidget', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'color', 'border-right', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('wrapper', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('wrapper', 'color', 'border-all', 'c3c3c3');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('body', 'color', 'background', 'cfcfcf');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'color', 'color', 'bfbfbf');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'color', 'border-bottom', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'color', 'border-bottom', 'aaaaaa');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('box', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('box', 'color', 'border-all', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-content', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('rotator-images', 'color', 'border-all', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('post', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title_a', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content', 'color', 'color', '5c5c5c');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'color', 'color', '888888');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta_a', 'color', 'color', '888888');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'color', 'color', '777777');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'line-height', '22');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'font-size', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'color', 'color', '707070');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'color', 'color', '585858');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer_a', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'color', 'border-right', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'color', 'border-top', 'dddddd');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'font-size', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'line-height', '19');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'text-transform', 'uppercase');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-content', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-content', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-content', 'font', 'line-height', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'font-size', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'line-height', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content', 'font', 'font-size', '13');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content', 'font', 'line-height', '22');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'font-size', '11');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'font-size', '13');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'font-size', '13');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_liwidget', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_liwidget', 'font', 'font-size', '13');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_liwidget', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'font-size', '17');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'line-height', '22');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'text-transform', 'uppercase');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('footer', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h1tagline', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-link-text-inside', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top', 'font', 'letter-spacing', '2px');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs_a', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-meta', 'font', 'font-variant', 'small-caps');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulnavigation_li-period-current_page_item_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'color', 'color', '525252');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'line-height', '26');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'font-size', '14');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption', 'color', 'border-all', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'color', 'color', '555555');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'color', 'background', 'dedede');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-below_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'color', 'color', '555555');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption', 'color', 'background', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('leaf-top_a', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('rotator-images_img', 'color', 'border-all', 'd4d4d4');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'color', 'color', '555555');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'color', 'color', '777777');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulthumbs_li-period-selected_athumb', 'color', 'background', '444444');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulthumbs_li-period-selected_athumb', 'color', 'border-all', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulthumbs_li_a-period-thumb', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ulthumbs_li_a-period-thumb', 'color', 'border-all', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('slideshow_aadvance-link', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('slideshow_aadvance-link', 'color', 'border-all', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'color', 'color', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'color', 'color', '444444');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'color', 'border-all', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'line-height', '14');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'color', 'background', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'color', 'border-all', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist_li-period-comment', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'line-height', '14');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-container', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'line-height', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('ss-controls_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'line-height', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('nav-controls_a', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'font-size', '19');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'line-height', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_h4', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('caption_p', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'font', 'letter-spacing', '2px');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'font-size', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('header-container', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation-container', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation-container', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'color', 'border-bottom', 'eeeeee');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'line-height', '13');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('breadcrumbs-container', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'color', 'color', '3b3b3b');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'line-height', '20');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_a', 'color', 'color', '444444');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'font-size', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'color', 'background', 'dedede');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'line-height', '20');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('amore-link', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('navigation_divpagination_span-period-current', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'font-size', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'line-height', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('page-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist', 'color', 'border-bottom', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'line-height', '26');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h3entry-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist_li-period-comment', 'color', 'border-bottom', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'font-size', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'line-height', '24');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('h2entry-title_h1-period-entry-title', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist_li-period-even', 'color', 'border-bottom', 'cccccc');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('olcommentlist_li-period-even', 'color', 'background', 'f3f3f3');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'color', 'color', '000000');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author_a', 'color', 'color', '000000');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('comment-date', 'color', 'color', '888888');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('comment-body', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'color', 'border-all', 'e8e8e8');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box', 'color', 'border-all', 'dddddd');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box', 'color', 'background', 'f9f9f9');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'color', 'color', '666666');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'color', 'color', '757575');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'font-size', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'line-height', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spanheading', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'font-size', '17');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'line-height', '17');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('spancomment-author', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'font-size', '11');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'line-height', '14');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-date', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'line-height', '20');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('divcomment-body', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'font-family', 'georgia, serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'font-size', '6');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'line-height', '6');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('imgavatar', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'font-size', '16');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'line-height', '20');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'font-size', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'line-height', '12');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('trackback-box_spantrackback-url', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_a', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'color', 'color', '333333');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'color', 'color', '336699');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'color', 'background', 'ffffff');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('sidebar_spanwidget-title', 'color', 'border-bottom', 'c3c3c3');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'font-size', '22');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'line-height', '22');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h2', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'font-size', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'line-height', '18');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h3', 'font', 'font-variant', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'font-family', 'verdana, sans-serif');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'font-size', '15');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'line-height', '15');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'font-weight', 'normal');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'text-transform', 'none');");
		$wpdb->query("INSERT INTO `$headway_elements_table` (`element`, `property_type`, `property`, `value`) VALUES('entry-content_h4', 'font', 'font-variant', 'normal');");
		
}


/**
 * Creates the content and sidebar leaf for the specified page.
 *
 * @param mixed $page
 * @param mixed $page_404_id The ID of the Whoops 404 Page!
 **/
function headway_create_default_leafs($page, $page_404_id = false){
	if($page == 'index'){
		headway_add_leaf('index', 1, array(
			'type' => 'content',
			'title' => 'Content',
			'show-title' => false,
			'title-link' => false,
			'width' => 640,
			'height' => 115,
			'fluid-height' => true,
			'align-right' => false,
			'custom-classes' => false
		), array(
			'mode' => 'page',
			'other-page' => false,
			'categories-mode' => 'include',
			'post-limit' => get_option('posts_per_page'),
			'featured-posts' => 1,
			'paginate' => true
		));
		
		headway_add_leaf('index', 2, array(
			'type' => 'sidebar',
			'title' => 'Primary Sidebar',
			'show-title' => false,
			'title-link' => false,
			'width' => 250,
			'height' => 115,
			'fluid-height' => true,
			'align-right'=> false,
			'custom-classes' => false
		), array(
			'duplicate-id' => false,
			'sidebar-name' => 'Primary Sidebar'
		));
	} elseif($page == 'four04'){
		
		headway_add_leaf('four04', 1, array(
			'type' => 'content',
			'title' => 'Content',
			'show-title' => false,
			'title-link' => false,
			'width' => 640,
			'height' => 115,
			'fluid-height' => true,
			'align-right' => false,
			'custom-classes' => false
		), array(
			'mode' => 'page',
			'other-page' => $page_404_id,
			'categories-mode' => 'include',
			'post-limit' => get_option('posts_per_page'),
			'featured-posts' => 1,
			'paginate' => true
		));
	
		headway_add_leaf('four04', 2, array(
			'type' => 'sidebar',
			'title' => 'Primary Sidebar',
			'show-title' => false,
			'title-link' => false,
			'width' => 250,
			'height' => 115,
			'fluid-height' => true,
			'align-right'=> false,
			'custom-classes' => false
		), array(
			'duplicate-id' => 2
		));
		
	} elseif(is_int($page)){
		
		headway_add_leaf($page, 1, array(
			'type' => 'content',
			'title' => 'Content',
			'show-title' => false,
			'title-link' => false,
			'width' => 920,
			'height' => 115,
			'fluid-height' => true,
			'align-right' => false,
			'custom-classes' => false
		), array(
			'mode' => 'page',
			'other-page' => false,
			'categories-mode' => 'include',
			'post-limit' => get_option('posts_per_page'),
			'featured-posts' => 1,
			'paginate' => true
		));
		
	} else {
		
		headway_add_leaf($page, 1, array(
			'type' => 'content',
			'title' => 'Content',
			'show-title' => false,
			'title-link' => false,
			'width' => 640,
			'height' => 115,
			'fluid-height' => true,
			'align-right' => false,
			'custom-classes' => false
 		), array(
			'mode' => 'page',
			'other-page' => false,
			'categories-mode' => 'include',
			'post-limit' => get_option('posts_per_page'),
			'featured-posts' => 1,
			'paginate' => true
		));
		
		headway_add_leaf($page, 2, array(
			'type' => 'sidebar',
			'title' => 'Primary Sidebar',
			'show-title' => false,
			'title-link' => false,
			'width' => 250,
			'height' => 115,
			'fluid-height' => true,
			'align-right'=> false,
			'custom-classes' => false
		), array(
			'duplicate-id' => 2
		));
		
	}
	

}


/**
 * Runs all the functions in the core-installation.php file and starts adding options to the database.
 * 
 * @global object $wpdb
 **/
function headway_install(){
	if(!headway_get_option('headway_installed')){
	
		headway_build_tables();
	
		headway_update_option('gzip', 1);
		headway_update_option('site-style', 'headway');
		headway_update_option('header-order', array('header', 'navigation', 'breadcrumbs'));
		headway_update_option('show-navigation', 'on');
		headway_update_option('show-breadcrumbs', 'on');
		headway_update_option('header-image-margin', '0px');
		headway_update_option('header-style', 'fixed');
		headway_update_option('show-tagline', 'on');
		headway_update_option('wrapper-width', 950);
		headway_update_option('wrapper-margin', '30px auto 30px auto');
		headway_update_option('home-link-text', 'Home');
		headway_update_option('footer-style', 'fixed');

		headway_update_option('post-date-format', '1');
		headway_update_option('post-comment-format-0', '%num% Comments');
		headway_update_option('post-comment-format-1', '%num% Comment');
		headway_update_option('post-comment-format', '%num% Comments');
		headway_update_option('post-respond-format', 'Leave a comment!');
		
		headway_add_option('post-above-title-left', '');
		headway_add_option('post-above-title-right', '');
		headway_update_option('post-below-title-left', 'Posted by %author% in %categories%');
		headway_update_option('post-below-title-right', '%comments% - %respond%');
		headway_update_option('post-below-content-left', '%tags%');
		headway_update_option('post-below-content-right', '%edit%');
		
		headway_update_option('featured-posts', 1);
		headway_update_option('show-avatars', 'on');
		headway_update_option('avatar-size', 48);
			
		headway_update_option('show-admin-link', 'on');
		headway_update_option('show-edit-link', 'on');
		headway_update_option('show-go-to-top-link', 'on');
		headway_update_option('show-copyright', 'on');
		
		headway_update_option('show-navigation-subpages', 'on');
		
		headway_update_option('title-home', '%tagline% | %blogname%');
		headway_update_option('title-page', '%page% | %blogname%');
		headway_update_option('title-posts-page', 'Blog | %blogname%');
		headway_update_option('title-single', '%postname% | %blogname%');
		headway_update_option('title-404', 'Whoops! 404 Error | %blogname%');
		headway_update_option('title-category', '%category% | %blogname%');
		headway_update_option('title-tag', '%tag% | %blogname%');
		headway_update_option('title-archives', '%archive% | %blogname%');
		headway_update_option('title-search', 'Search For: %search% | %blogname%');
		headway_update_option('title-author-archives', '%author_name% | %blogname%');
	
		headway_update_option('categories-meta', 1);
		headway_update_option('tags-meta', 1);
		headway_update_option('canonical', 1);
		headway_update_option('nofollow-comment-author', 1);
		headway_update_option('nofollow-home', 1);
		headway_update_option('canonical', 1);
		headway_update_option('noindex-category-archives', 0);
		headway_update_option('noindex-archives', 0);
		headway_update_option('noindex-tag-archives', 0);
		headway_update_option('noindex-author-archives', 0);
	
		headway_update_option('tweet-format', 'New at %blogname%: %postname% %url%');


		// Update existing pages
		$update_navigation = new WP_Query('post_type=page');
		while ($update_navigation->have_posts()) : $update_navigation->the_post();
			headway_create_default_leafs($update_navigation->post->ID);
		endwhile;
		
		// Set Up 404s
		if(!get_option('headway_new_installed')){
			$page_404 = array();
			$page_404['post_title'] = 'Whoops! 404 Error!';
			$page_404['post_content'] = 'Well, it appears as if you entered in an invalid URL.  Please fix the URL you entered or try using the search functionality on our website.';
			$page_404['post_status'] = 'publish';
			$page_404['post_author'] = 1;
			$page_404['post_type'] = 'page';

			$page_404_id = wp_insert_post( $page_404 );		
		
			headway_update_option('excluded_pages', array($page_404_id));
			
			add_option('headway_new_installed', 'true');
		}
		
		
		// Create leafs	
		headway_create_default_leafs('index');
		headway_create_default_leafs('four04', $page_404_id);
		headway_create_default_leafs('archives');
		headway_create_default_leafs('author');
		headway_create_default_leafs('search');
		headway_create_default_leafs('category');
		headway_create_default_leafs('single');
		headway_create_default_leafs('tag');
		
	
		// Create a time reference for stylesheets to be loaded off of.
		headway_update_option('css-last-updated', mktime());
	
	
		// Tell the DB that installation is complete.
		headway_update_option('headway_installed', 1);
			
	}


	return true;
}

// Hook the install to WordPress.
add_action('init', 'headway_install', 5);