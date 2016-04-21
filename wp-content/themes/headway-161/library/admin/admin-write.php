<?php
require_once HEADWAYCORE.'/core-meta-box-class.php';

$Image_Box['id'] = 'post-image';
$Image_Box['name'] = 'Post Image';
$Image_Box['options'] = array(
	array(
		'id' => 'image-alignment',
		'name' => 'Post Image Alignment',
		'type' => 'radio',
		'options' => array(
			'Right' => 'post-image-right',
			'Left' => 'post-image-left'
		),
		'description' => 'Set the placement of the post image/thumbnail for this post.'
	),
);
$Image_Box['defaults'] = array('image-alignment' => 'right');
$Image_Box['type'] = 'post';
$Image_Box = new HeadwayMetaBox($Image_Box['id'], $Image_Box['name'], $Image_Box['options'], $Image_Box['defaults'], $Image_Box['info'], $Image_Box['type']);


$Navigation_Box['id'] = 'navigation';
$Navigation_Box['name'] = 'Navigation';
$Navigation_Box['options'] = array(
	array(
		'id' => 'show_navigation',
		'name' => 'Show In Navigation Bar',
		'type' => 'show_navigation',
		'description' => 'Show this page in the navigation bar.  You can also hide navigation items using the visual editor.'
	)
);
$Navigation_Box['defaults'] = array();
$Navigation_Box['type'] = 'page';
$Navigation_Box = new HeadwayMetaBox($Navigation_Box['id'], $Navigation_Box['name'], $Navigation_Box['options'], $Navigation_Box['defaults'], $Navigation_Box['info'], $Navigation_Box['type']);


if(!class_exists('All_in_One_SEO_Pack')){
	
	$SEO_Box['id'] = 'seo';
	$SEO_Box['name'] = 'Search Engine Optimization (SEO)';
	$SEO_Box['options'] = array(
		array(
			'id' => 'title',
			'name' => 'Title',
			'type' => 'text',
			'description' => 'Custom <code>&lt;title&gt;</code> tag'
		),
		array(
			'id' => 'description',
			'name' => 'Description',
			'type' => 'textarea',
			'description' => 'Custom <code>&lt;meta&gt;</code> description'
		),
		array(
			'id' => 'keywords',
			'name' => 'Keywords',
			'type' => 'text',
			'description' => 'Custom <code>&lt;meta&gt;</code> keywords'
		),
		array(
			'id' => 'noindex',
			'name' => '<code>noindex</code> this page.',
			'type' => 'checkbox'
		),
		array(
			'id' => 'nofollow_links',
			'name' => '<code>nofollow</code> links in this page.',
			'type' => 'checkbox'
		)
	);
	$SEO_Box['defaults'] = array(
	);
	$SEO_Box['info'] = '<strong>Confused on what this is or how it works?  Head on over to the <a href="http://headwaythemes.com/documentation/in-post-options/search-engine-optimization">In-Post Options » Search Engine Optimization</a> documentation.</strong>';
	$SEO_Box['type'] = 'post';
	$SEO_Box = new HeadwayMetaBox($SEO_Box['id'], $SEO_Box['name'], $SEO_Box['options'], $SEO_Box['defaults'], $SEO_Box['info'], $SEO_Box['type']);


	$SEO_Box_Page['id'] = 'seo';
	$SEO_Box_Page['name'] = 'Search Engine Optimization (SEO)';
	$SEO_Box_Page['options'] = array(
		array(
			'id' => 'title',
			'name' => 'Title',
			'type' => 'text',
			'description' => 'Custom <code>&lt;title&gt;</code> tag'
		),
		array(
			'id' => 'description',
			'name' => 'Description',
			'type' => 'textarea',
			'description' => 'Custom <code>&lt;meta&gt;</code> description'
		),
		array(
			'id' => 'keywords',
			'name' => 'Keywords',
			'type' => 'text',
			'description' => 'Custom <code>&lt;meta&gt;</code> keywords'
		),
		array(
			'id' => 'noindex',
			'name' => '<code>noindex</code> this page.',
			'type' => 'checkbox'
		),
		array(
			'id' => 'nofollow_links',
			'name' => '<code>nofollow</code> links in this page.',
			'type' => 'checkbox'
		),
		array(
			'id' => 'nofollow_page',
			'name' => '<code>nofollow</code> navigation link to this page.',
			'type' => 'checkbox'
		),
		array(
			'id' => 'navigation_url',
			'name' => 'Redirect URL',
			'type' => 'text',
			'description' => 'Enter a destination URL that you would like this page to automatically redirect to.  <strong>This is ideal for masking affiliate links.</strong>'
		)
	);
	$SEO_Box_Page['defaults'] = array(
	);
	$SEO_Box_Page['info'] = '<strong>Confused on what this is or how it works?  Head on over to the <a href="http://headwaythemes.com/documentation/in-post-options/search-engine-optimization">In-Post Options » Search Engine Optimization</a> documentation.</strong>';
	$SEO_Box_Page['type'] = 'page';
	$SEO_Box_Page = new HeadwayMetaBox($SEO_Box_Page['id'], $SEO_Box_Page['name'], $SEO_Box_Page['options'], $SEO_Box_Page['defaults'], $SEO_Box_Page['info'], $SEO_Box_Page['type']);

}

