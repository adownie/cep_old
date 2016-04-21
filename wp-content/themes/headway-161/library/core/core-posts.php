<?php
function headway_post_meta($where, $above_below, $featured = false, $featured_left = false, $featured_right = false, $small_posts = false){
	if(stripslashes(headway_get_option('post-date-format')) == '1') $date_format = 'F j, Y';
	if(stripslashes(headway_get_option('post-date-format')) == '2') $date_format = 'm/d/y';
	if(stripslashes(headway_get_option('post-date-format')) == '3') $date_format = 'd/m/y';
	if(stripslashes(headway_get_option('post-date-format')) == '4') $date_format = 'M j';
	if(stripslashes(headway_get_option('post-date-format')) == '5') $date_format = 'M j, Y';
	if(stripslashes(headway_get_option('post-date-format')) == '6') $date_format = 'F j';
	if(stripslashes(headway_get_option('post-date-format')) == '7') $date_format = 'F jS';
	if(stripslashes(headway_get_option('post-date-format')) == '8') $date_format = 'F jS, Y';


	if(get_comments_number($id) == 0) $comments_format = stripslashes(headway_get_option('post-comment-format-0'));
	if(get_comments_number($id) == 1) $comments_format = stripslashes(headway_get_option('post-comment-format-1'));
	if(get_comments_number($id) > 1) $comments_format = stripslashes(headway_get_option('post-comment-format'));
		$comments_format = str_replace('%num%', get_comments_number($id), $comments_format);
	
	$respond_format = stripslashes(headway_get_option('post-respond-format'));


	$date = '<span class="entry-date published">'.get_the_time($date_format).'</span>';
	$comments = $comments_format;
	$comments_link = '<a href="'.get_comments_link().'" title="'.get_the_title().' Comments" class="entry-comments">'.$comments.'</a>';
	$respond = '<a href="'.get_permalink().'#respond" title="Respond to '.get_the_title().'" class="entry-respond">'.$respond_format.'</a>';
	$author_no_link = get_the_author();
	global $authordata;
	$author = '<a class="author-link fn nickname url" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="View all posts by '.$authordata->display_name.'">'.get_the_author().'</a>';
	$categories = get_the_category_list(', ');
	$tags = (get_the_tags() != NULL) ? get_the_tag_list('<span class="tag-links"><span>Tags:</span> ',', ','</span>') : '';
	$edit = ( current_user_can( 'edit_post', $post->ID ) ) ? '<span class="edit"><a class="post-edit-link" href="' . get_edit_post_link( $post->ID ) . '" title="' . attribute_escape( __( 'Edit post' ) ) . '">Edit</a></span>' : '';
	
	
	$meta[$where][$above_below]['left'] = (!$featured) ? stripslashes(headway_get_option('post-'.$above_below.'-'.$where.'-left')) : $featured_left;	
		$meta[$where][$above_below]['left'] = str_replace('%date%', $date, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%comments%', $comments, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%comments_link%', $comments_link, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%respond%', $respond, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%author%', $author, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%author_no_link%', $author_no_link, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%categories%', $categories, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%tags%', $tags, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('%edit%', $edit, $meta[$where][$above_below]['left']);
		
		$meta[$where][$above_below]['left'] = str_replace('#date#', $date, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#comments#', $comments, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#comments_link#', $comments_link, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#respond#', $respond, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#author#', $author, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#author_no_link#', $author_no_link, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#categories#', $categories, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#tags#', $tags, $meta[$where][$above_below]['left']);
		$meta[$where][$above_below]['left'] = str_replace('#edit#', $edit, $meta[$where][$above_below]['left']);	
	
	$meta[$where][$above_below]['right'] = (!$featured) ? stripslashes(headway_get_option('post-'.$above_below.'-'.$where.'-right')) : $featured_right;	
		$meta[$where][$above_below]['right'] = str_replace('%date%', $date, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%comments%', $comments, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%comments_link%', $comments_link, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%respond%', $respond, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%author%', $author, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%author_no_link%', $author_no_link, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%categories%', $categories, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%tags%', $tags, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('%edit%', $edit, $meta[$where][$above_below]['right']);
		
		$meta[$where][$above_below]['right'] = str_replace('#date#', $date, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#comments#', $comments, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#comments_link#', $comments_link, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#respond#', $respond, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#author#', $author, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#author_no_link#', $author_no_link, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#categories#', $categories, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#tags#', $tags, $meta[$where][$above_below]['right']);
		$meta[$where][$above_below]['right'] = str_replace('#edit#', $edit, $meta[$where][$above_below]['right']);
	
	
		
		 if($meta[$where][$above_below]['left'] || $meta[$where][$above_below]['right'] ): 
			if($where == 'title') $clearfix[$where][$above_below] = ' clearfix-title';
			echo '<div class="meta-'.$above_below.'-'.$where.' entry-meta clearfix'.$clearfix[$where][$above_below].'">';
			if($meta[$where][$above_below]['left']): 
				echo '<div class="left">';
					echo $meta[$where][$above_below]['left'];
				echo '</div>';
			endif; 

			if($meta[$where][$above_below]['right'] && $small_posts == false): 
				echo '<div class="right">';
						echo $meta[$where][$above_below]['right'];
				echo '</div>';
			endif; 
			echo '</div>';
		endif; 
	
}





function headway_nofollow_links_in_post($text) {
	
	if(headway_get_write_box_value('nofollow_links')){
	
		preg_match_all("/<a.*? href=\"(.*?)\".*?>(.*?)<\/a>/i", $text, $links);
		$match_count = count($links[0]);
		for($i=0; $i < $match_count; $i++)
		{
			if(!preg_match("/rel=[\"\']*nofollow[\"\']*/",$links[0][$i]))
			{
				preg_match_all("/<a.*? href=\"(.*?)\"(.*?)>(.*?)<\/a>/i", $links[0][$i], $link_text);
				$text = str_replace(">".$link_text[3][0]."</a>"," rel='nofollow'>".$link_text[3][0]."</a>",$text);
			}
		}
		
		return $text;

	
	}
	else
	{
		return $text;
	}
}
add_action('the_content', 'headway_nofollow_links_in_post');