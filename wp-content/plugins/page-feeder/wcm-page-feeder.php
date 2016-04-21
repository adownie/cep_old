<?php
/*
Plugin Name: WCM Page Feeder
Plugin URI: http://paul.woodscreativemedia.com/
Description: Page Feeder lets you easily create and customise an RSS feed for your pages. Customize your feed using the settings page or via URL parameters.
Version: 1.3
Author: Paul Woods
Author URI: http://paul.woodscreativemedia.com

Copyright 2010, Paul Woods

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/

class wcm_page_feeds
{
	var $plugin_name	= "WCM Page Feeder";
	var $plugin_version	= "1.3";
	var $plugin_uri		= "http://paul.woodscreativemedia.com";
	var $options		= array();
	
	function __construct ()
	{
		/* Construct */
		add_action('get_header',array($this,'create'));
		add_action('admin_menu',array($this,'add_menu_pages'));
		$this->options = $this->options_load();
		$this->pages 	= array();
	}
	function add_menu_pages () 
	{
		/* Add menus */
		add_options_page($this->plugin_name,$this->plugin_name,'administrator','wcm-page-feeder.php',array($this,'options_page'));
	}
	function options_page ()
	{
		/* Options Page */
		$options = $this->options_load();
		if ($_POST["wcm_options_submit"])
		{
			$options = array (
			'max_pages'		=> 0+trim($_POST['pagefeeds_max_pages']),
			'parent'		=> trim($_POST['pagefeeds_parent']),
			'child_of'		=> trim($_POST['pagefeeds_child_of']),
			'sort_order'	=> trim($_POST['pagefeeds_sort_order']),
			'sort_column'	=> trim($_POST['pagefeeds_sort_column']),
			'authors'		=> trim($_POST['pagefeeds_authors'])
			);
			update_option("wcm_page_feeds",$options);
			echo '<div id="message" class="updated fade"><p>Page Feed Options Updated</p></div>';
		}
		if ($_POST["wcm_load_default"])
		{
			$options = $this->options_get_defaults();
			update_option("wcm_page_feeds",$options);
			echo '<div id="message" class="updated fade"><p>Page Defaults Reset</p></div>';
		} 
?>

<div class="wrap"><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

	<h2><?php echo $this->plugin_name;?> Options</h2>
	
	<table class="form-table">
		
		<tr><td valign="top" width="400">
			
			<p>These are the default settings for your <em>Page Feeder</em>. You can override these settings via 
			the URL if you wish so you have more options when using with feed readers etc. The correct 
			URL parameters are show in brackets next to the option name. How to call a feed:</p>
			
			<p>For a more detailed view of the get_pages() function see the 
			<a href="http://codex.wordpress.org/Function_Reference/get_pages" target="_blank">WP codex</a></p>
			
			<h3>Default</h3>
			<p>Uses the settings defined here.</p>
			<h4><a href="<?php bloginfo_rss('url'); ?>/?feedpages" target="_blank"><?php bloginfo_rss('url'); ?>/?feedpages</a></h4>
			
			<h3>Customise Via URL</h3>
			<p>Use URL parameters to override your default settings.</p>
			<h4><a href="<?php bloginfo_rss('url'); ?>/?feedpages&max=5&sort_order=ASC" target="_blank"><?php bloginfo_rss('url'); ?>/?feedpages&max=5&sort_order=ASC</a></h4>		

			<h3>Feed A Single Page</h3>
			<p>An example of how to feed a single page. Permalink structure will depend upon your WP preference.</p>
			<h4><?php bloginfo_rss('url'); ?>/company/info/?feedpage</h4>
			
		</td><td valign="top">
			
			<h2>Options:</h2>
			
			<h3>Max Pages (max)</h3>
			<p>Max number of pages to show in the feed.<br />(leave blank to show all)</p>
			<input name="pagefeeds_max_pages" type="text" size="5" id="pagefeeds_max_pages" value="<?php echo $options['max_pages']; ?>" />
			
			<h3>Parent (parent)</h3>
			<p>Display pages that have this ID as a parent. Enter 0 to return all top-level pages.<br />(leave blank to ignore)</p>
			<input name="pagefeeds_parent" type="text" size="5" value="<?php echo $options['parent']; ?>" />
			
			<h3>Child Of (child_of)</h3>
			<p>Show only pages that belong to the parent page ID includes grandchildren.<br />(leave blank to ignore)</p>
			<input name="pagefeeds_child_of" type="text" size="5" value="<?php echo $options['child_of']; ?>" />
			
			<h3>Sort Column (sort_column)</h3>
			<p>Sort your pages by which column?</p>
			<select name="pagefeeds_sort_column">
				<option value="post_title"<?php if ($options['sort_column'] == 'post_title') echo " selected"; ?>>Post Title</option>
				<option value="post_date"<?php if ($options['sort_column'] == 'post_date') echo " selected"; ?>>Post Date</option>
				<option value="post_modified"<?php if ($options['sort_column'] == 'post_modified') echo " selected"; ?>>Post Modified</option>
				<option value="menu_order"<?php if ($options['sort_column'] == 'menu_order') echo " selected"; ?>>Menu Order</option>
				<option value="post_author"<?php if ($options['sort_column'] == 'post_author') echo " selected"; ?>>Author</option>
				<option value="post_name"<?php if ($options['sort_column'] == 'post_name') echo " selected"; ?>>Post Name</option>
			</select>
			
			<h3>Sort Order (sort_order)</h3>
			<p>Valid URL values are ASC, DESC.</p>
			<select name="pagefeeds_sort_order">
				<option value="ASC"<?php if ($options['sort_order'] == 'ASC') echo " selected"; ?>>Ascending</option>
				<option value="DESC"<?php if ($options['sort_order'] == 'DESC') echo " selected"; ?>>Descending</option>
			</select>
			
			<h3>Authors (authors)</h3>
			<p>Only include pages by the given authors? i.e admin,paul,katie.<br />(leave blank to ignore)</p>
			<input name="pagefeeds_authors" type="text" size="50" value="<?php echo $options['authors']; ?>" />
			
		</td></tr>
		
	</table>
	
    <p class="submit">
      <input type="submit" name="wcm_load_default" value="Defaults" class="button" onclick="return confirm('Are you sure to reset options?')" />
      <input type="submit" name="wcm_options_submit" value="Save Settings" class="button" style="margin-left:10px;" />
    </p>
    
</form></div>

<?php
	}
	function options_load ()
	{
		/* Load options */
		$options = get_option("wcm_page_feeds");
		if (!$options) $options = $this->options_get_defaults();
		return $options;
	}
	function options_get_defaults ()
	{
		/* Set option defaults */
		$options = array(
		'max_pages'		=> 5,
		'parent'		=> '',
		'child_of'		=> '',
		'sort_order'	=> 'DESC',
		'sort_column'	=> 'post_title',
		'authors'		=> ''
		);
		return $options;
	}
	function _create ()
	{
		// Create RSS Feed
		header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
		$more = 1;
		$out = ob_get_contents();
		$out = str_replace(array("\n", "\r", "\t", " "), "", $input);
		ob_end_clean();
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>

<rss version="2.0">

<channel>

	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<language><?php echo get_option('rss_language'); ?></language>
	<?php do_action('rss_head'); ?>
	
	<?php
	foreach($this->pages as $page) {
	$content = apply_filters('the_content', $page->post_content);
	?>

	<item>
		<title><?php echo $page->post_title?></title>
		<pubDate><?php echo $page->post_date; ?></pubDate>
		<description><![CDATA[<? echo $content; ?>]]></description>
		<link><?php echo get_permalink($page->ID); ?></link>
		<?php do_action('rss_item'); ?>
	</item>
	
	<?php } ?>
	
</channel>
</rss>

<?php
	die();
	}
	function create ()
	{
		/* Create Pages Feed */
		$method = false;
		if (isset($_GET['feedpages'])) $method = 'all'; 
		if (isset($_GET['feedpage'])) $method = 'single';
		if (!$method) return;
		
		// URL arguments override object options
		$max = $this->options['max_pages'];
		if (isset($_GET['max'])) $max = 0+trim($_GET['max']);
		$parent = $this->options['parent'];
		if (isset($_GET['parent'])) $parent = trim($_GET['parent']);
		$child_of = $this->options['child_of'];
		if (isset($_GET['child_of'])) $child_of = 0+trim($_GET['child_of']);
		$sort_order = $this->options['sort_order'];
		if (isset($_GET['sort_order'])) $sort_order = trim($_GET['sort_order']);
		$sort_column = $this->options['sort_column'];
		if (isset($_GET['sort_column'])) $sort_column = trim($_GET['sort_column']);
		$authors = $this->options['authors'];
		if (isset($_GET['auhtors'])) $authors = trim($_GET['authors']);
		
		// Append arguments for WP get_pages()
		$args = array();
		if ($parent !== '') $args['parent'] = $parent;
		if ($child_of !== '') $args['child_of'] = $child_of;
		if ($sort_order) $args['sort_order'] = $sort_order;
		if ($sort_column) $args['sort_column'] = $sort_column;
		if ($authors) $args['authors'] = $authors;
		
		$pages = array();
		
		// Get Pages
		if ('all' == $method) {
			$pages = get_pages($args);
			if ($max) $pages = array_slice($pages,0,$max);
		}
		
		// Get the Page
		if ('single' == $method) {
			if (!have_posts()) die("No post data");
			while (have_posts()) : the_post();
				$pages[] = get_page(get_the_ID());
			endwhile;
		}
		
		$this->pages = $pages;
		$this->_create();
	}
}
$pagefeeds = new wcm_page_feeds();
?>