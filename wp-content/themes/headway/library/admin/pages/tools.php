<h2 class="nav-tab-wrapper big-tabs-tabs">
	<a class="nav-tab" href="#tab-system-info">System Info</a>
	<a class="nav-tab" href="#tab-reset">Reset</a>
</h2>

<?php do_action('headway_admin_save_message'); ?>


<div class="big-tabs-container">
			
	<div class="big-tab" id="tab-system-info-content">
						
		<div id="system-info">
				
			<h3 class="title" style="margin-bottom: 10px;"><strong>System Info</strong></h3>

			<p class="description">
				Copy and paste this information into support/forums if requested.
				<br /><br />
				<strong>Please copy all of the content in the text area below and paste it as-is in the requested forum discussion.</strong>
			</p>
			
			<?php
			$browser = headway_get_browser();

			if ( !headway_get('exclude-counts') ) {
				$post_count = wp_count_posts('post');
				$page_count = wp_count_posts('page');
			}
			?>

<textarea readonly="readonly" id="system-info-textarea" title="To copy the system info, click below then press Ctrl + C (PC) or Cmd + C (Mac).">

    ### Begin System Info ###

	Child Theme:		<?php echo HEADWAY_CHILD_THEME_ACTIVE ? (function_exists('wp_get_theme') ? wp_get_theme() : get_current_theme()) . "\n" : "N/A\n" ?>

    Multi-site: 		<?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>
	
    SITE_URL:  			<?php echo site_url() . "\n"; ?>
    HOME_URL:			<?php echo home_url() . "\n"; ?>
    	
    Headway Version:  	<?php echo HEADWAY_VERSION . "\n"; ?>
    WordPress Version:	<?php echo get_bloginfo('version') . "\n"; ?>
    
    PHP Version:		<?php echo PHP_VERSION . "\n"; ?>
    MySQL Version:		<?php echo mysql_get_server_info() . "\n"; ?>
    Web Server Info:	<?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>
    GD Support:			<?php echo function_exists('gd_info') ? "Yes\n" : "***WARNING*** No\n"; ?>
    
    PHP Memory Limit:	<?php echo ini_get('memory_limit') . "\n"; ?>
    PHP Post Max Size:	<?php echo ini_get('post_max_size') . "\n"; ?>
    
    WP_DEBUG: 			<?php echo defined('WP_DEBUG') ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>
    Debug Mode: 		<?php echo HeadwayOption::get('debug-mode', false, false) ? 'Enabled' . "\n" : 'Disabled' . "\n" ?>
    
	Show On Front: 		<?php echo get_option('show_on_front') . "\n" ?>
	Page On Front: 		<?php echo get_option('page_on_front') . "\n" ?>
	Page For Posts: 	<?php echo get_option('page_for_posts') . "\n" ?>

	<?php
	if ( !headway_get('exclude-counts') ):
	?>
	Amount of Posts:	~<?php echo $post_count->publish . "\n" ?>
	Amount of Pages:	~<?php echo $page_count->publish . "\n" ?>
	Amount of Blocks: 	~<?php echo count(HeadwayBlocksData::get_all_blocks()) . "\n" ?>
	<?php
	endif;
	?>
    
    Responsive Grid: 	<?php echo HeadwayResponsiveGrid::is_enabled() ? 'Enabled' . "\n" : 'Disabled' . "\n" ?>
    
    Caching Allowed: 	<?php echo HeadwayCompiler::can_cache() ? 'Yes' . "\n" : 'No' . "\n"; ?>
    Caching Enabled: 	<?php echo HeadwayCompiler::caching_enabled() ? 'Yes' . "\n" : 'No' . "\n"; ?>
    Caching Plugin: 	<?php echo HeadwayCompiler::is_plugin_caching() ? HeadwayCompiler::is_plugin_caching() . "\n" : 'No caching plugin active' . "\n" ?>
    
	SEO Plugin: 		<?php echo HeadwaySEO::plugin_active() ? HeadwaySEO::plugin_active() . "\n" : 'No SEO plugin active' . "\n" ?>

    Operating System:	<?php echo ucwords($browser['platform']) . "\n"; ?>
    Browser:			<?php echo $browser['name'] . "\n"; ?>
    Browser Version:	<?php echo $browser['version'] . "\n"; ?>
    
    Full User Agent:
    <?php echo $browser['userAgent'] . "\n"; ?>


    WEB FONTS IN USE:
<?php
$webfonts_in_use = HeadwayWebFontsLoader::get_fonts_in_use();

if ( is_array($webfonts_in_use) && count($webfonts_in_use) ) {

	foreach ( $webfonts_in_use as $provider => $fonts )
		foreach ( $fonts as $font )
			echo '    ' . $provider . ': ' . $font . "\n";

} else {

	echo '    None' . "\n";

}
?>
    
    
    ACTIVE PLUGINS:
<?php
$plugins = get_plugins();
$active_plugins = get_option('active_plugins', array());

if ( is_array($active_plugins) && count($active_plugins) ) {

	foreach ( $plugins as $plugin_path => $plugin ) {
		
		//If the plugin isn't active, don't show it.
		if ( !in_array($plugin_path, $active_plugins) )
			continue;
		
		echo '    ' . $plugin['Name'] . ' ' . $plugin['Version'] . "\n";
		
		if ( isset($plugin['PluginURI']) )
			echo '    ' . $plugin['PluginURI'] . "\n";
			
		echo "\n";
		
	}

} else {

	echo '    None' . "\n\n";

}
?>
    ### End System Info ###

</textarea>

		</div><!-- #system-info -->

	</div><!-- #tab-system-info-content -->

	<div class="big-tab" id="tab-reset-content">
			
		<?php
		if ( !isset($GLOBALS['headway_reset_success']) || $GLOBALS['headway_reset_success'] == false ) {
		?>
		<div class="alert-red reset-alert alert">
			<h3>Warning</h3>
			
			<p>Clicking the <em>Reset</em> button below will delete <strong>ALL</strong> existing Headway data including, but not limited to: Blocks, Design Settings, and Headway Search Engine Optimization settings.</p>
			
			<form method="post" id="reset-headway">
				<input type="hidden" value="<?php echo wp_create_nonce('headway-reset-nonce'); ?>" name="headway-reset-nonce" id="headway-reset-nonce" />
				
				<input type="submit" value="Reset Headway" class="button alert-big-button" name="reset-headway" id="reset-headway-submit" />
			</form><!-- #reset -->
		</div>	
		<?php
		}
		?>
		
	</div><!-- #tab-reset-content -->
		
</div>