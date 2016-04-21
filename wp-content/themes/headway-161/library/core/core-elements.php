<?php
/**
 * Elements and functions for the visual editor.
 *
 * @package Headway
 * @subpackage Visual Editor Elements
 * @author Clay Griffiths
 **/


/**
 * Returns all of the elements Headway uses in array format.
 * 
 * @return array
 **/
function headway_get_elements(){
	$elements_array = array(		
			'Site' => array(
				array(
					'body',
				   	'Body',   
				   	array('background')
				), 

				array(
					'div#wrapper',
				   	'Wrapper',
				   	array('background', 'border')
				)
			),    

			'Header' => array(                                                     
				array(
					'div#header',
				    'Header',  
				    array('background', 'bottom-border'),
					false,
					false,
					'body.header-fluid div#header, body.header-fixed div#header'
				),
				
				array(
					'div#header-container',
					'Header Container (Fluid Only)',
					array('background', 'bottom-border'),
					false,
					false,
					'body.header-fluid div#header-container'
				),    

				array(
					'h1#tagline',
					'Tagline',
					array('color'),
					true,
					true
				),
				
				array(
					'.header-link-text-inside',
					'Header Site Name',
					array('color', 'bottom-border'),
					true,
					true,
					'a.header-link-text-inside'
				)
			),
			
			'Navigation' => array(        
				array(
					'div#navigation',
					'Navigation',
					array('background', 'bottom-border'),
					false,
					false,
					'body.header-fluid div#navigation, body.header-fixed div#navigation'
				),
				
				array(
					'div#navigation-container',
					'Navigation Container (Fluid Only)',
					array('background', 'bottom-border'),
					false,
					false,
					'body.header-fluid div#navigation-container'
				),
				
				array(
					'ul.navigation li a',
					'Navigation Item',
					array('color', 'background', 'right-border'),
					true,
					true,
					'ul.navigation li a, ul.navigation li ul'
				),
				    
				array(
					'ul.navigation li.current_page_item a',
					'Navigation Item &mdash; Active',
					array('color', 'background', 'right-border'),
					true,
					true,
					'ul.navigation li.current_page_item a, ul.navigation li.current-menu-item a, ul.navigation li.current_page_item ul, ul.navigation li.current_page_parent a, ul.navigation li.current_page_parent ul, ul.navigation li.current_page_ancestor a, ul.navigation li.current_page_ancestor ul'
				)
			),
				
			'Breadcrumbs' => array(
				array(
					'div#breadcrumbs',
					'Breadcrumbs',
					array('color', 'background', 'bottom-border'),
					true,
					true,
					'body.header-fixed div#breadcrumbs, body.header-fluid div#breadcrumbs'
				),
				
				array(
					'div#breadcrumbs-container',
					'Breadcrumbs Container (Fluid Only)',
					array('background', 'bottom-border')
				),
				
				array(
					'div#breadcrumbs a',
					'Breadcrumbs Hyperlinks',
					array('color'),
					false,
					false,
					'div#breadcrumbs a'
				)
			),
			
			'Leafs' => array(
				array(
					'div.leaf-top',
					'Leaf Titles',
					array('color', 'background', 'bottom-border'),
					true,
					true,
					'.leaf-top, div.headway-leaf input.inline-title-edit'
				),
				
				array(
					'div.leaf-top a',
					'Leaf Titles &mdash; Hyperlinks',
					array('color'),
					false,
					false,
					'.leaf-top a'
				),
				
				array(
					'div.headway-leaf',
					'Leafs',
					array('background')
				),
				
				array(
					'div.leaf-content',
					'Leaf Content',
					array('color'),
					true
				)
			),

			
			'Posts/Pages' => array(
				array(
					'div.post',
					'Posts',
					array('bottom-border'),
					false,
					false,
					'div.post, div.small-excerpts-row'
				),
				
				array(
					'.page-title',
					'Page Title',
					array('color'),
					true,
					true
				),
				
				array(
					'h2.entry-title, h1.entry-title',
					'Post Title',
					array('color'),
					true,
					true
				),
				
				array(
					'h3.entry-title',
					'Post Title (Small)',
					array('color'),
					true,
					true
				),
				
				array(
					'.entry-title a',
					'Post Title (Hyperlink)',
					array('color')
				),
				
				array(
					'.entry-title a:hover',
					'Post Title (Hyperlink &mdash; Hover)',
					array('color')
				),
				
				array(
					'div.entry-content',
					'Post Content',
					array('color'),
					true
				),
				
				array(
					'div.entry-content a',
					'Post Content &mdash; Hyperlink',
					array('color')
				),
				
				array(
					'div.entry-content h2',
					'Post Content &mdash; H2',
					array('color'),
					true,
					true
				),
				
				array(
					'div.entry-content h3',
					'Post Content &mdash; H3',
					array('color'),
					true,
					true
				),
				
				array(
					'div.entry-content h4',
					'Post Content &mdash; H4',
					array('color'),
					true,
					true
				),
				
				array(
					'div.entry-content blockquote',
					'Blockquotes',
					array('color', 'top-border', 'bottom-border'),
					true,
					true
				),
				
				array(
					'div.entry-meta',
					'Post Meta',
					array('color'),
					true,
					true
				),
				
				array(
					'div.entry-meta a',
					'Post Meta &mdash; Hyperlinks',
					array('color'),
					false,
					false,
					'div.entry-meta a'
				),
				
				array(
					'a.more-link',
					'Read More Links',
					array('color', 'background'),
					true,
					true,
					'div.entry-content a.more-link'
				),
				
				array(
					'.nav-below a',
					'Next/Previous Links',
					array('color', 'background'),
					true,
					true,
					'div.nav-below div.nav-previous a, div.nav-below div.nav-next a'
				)
			),
			
			'Comments/Trackbacks' => array(
				array(
					'span.heading',
					'Comment Area Headings',
					array('color'),
					true,
					true
				),
				
				array(
					'ol.commentlist',
					'Comment Area',
					array('background', 'border')
				),
				
				array(
					'ol.commentlist li',
					'Comments',
					array('background', 'bottom-border')
				),
				
				array(
					'ol.commentlist li.even',
					'Comments (Even)',
					array('background', 'bottom-border')
				),
				
				array(
					'span.comment-author',
					'Comment Author',
					array('color'),
					true,
					true
				),
				
				array(
					'span.comment-author a',
					'Comment Author (Hyperlink)',
					array('color'),
					false,
					false,
					'span.comment-author a'
				),
				
				array(
					'div.comment-date',
					'Comment Date',
					array('color'),
					true,
					true
				),
				
				array(
					'div.comment-body',
					'Comment Content',
					array('color'),
					true,
					true
				),
				
				array(
					'img.avatar',
					'Commenter Avatar',
					array('background', 'border')
				),
				
				array(
					'div#trackback-box',
					'Trackback Box',
					array('background', 'border')
				),
				
				array(
					'div#trackback-box span#trackback',
					'Trackback Heading',
					array('color'),
					true,
					true
				),
				
				array(
					'div#trackback-box span#trackback-url',
					'Trackback URL',
					array('color'),
					true,
					true
				)
			),
			
			'Widgets' => array(
				array(
					'div.sidebar span.widget-title',
					'Widget Title',
					array('color', 'background', 'bottom-border'),
					true,
					true
				),
				
				array(
					'div.sidebar li.widget',
					'Widget Content',
					array('color'),
					true
				),
				
				array(
					'div.sidebar a',
					'Widget Content &mdash; Hyperlinks',
					array('color'),
					false,
					false,
					'div.sidebar a'
				)
			),
			
			'Leafs &mdash; Image Rotator' => array(
				array(
					'div.rotator-images img',
					'Image Rotator &mdash; Image',
					array('border')
				)
			),
			
			'Leafs &mdash; Photo Gallery' => array(
				array(
					'ul.thumbs li.selected a.thumb',
					'Photo Gallery &mdash; Selected Thumbnail',
					array('background', 'border')
				),
				
				array(
					'ul.thumbs li a.thumb',
					'Photo Gallery &mdash; Thumbnails',
					array('background', 'border')
				),
				
				array(
					'div.slideshow a.advance-link',
					'Photo Gallery &mdash; Main Photo',
					array('background', 'border')
				),
				
				array(
					'div.navigation div.pagination span.current',
					'Photo Gallery &mdash; Thumbnail Pagination Links - Active',
					array('color', 'background', 'border'),
					true				
				),
				
				array(
					'div.navigation div.pagination a',
					'Photo Gallery &mdash; Thumbnail Pagination Links',
					array('color', 'background', 'border'),
					true,
					false,
					'div.navigation div.pagination a'
				),
				
				array(
					'div.ss-controls a',
					'Photo Gallery &mdash; Slideshow Controls',
					array('color'),
					true,
					false,
					'div.ss-controls a'
				),
				
				array(
					'div.nav-controls a',
					'Photo Gallery &mdash; Photo Navigation',
					array('color'),
					true,
					false,
					'div.nav-controls a'
				),
				
				array(
					'div.caption',
					'Photo Gallery &mdash; Caption Container',
					array('background', 'border')
				),
				
				array(
					'div.caption h4',
					'Photo Gallery &mdash; Photo Title',
					array('color'),
					true,
					true
				),
				
				array(
					'div.caption p',
					'Photo Gallery &mdash; Caption',
					array('color'),
					true
				)
			),
			
			'Footer' => array(
				array(
					'div#footer',
					'Footer',
					array('color', 'background', 'top-border'),
					true,
					false,
					'body.footer-fixed div#footer, body.footer-fluid div#footer, body.footer-fluid div#footer-container'
				),
				
				array(
					'div#footer-container',
					'Footer Container (Fluid Only)',
					array('color', 'background', 'top-border'),
					false,
					false,
					'body.footer-fluid div#footer-container'
				),
				
				array(
					'div#footer a',
					'Footer &mdash; Hyperlinks',
					array('color'),
					false,
					false,
					'div#footer a'
				)
			)
	);
	
	global $headway_custom_elements;
	if($headway_custom_elements) $elements_array['Custom'] = $headway_custom_elements;
	
	return $elements_array;
}


/**
 * Returns all elements from headway_get_elements() as a single-dimension array.
 *
 * @uses headway_get_elements()
 * 
 * @return array
 **/
function headway_elements_merged(){
	$return = array();
	
	foreach(headway_get_elements() as $group => $elements){
		foreach($elements as $element){
			$return[$element[0]] = $element;
		}
	}
	
	return $return;
}


/**
 * Changes a CSS selector to an attribute-safe string.
 *
 * @param string $selector
 * 
 * @return string
 **/
function headway_selector_to_form_name($selector){
	return str_replace(',', '-comma-', str_replace('.', '-period-', str_replace('#', '-pound-', str_replace(' ', '-space-', str_replace(':', '-colon-', $selector)))));
}


/**
 * Changes the form name back to a CSS selector.
 *
 * @param string $name
 * 
 * @return string
 **/
function headway_form_name_to_selector($name){
	return str_replace('-comma-', ',', str_replace('-period-', '.', str_replace('-pound-', '#', str_replace('-space-', ' ', str_replace('-colon-', ':', $name)))));
}


/**
 * Filterable array to add fonts to the visual editor.
 **/
global $headway_custom_fonts;
$headway_custom_fonts = apply_filters('headway_custom_fonts', $headway_custom_fonts);