$Dynamic_Content_Box['id'] = 'display';
$Dynamic_Content_Box['name'] = 'Display';
$Dynamic_Content_Box['options'] = array(
	array(
		'id' => 'dynamic-content',
		'name' => 'Dynamic Content',
		'type' => 'textarea',
		'description' => 'If you have a text leaf on the single posts template with dynamic content enabled, you can enter content here, such as targeted ads, and have the content of the text box vary for every post.'
	)
);
$Dynamic_Content_Box['defaults'] = array('');
$Dynamic_Content_Box['type'] = 'post';
$Dynamic_Content_Box = new HeadwayMetaBox($Dynamic_Content_Box['id'], $Dynamic_Content_Box['name'], $Dynamic_Content_Box['options'], $Dynamic_Content_Box['defaults'], $Dynamic_Content_Box['info'], $Dynamic_Content_Box['type']);


$Page_Title_Box['id'] = 'page-title';
$Page_Title_Box['name'] = 'Page Title';
$Page_Title_Box['options'] = array(
	array(
		'id' => 'custom-title',
		'name' => 'Alternate Page Title',
		'type' => 'text',
		'description' => 'Using the alternate page title, you can shorten or lengthen the title at the top of the page.  Use this if you want the page to say one thing in the navigation bar and another in the actual page.'
	),
	array(
		'id' => 'hide_title',
		'name' => 'Hide Page Title',
		'type' => 'checkbox'
	)
);
$Page_Title_Box['defaults'] = array();
$Page_Title_Box['type'] = 'page';
$Page_Title_Box = new HeadwayMetaBox($Page_Title_Box['id'], $Page_Title_Box['name'], $Page_Title_Box['options'], $Page_Title_Box['defaults'], $Page_Title_Box['info'], $Page_Title_Box['type']);


$Header_Box_Page['id'] = 'header';
$Header_Box_Page['name'] = 'Header Elements';
$Header_Box_Page['options'] = array(
	array(
		'id' => 'hide_header',
		'name' => 'Hide Header',
		'type' => 'checkbox',
		'description' => 'Hide the header for this page.'
	),
	array(
		'id' => 'hide_navigation',
		'name' => 'Hide Navigation',
		'type' => 'checkbox',
		'description' => 'Hide the navigation bar on this page.'
	),
	array(
		'id' => 'hide_breadcrumbs',
		'name' => 'Hide Breadcrumbs',
		'type' => 'checkbox',
		'description' => 'Hide the breadcrumbs on this page.'
	)
);
$Header_Box_Page['defaults'] = array(
		'hide_header' => '0',
		'hide_navigation' => '0',
		'hide_breadcrumbs' => '0'
);
$Header_Box_Page['type'] = 'page';
$Header_Box_Page = new HeadwayMetaBox($Header_Box_Page['id'], $Header_Box_Page['name'], $Header_Box_Page['options'], $Header_Box_Page['defaults'], $Header_Box_Page['info'], $Header_Box_Page['type']);



