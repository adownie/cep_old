<?php

function visual_editor_sidebar(){
	global $close_url;
?>
	<div id="visual-editor-menu">
		<ul>
			<li class="bold">
				<a href="#" class="no-link">Headway</a>
				
				<ul>
					<li><a href="<?php echo str_replace('&safe-mode=true', '', headway_current_url()) ?>" class="keep-active no-overlay">Reload Visual Editor</a></li>
					<li><a href="<?php echo $close_url ?>" id="close-editor" class="no-link">Close Visual Editor</a></li>
				</ul>
			</li>
		
			<li>
				<a href="#" class="no-link">Linking</a>
				
				<ul>
					<li><a href="#" id="linking-options" class="no-overlay">Linking Options</a></li>
					<li><a href="#" id="save-and-link">Save and Link</a></li>
				</ul>
			</li>
		
			<li>
				<a href="#" class="no-link">Tools</a>
				
				<ul>					
					<?php if(!headway_get_option('disable-visual-editor') && !headway_get_option('enable-developer-mode') && !headway_get_option('active-skin') && (headway_user_level() >= headway_get_option('permissions-visual-design-editor') || current_user_can('manage_options'))){ ?>
					
					<li><a href="#" id="mass-font-change" class="no-overlay">Mass Font Change</a></li>
					<li><a href="#" id="export-window" class="no-overlay">Export Style</a></li>
					
					<?php } ?>
					
					<li><a href="#" id="live-css" class="no-overlay">Live CSS Editor</a></li>
				</ul>
			</li>
		
			<li>
				<a href="#" id="help" class="no-overlay">Help</a>
			</li>
			
			<li>
				<a href="<?php echo get_bloginfo('wpurl') ?>/wp-admin" class="keep-active no-overlay" target="_blank">WordPress Admin</a>
			</li>
		</ul>
	</div>
	
	<div id="visual-editor-sidebar">
		<div id="visual-editor-sidebar-content">	
				
			<?php 
			if(!headway_get_option('disable-visual-editor') && !headway_get_option('enable-developer-mode') && !headway_is_skin_active() && (headway_user_level() >= headway_get_option('permissions-visual-design-editor') || current_user_can('manage_options'))) 
				create_visual_editor_widget('design-editor', 'Design Editor', 'visual_editor_content'); 
				
			if(headway_user_level() >= headway_get_option('permissions-visual-design-editor') || current_user_can('manage_options')) 
				create_visual_editor_widget('templates', 'Templates', 'templates_content');
			
			if(headway_user_level() >= headway_get_option('permissions-leafs') || current_user_can('manage_options')) 
				create_visual_editor_widget('leafs', 'Leafs', 'leafs_panel_content');
			
			if(headway_user_level() >= headway_get_option('permissions-site-configuration') || current_user_can('manage_options')) 
				create_visual_editor_widget('site-configuration', 'Site Configuration', 'site_configuration_content');
				
			if(headway_user_level() >= headway_get_option('permissions-navigation') || current_user_can('manage_options')) 
				create_visual_editor_widget('navigation', 'Navigation', 'navigation_panel_content'); 
				
			create_visual_editor_widget_break();
			?>
				
		</div>
		
		
		<a id="visual-editor-sidebar-toggle"></a>
	</div>
	
<?php
}