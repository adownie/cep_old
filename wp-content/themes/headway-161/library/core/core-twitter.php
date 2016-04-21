<?php
/**
 * Twitter Helper Functions
 *
 * @package Headway
 * @subpackage Twitter
 * @author Clay Griffiths
 **/


/**
 * Shortens a URL using is.gd
 *
 * @param string $url The URL to be shortened.
 * 
 * @return string If cURL exists, then a shortened URL is returned, otherwise the original URL is simply fed back.
 **/
function headway_shorten_url($url){
	if(function_exists('curl_init')){
	
		$query = 'http://is.gd/api.php?longurl='.$url;
	
		$init = curl_init();
		curl_setopt($init, CURLOPT_URL, $query);
		curl_setopt($init, CURLOPT_RETURNTRANSFER, 1);
		$shortened_url = curl_exec($init);
		curl_close($init);
	
		return $shortened_url;
	
	} else {
	
		return $url;
	
	}
}

/**
 * Retrieves the latest Twitter updates.  Must have PHP 5.2 or higher.
 *
 * @param string $twitter_username Twitter username to fetch.
 * @param int $limit Amount of tweets to retrieve.
 * @param string $date_format The date format for the timestamps.
 * 
 * @return void
 **/
function headway_get_twitter_updates($twitter_username, $limit = 10, $date_format = "F j, Y \&\m\d\a\s\h\; g:i a"){

	if(version_compare(PHP_VERSION, '5.2.0') === 1){
		$timeline = "http://twitter.com/statuses/user_timeline/$twitter_username.rss";
		$timeline_rss = wp_remote_fopen($timeline);

		if($timeline_rss)
		{
		
			$tweets_object = @simplexml_load_string($timeline_rss);
				
			if($tweets_object)
			{
				if($tweets_object->channel->item){
					foreach($tweets_object->channel->item as $tweet)
					{
						if ($i++ >= $limit) { break; } 
						echo '<li>'.substr($tweet->description, strlen($twitter_username)+2);
						echo '<span>'.date($date_format, strtotime($tweet->pubDate)).'</span></li>';
					}
				}
				else
				{
					'Eek! There was an error fetching the Twitter feed.';
				}
			}
			else
			{
				echo 'Error!  RSS file is invalid.';
			}
		}
		else
		{
			echo 'Error.  Twitter stream not found. Make sure you entered a valid username.';
		}
	} else {
		echo 'Error.  You must be running at least PHP 5.2 to use the Headway Twitter functionality.';
	}

}


/**
 * Sets the Twitter status of a user.
 *
 * @param string $username
 * @param string $password
 * @param string $message
 * 
 * @return bool True if cURL exists and the tweet is sent.  False if cURL doesn't exist.
 **/
function headway_set_twitter_status($username, $password, $message){
	$url = 'http://twitter.com/statuses/update.xml';
	
	if(function_exists('curl_init')){
		$handle = curl_init();
		
		curl_setopt($handle, CURLOPT_URL, "$url");
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, "status=$message");
		curl_setopt($handle, CURLOPT_USERPWD, "$username:$password");
		
		$buffer = curl_exec($handle);
		
		curl_close($handle);
		
		return true;
	} else {
		return false;
	}
	
}


/**
 * Sends the latest post to Twitter if the user chooses to do so.
 *
 * @uses headway_set_twitter_status()
 * 
 * @param int $post_ID Post ID
 * @param object $post Post object
 * 
 * @return void
 **/
function headway_post_to_twitter($post_ID, $post){
	if(!get_post_meta($post_ID, '_published', true)){
		if(headway_get_option('twitter-username') && headway_get_option('twitter-password') && headway_get_option('tweet-format')){
	
			$url = headway_shorten_url(get_permalink($post_ID));
			$postname = get_the_title($post_ID);
			$blogname = get_bloginfo('name');
		
			$format = headway_get_option('tweet-format');
			$format = str_replace('%url%', $url, $format);
			$format = str_replace('%postname%', html_entity_decode($postname), $format);
			$format = str_replace('%blogname%', html_entity_decode($blogname), $format);
		
			if(headway_get_write_box_value('post_to_twitter', false, $post_ID) == '1' || headway_get_option('post-to-twitter')){
				if(headway_get_write_box_value('post_to_twitter', false, $post_ID) != '0'){
			    	headway_set_twitter_status(headway_get_option('twitter-username'), headway_get_option('twitter-password'), $format);
				}
			}
			
		}
		
		update_post_meta($post_ID, '_published', 'true');
	}
}