$Misc_Box['id'] = 'misc';
$Misc_Box['name'] = 'Miscellaneous';
$Misc_Box['options'] = array(
	array(
		'id' => 'post_to_twitter',
		'name' => 'Post To Twitter',
		'type' => 'checkbox',
		'description' => 'Publish this post to your Twitter stream.  You must have your Twitter credentials entered in the <a target="_blank" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=headway">Headway Configuration panel</a>.'
	),
	array(
		'id' => 'hide_breadcrumbs',
		'name' => 'Hide Breadcrumbs',
		'type' => 'checkbox',
		'description' => 'Hide the breadcrumbs on this post.'
	)
);
if(headway_get_option('post-to-twitter')){
	$Misc_Box['defaults'] = array(
		'hide_breadcrumbs' => '0',
		'post_to_twitter' => '1'
	);
} else {
	$Misc_Box['defaults'] = array(
		'hide_breadcrumbs' => '0'
	);
}
$Misc_Box['type'] = 'post';
$Misc_Box = new HeadwayMetaBox($Misc_Box['id'], $Misc_Box['name'], $Misc_Box['options'], $Misc_Box['defaults'], $Misc_Box['info'], $Misc_Box['type']);


$Template_Box['id'] = 'template_box';
$Template_Box['name'] = 'Leaf Template';
$Template_Box['options'] = array(
	array(
		'id' => 'leaf_template',
		'name' => 'Page Leafs Template',
		'type' => 'page-select',
		'description' => 'Select a page you would like to copy (link) the leafs from.  Note: This will NOT copy the actual page content.'
	),
	array(
		'id' => 'leaf_system_template',
		'name' => 'System Page Leafs Template',
		'type' => 'system-page-select',
		'description' => 'Select a system page you would like to copy (link) the leafs from.'
	)
);
$Template_Box['defaults'] = array();
$Template_Box['type'] = 'page';
$Template_Box = new HeadwayMetaBox($Template_Box['id'], $Template_Box['name'], $Template_Box['options'], $Template_Box['defaults'], $Template_Box['info'], $Template_Box['type']);



add_action('publish_post', 'headway_post_to_twitter', 10, 2);
add_action('delete_post', 'headway_delete_page_leafs');


function headway_clean_slug($data) {	
	if(!headway_get_option('seo-slugs')) return $data;
	
	//Save slug for later in case the ending slug equals nothing.
	$original_slug = $data['post_name'];
	
	$bad_words = array_map('headway_filter_array_piece', explode("\n", headway_get_option('seo-slug-bad-words')));	
		
    //If a user slug already exists, don't do anything.
	if($_POST['post_name']) return $data;

	$title = strtolower(stripslashes($data['post_title']));

	$slug = preg_replace("/&.+?;/", '', $title); //Remove HTML entities
    $slug = preg_replace("/[^a-zA-Z ]/", '', $slug); //Remove anything that isn't a letter number, or space.

	//Explode slug into array, then do an array_diff to remove bad words.
    $slug_array = array_filter(array_diff(explode(' ', $slug), $bad_words));

	//Join slug array back to a string.
	$data['post_name'] = implode('-', $slug_array);
	
	//If the slug is empty after being cleaned, revert to the original.
	if($data['post_name'] == '-' || !$data['post_name']) $data['post_name'] = $original_slug;
	
	return $data;
}
add_filter('wp_insert_post_data', 'headway_clean_slug', 0);