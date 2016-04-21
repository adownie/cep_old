<?php
/*
Plugin Name: Add RSS
Plugin URI: http://dancameron.org/wordpress/
Description: Add RSS Feeds to your template header for Firefox and other browsers to detect automatically. Plugin facilitates adding your comments feed, per-post comment feed and allows for custom RSS feeds to be added. <a href="options-general.php?page=Add-RSS.php">Configure >> </a>Feeds are not excluded to local RSS feeds of your site. Forexample you can add your Twitter or Pownce feed just as easily as adding a comments feed.
Version: 1.5
Author: Dan Cameron
Author URI: http://dancameron.org
*/

/*
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/


function add_rss_header() {

		$option_feed1   = get_option("option_feed1");
		$option_feed2   = get_option("option_feed2");
		$option_feed3   = get_option("option_feed3");
		$option_comment   = get_option("option_comment");
		$add_rss_feed1   = get_option("add_rss_1");
		$add_rss_feed2   = get_option("add_rss_2");
		$add_rss_feed3   = get_option("add_rss_3");
		$addrss1desc   = get_option("addrss1desc");
		$addrss2desc   = get_option("addrss2desc");
		$addrss3desc   = get_option("addrss3desc");
		$permalink_comments_rss = get_option("comment");

	?>

	<!-- Add RSS feeds -->
	<?php if( get_option('option_comment') == 'true') { ?>	
		<link rel="alternate" type="application/rss+xml" title="<?php
		bloginfo('name'); ?> RSS Comments Feed" href="<?php
		bloginfo('comments_rss2_url'); ?>" />
		<?php if (is_single()) { ?>
		<link rel="alternate" type="application/rss+xml" title="<?php
		the_title(); ?> RSS Comments Feed" href="<?php echo comments_rss();
		?>" />
		<?php } ?>
	<?php } ?>
	<?php if( get_option('option_feed1') == 'true') { ?>	
		<link rel="alternate" type="application/rss+xml" title="<?php echo get_option('addrss1desc'); ?>" href="<?php echo get_option('add_rss_1'); ?>" />
	<?php } ?>
	<?php if( get_option('option_feed2') == 'true') { ?>	
		<link rel="alternate" type="application/rss+xml" title="<?php echo get_option('addrss2desc'); ?>" href="<?php echo get_option('add_rss_2'); ?>" />
	<?php } ?>
	<?php if( get_option('option_feed3') == 'true') { ?>	
		<link rel="alternate" type="application/rss+xml" title="<?php echo get_option('addrss3desc'); ?>" href="<?php echo get_option('add_rss_3'); ?>" />
	<?php } ?>

	<!-- Add RSS (end) -->

<?php } // end add_rss_header()

//admin panel
function add_rss_adminPanel() {
		add_options_page('Add RSS', 'Add RSS', 10,
			basename(__FILE__), 'add_rss_optionsSubpanel');
}
function add_rss_optionsSubpanel() {
	if($_POST['action'] == "save") {
		echo "<div class=\"updated fade\" id=\"limitcatsupdatenotice\"><p>" . __("Configuration <strong>updated</strong>.") . "</p></div>";
		//updating stuff..
		update_option("add_rss_1", $_POST["addrss1"]);
		update_option("add_rss_2", $_POST["addrss2"]);
		update_option("add_rss_3", $_POST["addrss3"]);
		update_option("addrss1desc", $_POST["rss1desc"]);
		update_option("addrss2desc", $_POST["rss2desc"]);
		update_option("addrss3desc", $_POST["rss3desc"]);
		update_option("option_feed1", $_POST["optaddrss1"]);
		update_option("option_feed2", $_POST["optaddrss2"]);
		update_option("option_feed3", $_POST["optaddrss3"]);
		update_option("option_comment", $_POST["optcomment"]);
					
		$option_feed1   = get_option("option_feed1");
		$option_feed2   = get_option("option_feed2");
		$option_feed3   = get_option("option_feed3");
		$option_comment   = get_option("option_comment");
		$add_rss_feed1   = get_option("add_rss_1");
		$add_rss_feed2   = get_option("add_rss_2");
		$add_rss_feed3   = get_option("add_rss_3");
		$addrss1desc   = get_option("addrss1desc");
		$addrss2desc   = get_option("addrss2desc");
		$addrss3desc   = get_option("addrss3desc");
		$url = get_option("home");

	     }

		?>
		
		<div class="wrap">
			<h2>Add RSS Plugin Options</h2>
		<form method="post">
	    <fieldset class="options">
			
			
			<table class="optiontable">
					
					
			<tr valign="top">
			<th scope="row">
			<label for="commentopt">Add Site Comment Feed and <br/>per-post comment feed.</label>
			</th>
			<td>
			<input name="optcomment" type="checkbox" id="optcomment" value="true"  <?php if(get_option('option_comment') == 'true') { echo 'checked="true"'; } ?> />
			<br/><br/><br/><br/><br/>
			</td>
			</tr>
			
			
			<table class="optiontable">
				<h2>First Additional Feed</h2>
			<tr valign="top">
			<th scope="row">
			<label for="rssone">Use this additional feed</label>
			</th>
			<td>
			<input name="optaddrss1" type="checkbox" id="optaddrss1" value="true"  <?php if(get_option('option_feed1') == 'true') { echo 'checked="true"'; } ?> />
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rssonedesc">First RSS Label</label>
			</th>
			<td>
			<input type="text" name="rss1desc" size="10" value="<?php echo get_option('addrss1desc'); ?>"><br>(example: "RSS 2.0 - Comments" )
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rssoneurl">Add the first additional RSS Feed</label>
			</th>
			<td>
			<input type="text" name="addrss1" size="30" value="<?php echo get_option('add_rss_1'); ?>"><br> (example: "comments/feed/" or "http://feeds.dancameron.org/dancameron"" )<br/><br/>
			</td>
			</tr>
			
			
			
			
			<table class="optiontable">
					
				<h2>Second</h2>	
			<tr valign="top">
			<th scope="row">
			<label for="rssone">Use this additional feed</label>
			</th>
			<td>
			<input name="optaddrss2" type="checkbox" id="optaddrss2" value="true"  <?php if(get_option('option_feed2') == 'true') { echo 'checked="true"'; } ?> />
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rsstwodesc">RSS Label</label>
			</th>
			<td>
			<input type="text" name="rss2desc" size="10" value="<?php echo get_option('addrss2desc'); ?>">
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rsstwourl">Second RSS URI</label>
			</th>
			<td>
			<input type="text" name="addrss2" size="30" value="<?php echo get_option('add_rss_2'); ?>">
			<br/><br/> 
			</td>
			</tr>
			
			
			
			<table class="optiontable">
					
					<h2>Third</h2>
			<tr valign="top">
			<th scope="row">
			<label for="rss3">Use this additional feed</label>
			</th>
			<td>
			<input name="optaddrss3" type="checkbox" id="optaddrss3" value="true"  <?php if(get_option('option_feed3') == 'true') { echo 'checked="true"'; } ?> />
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rss3desc">RSS Label</label>
			</th>
			<td>
			<input type="text" name="rss3desc" size="10" value="<?php echo get_option('addrss3desc'); ?>">
			<br/>
			</td>
			</tr>

			<tr valign="top">
			<th scope="row">
			<label for="rss3url">Third RSS URI</label>
			</th>
			<td>
			<input type="text" name="addrss3" size="30" value="<?php echo get_option('add_rss_3'); ?>">
			<br/><br/> 
			</td>
			</tr>
		
		</table>
	    </fieldset>
		<a name="submit">
		<fieldset class="options">
		<div class="submit">
		<input type="hidden" name="action" value="save">
		<input type="submit" value="Save">
		</div>
		</fieldset>
		</form>
		<br><br>
	
	</div>
		<?php } // end add_rss_optionsSubpanel()

//user hooks
add_action('wp_head', 'add_rss_header');


//admin hooks
add_action('admin_menu', 'add_rss_adminPanel');

?>
