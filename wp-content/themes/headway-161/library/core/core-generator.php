<?php
function headway_get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}

function headway_generate($what){
	switch($what){
		case 'headway-css':
			$return = headway_get_include_contents(HEADWAYROOT.'/media/css/utility.css');
			$return .= headway_get_include_contents(HEADWAYROOT.'/media/css/includes/layout.php');
			$return .= headway_get_include_contents(HEADWAYROOT.'/media/css/includes/headway.php');
			
			if(!headway_get_option('enable-developer-mode') && !headway_get_option('active-skin') && !isset($_GET['skin-preview']))
				$return .= headway_get_include_contents(HEADWAYROOT.'/media/css/includes/element-styling.php');
			else
				$return .= headway_get_include_contents(HEADWAYROOT.'/media/css/includes/elements-default.css');
			
			if(!headway_get_skin_option('disable-body-background-image') && headway_get_option('body-background-image', true, true)){
				$url = (strpos(headway_get_option('body-background-image', true, true), 'http') !== false) ? headway_get_option('body-background-image', true, true) : get_bloginfo('wpurl').'/wp-content/uploads/headway/background-uploads/'.rawurlencode(headway_get_option('body-background-image', true, true));
				
				$return .= '

body {
	background-image: url('.$url.');
	background-repeat: '.headway_get_option('body-background-repeat').'; }

				';
			}

		 	$return .= "\n".headway_get_option('live-css');
		break;
		
		
		
		
		
		case 'leafs-css':
			
$return = '
/* ------------------------- */
/* -------Leaf Sizing------- */
/* ------------------------- */';

			$leafs = headway_get_all_leafs();

			if(count($leafs) > 0){												    	
				foreach($leafs as $leaf){ 													// Start foreach loop for every leaf/box.
					$leaf = array_map('maybe_unserialize', $leaf);

					$leaf_config = $leaf['config'];
					$leaf_options = $leaf['options'];

					if($leaf_options['no-padding']){
						$leaf_config['width'] = $leaf_config['width'] + 18;
						$leaf_config['height'] = $leaf_config['height'] + 18;
						$no_padding[$leaf['id']] = "\n".'padding: 0;';
					}

$return .= '
	#leaf-'.$leaf['id'].' { 
		width:'.$leaf_config['width'].'px;
		height:'.$leaf_config['height'].'px;
		min-height:'.$leaf_config['height'].'px;'.$no_padding[$leaf['id']].' }';

				}
			}
		break;
		
		
		
		
		
		case 'scripts':
		
			$leafs = headway_get_all_leafs();

			if(count($leafs) > 0){					
				$return = '';
															    	
				foreach($leafs as $leaf){ 													// Start foreach loop for every leaf/box.
					$leaf = array_map('maybe_unserialize', $leaf);

					$leaf_config = $leaf['config'];
					$leaf_options = $leaf['options'];
					
					if($leaf_config['type'] == 'featured'){
						if($leaf_options['rotate-posts'] == 'on'){
							$animation_speed = $leaf_options['animation-speed']*1000;
							$animation_timeout = $leaf_options['animation-timeout']*1000;
							
							$return .= "
							jQuery(function(){
								jQuery('#leaf-$leaf[id] div.featured-leaf-content').cycle({ 
								    fx:      '".$leaf_options['animation-type']."',";
							
							if($leaf_options['next-prev-location'] == 'inside'){
								$return .= "
										prev: '.$leaf[id]_featured_prev',
										next: '.$leaf[id]_featured_next',";
							
							}elseif($leaf_options['next-prev-location'] == 'outside'){
								$return .= "		
										prev: '#$leaf[id]_featured_prev',
										next: '#$leaf[id]_featured_next',";

							}
							
							$return .= '
								    speed:    '.$animation_speed.', 
								    timeout:  '.$animation_timeout.'
								});

								if(typeof visual_editor != \'undefined\'){
									jQuery(\'a:not(a#close-editor)\').click(function(){ return false; });
								}
							});';
						}
					}

					elseif($leaf_config['type'] == 'rotator' && count($leaf_options['images']) > 1){
						$animation_speed = $leaf_options['animation-speed']*1000;
						$animation_timeout = $leaf_options['animation-timeout']*1000;
						
						$return .= "
						jQuery(function(){
							jQuery('#leaf-$leaf[id] div.rotator-images').cycle({ 
							    fx:      '".$leaf_options['animation-type']."', 
							    speed:    ".$animation_speed.", 
							    timeout:  ".$animation_timeout."
							});

							if(typeof visual_editor != 'undefined'){
								jQuery('.rotator-images a').attr('href', '#');
							}
						});";
					}
					
					elseif($leaf_config['type'] == 'gallery'){
						$return .= "
						jQuery(function(){
							jQuery('div.content').css('display', 'block');";
							
						if(!$leaf_options['disable-opacity-fade']){
							$return .= " 
							jQuery('#leaf-$leaf[id]-thumbs ul.thumbs li').css('opacity', 0.4)
								.hover(
									function () {
										jQuery(this).not('.selected').fadeTo('fast', 1.0);
									}, 
									function () {
										jQuery(this).not('.selected').fadeTo('fast', 0.4);
									}
								);";
						}

							$timeout = $leaf_options['timeout']*1000;
							$num_thumbs = $leaf_options['thumbnail-rows']*$leaf_options['thumbnail-columns'];
							$loading_margin_bottom = $leaf_config['height']-40;
							$top_pager = ($leaf_options['top-pager']) ? 'true' : 'false';
							$bottom_pager = ($leaf_options['bottom-pager']) ? 'true' : 'false';
							$ss_controls = ($leaf_options['slideshow-controls']) ? 'true' : 'false';
							$nav_controls = ($leaf_options['image-navigation']) ? 'true' : 'false';
							$autostart = ($leaf_options['autostart']) ? 'true' : 'false';

							$return .= "
								jQuery('#leaf-$leaf[id]-gallery').galleriffic('#leaf-$leaf[id]-thumbs', {
									delay:                  ".$timeout.",
									numThumbs:              ".$num_thumbs.",
									preloadAhead:           ".$leaf_options['preload'].",
									enableTopPager:         ".$top_pager.",
									enableBottomPager:      ".$bottom_pager.",
									imageContainerSel:      '#leaf-$leaf[id]-slideshow',
									controlsContainerSel:   '#leaf-$leaf[id]-controls',
									captionContainerSel:    '#leaf-$leaf[id]-caption',
									loadingContainerSel:    '#leaf-$leaf[id]-loading',
									renderSSControls:       ".$ss_controls.",
									renderNavControls:      ".$nav_controls.",
									playLinkText:           '".$leaf_options['play-link-text']."',
									pauseLinkText:          '".$leaf_options['pause-link-text']."',
									prevLinkText:           '".$leaf_options['previous-link-text']."',
									nextLinkText:           '".$leaf_options['next-link-text']."',
									nextPageLinkText:       '".$leaf_options['pager-next-text']."',
									prevPageLinkText:       '".$leaf_options['pager-previous-text']."',
									enableHistory:          false,
									autoStart:              ".$autostart.",
									onChange:               function(prevIndex, nextIndex) {
										jQuery('#leaf-$leaf[id]-thumbs ul.thumbs').children()
											.eq(prevIndex).fadeTo('fast', 0.4).end()
											.eq(nextIndex).fadeTo('fast', 1.0);
										jQuery('#leaf-$leaf[id]-loading').css('marginBottom', -".$loading_margin_bottom.");
									},
									onTransitionOut:        function(callback) {
										jQuery('#leaf-$leaf[id]-caption').fadeTo('fast', 0.0);
										jQuery('#leaf-$leaf[id]-slideshow').fadeTo('fast', 0.0, callback);
									},
									onTransitionIn:         function() {
										jQuery('#leaf-$leaf[id]-slideshow').fadeTo('fast', 1.0);
										jQuery('#leaf-$leaf[id]-caption').fadeTo('fast', 1.0);
									},
									onPageTransitionOut:    function(callback) {
										jQuery('#leaf-$leaf[id]-thumbs ul.thumbs').fadeTo('fast', 0.0, callback);
									},
									onPageTransitionIn:     function() {
										jQuery('#leaf-$leaf[id]-thumbs ul.thumbs').fadeTo('fast', 1.0);
									}
								});

						});";
					} else {
						$custom_leaf = apply_filters('headway_custom_leaf_js_'.$leaf_config['type'], $leaf);
						
						 if(!is_array($custom_leaf))
							$return .= "\n".$custom_leaf;
					}
								 
				}
			}
			
		break;
	}
		
	return trim($return);
}