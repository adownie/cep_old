<?php
function headway_upgrade_leaf($leaf_config, $leaf_type, $leaf_options, $leaf_id = false, $system_page = false, $page = false){
	if($leaf_type == 'content'){
		
		$leaf_options['mode'] = ($leaf_options['mode']) ? $leaf_options['mode'] : 'page';
		
		return array(
			'mode' => $leaf_options['mode'],
			'other-page' => $leaf_options['other-page'],
			'categories-mode' => $leaf_options['categories-mode'],
			'categories' => explode(' | ', $leaf_options['categories']),
			'post-limit' => $leaf_options['post_limit'],
			'featured-posts' => $leaf_options['featured_posts'],
			'paginate' => $leaf_options['paginate']
		);
	}
	
	if($leaf_type == 'sidebar'){
		$sidebar_name = $leaf_config['title'];
		
		return array(
			'duplicate-id' => $leaf_options['duplicate-id'],
			'horizontal-sidebar' => $leaf_options['horizontal-sidebar'],
			'no-padding' => $leaf_options['no-padding'],
			'sidebar-name' => $sidebar_name
		);
	}
		
	if($leaf_type == 'rotator'){
		$images = array();
		
		if($leaf_options['image_1']) $images['1'] = array('path' => $leaf_options['image_1'], 'hyperlink' => $leaf_options['image_1_hyperlink']);
		if($leaf_options['image_2']) $images['2'] = array('path' => $leaf_options['image_2'], 'hyperlink' => $leaf_options['image_2_hyperlink']);
		if($leaf_options['image_3']) $images['3'] = array('path' => $leaf_options['image_3'], 'hyperlink' => $leaf_options['image_3_hyperlink']);
		if($leaf_options['image_4']) $images['4'] = array('path' => $leaf_options['image_4'], 'hyperlink' => $leaf_options['image_4_hyperlink']);

		return array(
			'images' => $images,
			'animation-type' => $leaf_options['animation_type'],
			'animation-speed' => $leaf_options['animation_speed'],
			'animation-timeout' => $leaf_options['animation_timeout']
		);
	}
	
	if($leaf_type == 'featured'){
		return array(
			'mode' => $leaf_options['mode'],
			'image-width' => $leaf_options['image_width'],
			'image-height' => $leaf_options['image_height'],
			'image-location' => $leaf_options['image_location'],
			'categories' => explode(' | ', $leaf_options['categories']),
			'featured-meta-title-above-left' => $leaf_options['featured-meta-title-above-left'],
			'featured-meta-title-above-right' => $leaf_options['featured-meta-title-above-right'],
			'featured-meta-title-below-left' => $leaf_options['featured-meta-title-below-left'],
			'featured-meta-title-below-right' => $leaf_options['featured-meta-title-below-right'],
			'featured-meta-content-below-left' => $leaf_options['featured-meta-content-below-left'],
			'featured-meta-content-below-right' => $leaf_options['featured-meta-content-below-right'],
			'cutoff' => $leaf_options['cutoff'],
			'read-more-text' => $leaf_options['read-more-language'],
			'rotate-posts' => $leaf_options['rotate_posts'],
			'rotate-limit' => $leaf_options['rotate_limit'],
			'animation-type' => $leaf_options['animation_type'],
			'animation-speed' => $leaf_options['animation_speed'],
			'animation-timeout' => $leaf_options['animation_timeout'],
			'next-prev-location' => $leaf_options['rotate_nav_location']
		);
	}
	
	if($leaf_type == 'feed'){
		$leaf_options['mode'] = ($leaf_options['mode'] == 'rss') ? 'feed' : 'recent';
		
		return array(
			'mode' => $leaf_options['mode'],
			'categories-mode' => $leaf_options['categories-mode'],
			'categories' => explode(' | ', $leaf_options['categories']),
			'post-limit' => $leaf_options['post-limit'],
			'post-date' => $leaf_options['show-date-post'],
			'feed-location' => $leaf_options['rss-url'],
			'item-limit' => $leaf_options['item-limit'],
			'feed-post-date' => $leaf_options['show-date-rss'],
			'nofollow-feed-links' => $leaf_options['nofollow']
		);
	}
	
	if($leaf_type == 'text'){
		if($system_page){
			$text_content = base64_encode(htmlspecialchars_decode(base64_decode(get_option('system-page-'.$page.'-'.$leaf_id.'_text'))));
		} else {
			$text_content = base64_encode(htmlspecialchars_decode(base64_decode(get_post_meta($page, '_'.$leaf_id.'_text', true))));
		}
		
		return array(
			'dynamic-content' => $leaf_options['dynamic-content'],
			'text-content' => $text_content
		);
	}
	
	if($leaf_type == 'twitter'){
		return array(
			'twitter-username' => $leaf_options['twitter-username'],
			'tweet-limit' => $leaf_options['tweet-limit'],
			'tweet-format' => $leaf_options['date_format']
		);
	}
	
	if($leaf_type == 'about'){
		return array(
			'blurb' => base64_encode($leaf_options['blurb']),
			'image' => $leaf_options['image'],
			'image-align' => $leaf_options['image-align'],
			'image-width' => $leaf_options['image-width'],
			'image-height' => $leaf_options['image-height'],
			'show-read-more' => $leaf_options['show-read-more'],
			'read-more-location' => $leaf_options['read-more-href'],
			'read-more-page' => $leaf_options['read-more-page'],
			'read-more-text' => $leaf_options['read-more-language']
		);
	}
}